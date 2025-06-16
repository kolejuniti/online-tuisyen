<?php

require 'vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if Linode configuration is set
echo "Checking Linode Configuration:\n";
echo "LINODE_ACCESS_KEY_ID: " . (getenv('LINODE_ACCESS_KEY_ID') ? "Set" : "Not set") . "\n";
echo "LINODE_SECRET_ACCESS_KEY: " . (getenv('LINODE_SECRET_ACCESS_KEY') ? "Set" : "Not set") . "\n";
echo "LINODE_REGION: " . (getenv('LINODE_REGION') ?: "Not set") . "\n";
echo "LINODE_BUCKET: " . (getenv('LINODE_BUCKET') ?: "Not set") . "\n";
echo "LINODE_ENDPOINT: " . (getenv('LINODE_ENDPOINT') ?: "Not set") . "\n";
echo "LINODE_URL: " . (getenv('LINODE_URL') ?: "Not set") . "\n";

echo "\nYou can run this file to verify that your environment variables are properly set.\n";
echo "To test Linode storage in your Laravel app, you can run: php artisan tinker\n";
echo "Then in tinker, try: Storage::disk('linode')->put('test.txt', 'Hello Linode!');\n"; 