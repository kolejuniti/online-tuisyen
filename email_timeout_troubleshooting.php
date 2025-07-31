<?php
/**
 * Email Connection Troubleshooting Script
 * Run this script on your live server to diagnose email connection issues
 * 
 * Usage: php email_timeout_troubleshooting.php
 */

echo "=== Email Connection Troubleshooting ===\n\n";

// Test 1: Check if we can resolve Mailjet's hostname
echo "1. Testing DNS resolution for Mailjet...\n";
$mailjetHost = 'in-v3.mailjet.com';
$ip = gethostbyname($mailjetHost);
if ($ip !== $mailjetHost) {
    echo "✅ DNS resolution successful: {$mailjetHost} -> {$ip}\n\n";
} else {
    echo "❌ DNS resolution failed for {$mailjetHost}\n\n";
}

// Test 2: Check port connectivity
echo "2. Testing port connectivity to Mailjet...\n";
$ports = [587, 2525, 25, 465, 588];

foreach ($ports as $port) {
    echo "Testing port {$port}... ";
    $connection = @fsockopen($mailjetHost, $port, $errno, $errstr, 10);
    if ($connection) {
        echo "✅ OPEN\n";
        fclose($connection);
    } else {
        echo "❌ BLOCKED (Error: {$errno} - {$errstr})\n";
    }
}

echo "\n";

// Test 3: Check current environment configuration
echo "3. Current environment configuration:\n";
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    
    // Extract email-related settings
    $emailSettings = [];
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (preg_match('/^(MAIL_|MAILJET_)/', trim($line))) {
            $emailSettings[] = trim($line);
        }
    }
    
    if (!empty($emailSettings)) {
        foreach ($emailSettings as $setting) {
            // Hide sensitive values
            if (strpos($setting, 'KEY') !== false || strpos($setting, 'PASSWORD') !== false) {
                $parts = explode('=', $setting, 2);
                if (isset($parts[1])) {
                    $setting = $parts[0] . '=' . str_repeat('*', min(8, strlen($parts[1])));
                }
            }
            echo "  {$setting}\n";
        }
    } else {
        echo "  No email configuration found in .env file\n";
    }
} else {
    echo "  .env file not found\n";
}

echo "\n";

// Test 4: Check server information
echo "4. Server information:\n";
echo "  PHP Version: " . PHP_VERSION . "\n";
echo "  Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "  User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'CLI') . "\n";

// Check if this is a shared hosting environment
$isSharedHosting = false;
$hostingIndicators = ['cpanel', 'shared', 'hostgator', 'bluehost', 'godaddy'];
$serverSoftware = strtolower($_SERVER['SERVER_SOFTWARE'] ?? '');
foreach ($hostingIndicators as $indicator) {
    if (strpos($serverSoftware, $indicator) !== false) {
        $isSharedHosting = true;
        break;
    }
}

if ($isSharedHosting) {
    echo "  Environment: Shared hosting detected\n";
    echo "  Recommendation: Use port 2525 or 588\n";
} else {
    echo "  Environment: VPS/Dedicated server\n";
}

echo "\n";

// Test 5: Recommendations
echo "5. Troubleshooting recommendations:\n";

// Find blocked ports
$blockedPorts = [];
$openPorts = [];
foreach ($ports as $port) {
    $connection = @fsockopen($mailjetHost, $port, $errno, $errstr, 5);
    if ($connection) {
        $openPorts[] = $port;
        fclose($connection);
    } else {
        $blockedPorts[] = $port;
    }
}

if (!empty($openPorts)) {
    echo "✅ Available ports: " . implode(', ', $openPorts) . "\n";
    echo "   Update your .env file to use one of these ports:\n";
    foreach ($openPorts as $port) {
        if ($port == 465) {
            echo "   MAILJET_PORT={$port} (with MAILJET_ENCRYPTION=ssl)\n";
        } else {
            echo "   MAILJET_PORT={$port} (with MAILJET_ENCRYPTION=tls)\n";
        }
    }
} else {
    echo "❌ All standard SMTP ports are blocked\n";
    echo "   Contact your hosting provider about SMTP access\n";
}

if (!empty($blockedPorts)) {
    echo "❌ Blocked ports: " . implode(', ', $blockedPorts) . "\n";
}

echo "\n";

// Test 6: Generate recommended .env configuration
if (!empty($openPorts)) {
    echo "6. Recommended .env configuration:\n";
    $recommendedPort = $openPorts[0]; // Use first available port
    $encryption = ($recommendedPort == 465) ? 'ssl' : 'tls';
    
    echo "# Replace these lines in your .env file:\n";
    echo "MAIL_MAILER=mailjet\n";
    echo "MAILJET_HOST=in-v3.mailjet.com\n";
    echo "MAILJET_PORT={$recommendedPort}\n";
    echo "MAILJET_ENCRYPTION={$encryption}\n";
    echo "MAILJET_API_KEY=your_api_key_here\n";
    echo "MAILJET_SECRET_KEY=your_secret_key_here\n";
    echo "\n";
}

echo "=== End of Troubleshooting ===\n";
echo "\nNext steps:\n";
echo "1. Update your .env file with recommended settings\n";
echo "2. Run: php artisan config:clear\n";
echo "3. Test email sending again\n";
echo "4. Check Laravel logs: storage/logs/laravel.log\n";
?>