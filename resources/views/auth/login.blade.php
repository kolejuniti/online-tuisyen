<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Online Tuition Platform">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>eTuition - Learn Without Limits</title>
  
  <!-- External CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
    :root {
  --primary: #6366f1;
  --primary-light: #818cf8;
  --primary-dark: #4f46e5;
  --secondary: #0ea5e9;
  --secondary-light: #38bdf8;
  --accent: #f472b6;
  --light: #f8fafc;
  --dark: #0f172a;
  --text-primary: #1e293b;
  --text-secondary: #64748b;
  --bg-gradient: linear-gradient(135deg, #6366f1, #0ea5e9, #8b5cf6);
  --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  --border-radius: 16px;
  --card-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
  --input-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  --button-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--dark);
  position: relative;
  overflow: hidden;
  padding: 2rem;
  perspective: 1000px;
}

/* Background Animation */
.background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
}

.bg-shapes {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.shape {
  position: absolute;
  filter: blur(80px);
  opacity: 0.5;
  border-radius: 50%;
  animation: float 20s infinite alternate ease-in-out;
}

.shape-1 {
  background: var(--primary);
  width: 500px;
  height: 500px;
  top: -200px;
  left: -100px;
  animation-delay: 0s;
}

.shape-2 {
  background: var(--secondary);
  width: 600px;
  height: 600px;
  bottom: -200px;
  right: -100px;
  animation-delay: 5s;
}

.shape-3 {
  background: var(--accent);
  width: 300px;
  height: 300px;
  bottom: 10%;
  left: 20%;
  animation-delay: 10s;
}

/* Stars */
.stars {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.star {
  position: absolute;
  background: white;
  border-radius: 50%;
  opacity: 0;
  animation: twinkle var(--duration, 4s) infinite var(--delay, 0s) ease-in-out;
}

/* Login Container */
.login-container {
  width: 100%;
  max-width: 480px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  border-radius: var(--border-radius);
  box-shadow: var(--card-shadow);
  overflow: hidden;
  transform-style: preserve-3d;
  transform: translateZ(0) rotateX(0deg) rotateY(0deg);
  transition: transform 0.8s ease;
  border: 1px solid rgba(255, 255, 255, 0.2);
  opacity: 0;
  animation: appear 1s forwards 0.5s;
}

@keyframes appear {
  from {
    opacity: 0;
    transform: translateY(30px) translateZ(0) rotateX(5deg);
  }
  to {
    opacity: 1;
    transform: translateY(0) translateZ(0) rotateX(0deg);
  }
}

.login-container:hover {
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
}

.login-header {
  padding: 2.5rem 2.5rem 1.5rem;
  text-align: center;
  position: relative;
}

.logo-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-bottom: 1.5rem;
  transform: scale(1);
  transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.logo-container:hover {
  transform: scale(1.05);
}

.logo-img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 12px;
  background: var(--bg-gradient);
  padding: 8px;
  box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.5);
  animation: pulse 3s infinite;
}

/* Specific styling for the first logo (pkibs) */
.logo-img:first-child {
  width: 100px;
  height: 65px;
  object-fit: contain;
  background: white;
  border: 2px solid #e5e7eb;
  box-shadow: 0 4px 8px -2px rgba(0, 0, 0, 0.1);
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.5);
  }
  70% {
    box-shadow: 0 0 0 15px rgba(99, 102, 241, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
  }
}

.logo-text {
  font-size: 2.0rem;
  font-weight: 700;
  line-height: 1;
  position: relative;
}

.logo-text span {
  display: inline-block;
  transition: var(--transition);
}

.logo-text span:first-child {
  color: var(--text-primary);
}

.logo-text span:not(:first-child) {
  background: var(--bg-gradient);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  animation: colorShift 8s infinite alternate;
}

@keyframes colorShift {
  0% {
    filter: hue-rotate(0deg);
  }
  100% {
    filter: hue-rotate(90deg);
  }
}

.welcome-text {
  color: var(--text-secondary);
  font-weight: 500;
  font-size: 1.1rem;
  margin-bottom: 2rem;
  opacity: 0;
  animation: fadeInUp 0.8s forwards 0.8s;
}

/* Tab Switcher */
.tab-switcher {
  display: flex;
  margin-bottom: 2rem;
  position: relative;
  background: rgba(241, 245, 249, 0.7);
  border-radius: 50px;
  padding: 5px;
  max-width: 350px;
  margin-left: auto;
  margin-right: auto;
  box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
  transform: translateY(20px);
  opacity: 0;
  animation: fadeInUp 0.8s forwards 1s;
}

.tab-btn {
  background: transparent;
  border: none;
  padding: 12px 0;
  width: 50%;
  border-radius: 50px;
  font-weight: 600;
  font-size: 0.95rem;
  color: var(--text-secondary);
  transition: color 0.3s ease;
  position: relative;
  z-index: 2;
  cursor: pointer;
}

.tab-btn.active {
  color: white;
}

.tab-slider {
  position: absolute;
  height: calc(100% - 10px);
  width: calc(50% - 5px);
  background: var(--bg-gradient);
  border-radius: 50px;
  top: 5px;
  left: 5px;
  transition: left 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
  z-index: 1;
  box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4);
}

.tab-slider.right {
  left: calc(50% + 0px);
}

/* Login Body */
.login-body {
  padding: 0 2.5rem 2.5rem;
}

.tab-content {
  display: none;
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}

.tab-content.active {
  display: block;
  animation: fadeInUp 0.8s forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Form Styling */
.form-group {
  margin-bottom: 1.8rem;
  position: relative;
}

.form-control {
  width: 100%;
  padding: 14px 20px 14px 60px;
  font-size: 1rem;
  border: none;
  border-radius: 12px;
  background: rgba(241, 245, 249, 0.7);
  color: var(--text-primary);
  font-family: 'Poppins', sans-serif;
  letter-spacing: 0.3px;
  transition: all 0.4s ease;
  backdrop-filter: blur(5px);
  box-shadow: var(--input-shadow);
}

.form-control::placeholder {
  color: transparent;
}

.form-control:focus {
  outline: none;
  background: rgba(241, 245, 249, 0.9);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
}

.input-icon {
  position: absolute;
  left: 22px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.2rem;
  color: var(--primary);
  transition: all 0.4s ease;
  z-index: 2;
}

.form-control:focus + .input-icon {
  color: var(--primary-dark);
  transform: translateY(-50%) scale(1.1);
}

/* Form Floating Label */
.form-floating {
  position: relative;
}

.form-floating label {
  position: absolute;
  left: 60px;
  top: 14px;
  color: var(--text-secondary);
  transition: all 0.3s ease;
  pointer-events: none;
  font-size: 0.95rem;
}

.form-floating input:focus ~ label,
.form-floating input:not(:placeholder-shown) ~ label {
  transform: translateY(-24px) translateX(-40px) scale(0.85);
  color: var(--primary-dark);
  font-weight: 600;
  background: linear-gradient(120deg, var(--primary), var(--secondary));
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Remember Me & Forgot Password */
.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  opacity: 0;
  animation: fadeInUp 0.8s forwards 1.2s;
}

.form-check {
  display: flex;
  align-items: center;
}

.form-check-input {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 20px;
  height: 20px;
  background: rgba(241, 245, 249, 0.7);
  border-radius: 6px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  position: relative;
  transition: all 0.3s ease;
  margin-right: 8px;
}

.form-check-input:checked {
  background: var(--bg-gradient);
}

.form-check-input:checked::after {
  content: '✓';
  color: white;
  font-size: 12px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.form-check-label {
  font-size: 0.9rem;
  color: var(--text-secondary);
  cursor: pointer;
  transition: color 0.3s ease;
}

.form-check-input:checked ~ .form-check-label {
  color: var(--primary-dark);
}

.forgot-link {
  color: var(--primary);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.3s ease;
  background: linear-gradient(120deg, var(--primary), var(--secondary));
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  position: relative;
}

.forgot-link:after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 0;
  height: 2px;
  background: var(--bg-gradient);
  transition: width 0.3s ease;
}

.forgot-link:hover:after {
  width: 100%;
}

/* Submit Button */
.submit-btn {
  width: 100%;
  padding: 15px 20px;
  border: none;
  border-radius: 12px;
  background: var(--bg-gradient);
  color: white;
  font-size: 1rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  cursor: pointer;
  box-shadow: var(--button-shadow);
  transition: all 0.5s ease;
  position: relative;
  overflow: hidden;
  transform: translateY(20px);
  opacity: 0;
  animation: fadeInUp 0.8s forwards 1.4s;
}

.submit-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.5);
}

.submit-btn:active {
  transform: translateY(0);
}

.submit-btn:before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.2),
    transparent
  );
  transition: 0.5s;
}

.submit-btn:hover:before {
  left: 100%;
}

/* Error Message */
.error-container {
  background: rgba(254, 226, 226, 0.7);
  border-radius: 10px;
  padding: 12px 16px;
  margin-bottom: 1.5rem;
  border-left: 4px solid #dc2626;
  backdrop-filter: blur(4px);
  animation: shake 0.5s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-5px); }
  40%, 80% { transform: translateX(5px); }
}

.error-container ul {
  margin: 0;
  padding-left: 1.5rem;
  color: #b91c1c;
}

/* Toggle Password */
.toggle-password {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--primary);
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 2;
}

.toggle-password:hover {
  color: var(--primary-dark);
}

/* Animations */
@keyframes float {
  0% {
    transform: translateY(0) translateX(0);
  }
  50% {
    transform: translateY(-20px) translateX(10px);
  }
  100% {
    transform: translateY(0) translateX(0);
  }
}

@keyframes twinkle {
  0%, 100% {
    opacity: 0;
    transform: scale(0.5);
  }
  50% {
    opacity: 0.8;
    transform: scale(1);
  }
}

/* Wave animation for logo text */
.logo-text span {
  animation-name: wave;
  animation-duration: 3s;
  animation-iteration-count: infinite;
  animation-timing-function: ease-in-out;
}

.logo-text span:nth-child(1) { animation-delay: 0.0s; }
.logo-text span:nth-child(2) { animation-delay: 0.1s; }
.logo-text span:nth-child(3) { animation-delay: 0.2s; }
.logo-text span:nth-child(4) { animation-delay: 0.3s; }
.logo-text span:nth-child(5) { animation-delay: 0.4s; }
.logo-text span:nth-child(6) { animation-delay: 0.5s; }

@keyframes wave {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

/* Loading spinner */
.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 0.8s ease-in-out infinite;
  margin-right: 8px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 576px) {
  body {
    padding: 1rem;
  }

  .login-container {
    max-width: 95%;
  }

  .login-header, .login-body {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }

  .form-control {
    padding-left: 50px;
  }

  .form-floating label {
    left: 50px;
  }

  .form-options {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .forgot-link {
    align-self: flex-end;
  }

  /* Mobile logo adjustments */
  .logo-container {
    gap: 8px;
    margin-bottom: 1rem;
  }

  .logo-img {
    width: 45px;
    height: 45px;
  }

  .logo-img:first-child {
    width: 70px;
    height: 45px;
  }

  .logo-text {
    font-size: 1.8rem;
  }

  .welcome-text {
    font-size: 1rem;
    margin-bottom: 1.5rem;
  }
}

/* Focus Indicator */
.focus-indicator {
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 3px;
  background: var(--bg-gradient);
  transition: all 0.4s ease;
  border-radius: 10px;
}

.form-control:focus ~ .focus-indicator {
  width: 80%;
  left: 10%;
}

/* Password strength indicator */
.password-strength {
  height: 5px;
  border-radius: 3px;
  width: 100%;
  background: #e5e7eb;
  margin-top: 8px;
  position: relative;
  overflow: hidden;
  display: none;
}

.password-strength-bar {
  height: 100%;
  width: 0;
  border-radius: 3px;
  transition: all 0.3s ease;
  background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981);
}

/* Modified responsive stars effect */
.star {
  position: absolute;
  background: white;
  border-radius: 50%;
  opacity: 0;
}
  </style>
</head>

<body>
  <!-- Background elements -->
  <div class="background">
    <div class="bg-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>
    <div class="stars" id="stars"></div>
  </div>
  
  <div class="login-container" id="loginContainer">
    <div class="login-header">
      <div class="logo-container" id="logoContainer">
        <img src="assets/images/logo/pkibs.png" alt="eTuition Logo" class="logo-img">
        <div class="logo-text">
          <span>e</span>
          <span>T</span>
          <span>u</span>
          <span>i</span>
          <span>t</span>
          <span>i</span>
          <span>o</span>
          <span>n</span>
        </div>
        <img src="assets/images/logo/Kolej-UNITI.png" alt="eTuition Logo" class="logo-img">
      </div>
      
      <h5 class="welcome-text">Welcome back! Sign in to continue learning</h5>
      
      <div class="tab-switcher">
        <span class="tab-slider" id="tabSlider"></span>
        <button class="tab-btn active" id="userTab">User Login</button>
        <button class="tab-btn" id="studentTab">Student Login</button>
      </div>
    </div>
    
    <div class="login-body">
      <!-- Error Container -->
      <div class="error-container" id="errorContainer" style="display: none;">
        <ul id="errorList">
          <!-- Error messages will be added here dynamically -->
        </ul>
      </div>
      
      <!-- User Login Form -->
      <div class="tab-content active" id="userContent">
        <form action="{{ route('login') }}" method="post" id="userForm">
          @csrf
          <input type="hidden" name="login_type" value="user">
          
          <div class="form-group form-floating">
            <input type="email" name="email" class="form-control" id="userEmail" placeholder=" " required>
            <div class="input-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <label for="userEmail">Email address</label>
            <div class="focus-indicator"></div>
          </div>
          
          <div class="form-group form-floating">
            <input type="password" name="password" class="form-control" id="userPassword" placeholder=" " required>
            <div class="input-icon">
              <i class="fas fa-lock"></i>
            </div>
            <label for="userPassword">Password</label>
            <i class="fas fa-eye toggle-password" id="userTogglePassword"></i>
            <div class="focus-indicator"></div>
            <div class="password-strength">
              <div class="password-strength-bar" id="userPasswordStrength"></div>
            </div>
          </div>
          
          <div class="form-options">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="userRemember">
              <label class="form-check-label" for="userRemember">
                Remember me
              </label>
            </div>
            <a href="javascript:void(0)" class="forgot-link" id="userForgot">
              Forgot password?
            </a>
          </div>
          
          <button type="submit" class="submit-btn" id="userSubmit">
            <span class="btn-text">Sign In</span>
          </button>
        </form>
      </div>
      
      <!-- Student Login Form -->
      <div class="tab-content" id="studentContent">
        <form action="{{ route('login') }}" method="post" id="studentForm">
          @csrf
          <input type="hidden" name="login_type" value="student">
          
          <div class="form-group form-floating">
            <input type="email" name="email" class="form-control" id="studentEmail" placeholder=" " required>
            <div class="input-icon">
              <i class="fas fa-id-card"></i>
            </div>
            <label for="studentEmail">Email address</label>
            <div class="focus-indicator"></div>
          </div>
          
          <div class="form-group form-floating">
            <input type="password" name="password" class="form-control" id="studentPassword" placeholder=" " required>
            <div class="input-icon">
              <i class="fas fa-lock"></i>
            </div>
            <label for="studentPassword">Password</label>
            <i class="fas fa-eye toggle-password" id="studentTogglePassword"></i>
            <div class="focus-indicator"></div>
            <div class="password-strength">
              <div class="password-strength-bar" id="studentPasswordStrength"></div>
            </div>
          </div>
          
          <div class="form-options">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="studentRemember">
              <label class="form-check-label" for="studentRemember">
                Remember me
              </label>
            </div>
            <a href="javascript:void(0)" class="forgot-link" id="studentForgot">
              Forgot password?
            </a>
          </div>
          
          <button type="submit" class="submit-btn" id="studentSubmit">
            <span class="btn-text">Sign In</span>
          </button>
        </form>
      </div>
    </div>
  </div>
  
  <!-- JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="scripts.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
  // Initialize stars background
  initializeStars();
  
  // Initialize the login container with animations
  initializeLoginContainer();
  
  // Initialize form events and animations
  initializeFormEvents();
  
  // Initialize tab switching
  initializeTabSwitching();
  
  // Initialize 3D tilt effect
  initializeTiltEffect();
  
  // Initialize any error messages present in the session
  renderErrorMessages();
});

// Create star particles in the background
function initializeStars() {
  const stars = document.getElementById('stars');
  const maxStars = 100;
  
  for (let i = 0; i < maxStars; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    
    // Random size between 1px and 3px
    const size = Math.random() * 2 + 1;
    star.style.width = `${size}px`;
    star.style.height = `${size}px`;
    
    // Random position
    star.style.left = `${Math.random() * 100}%`;
    star.style.top = `${Math.random() * 100}%`;
    
    // Random animation duration and delay
    const duration = Math.random() * 3 + 2; // 2-5 seconds
    const delay = Math.random() * 5; // 0-5 seconds
    star.style.setProperty('--duration', `${duration}s`);
    star.style.setProperty('--delay', `${delay}s`);
    
    stars.appendChild(star);
  }
  
  // Add some shooting stars occasionally
  setInterval(createShootingStar, 8000);
}

function createShootingStar() {
  const stars = document.getElementById('stars');
  const shootingStar = document.createElement('div');
  shootingStar.className = 'star shooting-star';
  
  // Set position and style
  shootingStar.style.left = `${Math.random() * 100}%`;
  shootingStar.style.top = '0';
  shootingStar.style.width = '2px';
  shootingStar.style.height = '80px';
  shootingStar.style.opacity = '1';
  shootingStar.style.background = 'linear-gradient(to bottom, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 80%)';
  shootingStar.style.transform = 'rotate(35deg)';
  shootingStar.style.borderRadius = '0';
  
  // Animation
  shootingStar.style.animation = 'shooting 1s ease-out';
  
  stars.appendChild(shootingStar);
  
  // Remove after animation completes
  setTimeout(() => {
    shootingStar.remove();
  }, 1000);
}

// Initialize login container animations
function initializeLoginContainer() {
  const logoContainer = document.getElementById('logoContainer');
  const logoLetters = document.querySelectorAll('.logo-text span');
  
  // Add hover interaction to logo
  logoContainer.addEventListener('mouseenter', () => {
    logoLetters.forEach(letter => {
      letter.style.animationPlayState = 'paused';
      letter.style.transform = 'translateY(-8px)';
      letter.style.transition = 'transform 0.3s ease';
    });
  });
  
  logoContainer.addEventListener('mouseleave', () => {
    logoLetters.forEach(letter => {
      letter.style.animationPlayState = 'running';
      letter.style.transform = '';
    });
  });
  
  // Add interaction to form buttons and inputs
  document.querySelectorAll('.submit-btn').forEach(btn => {
    btn.addEventListener('mouseenter', createButtonRipple);
  });
}

// Create interactive ripple effect on buttons
function createButtonRipple(e) {
  const button = e.currentTarget;
  
  // Remove any existing ripples
  const existingRipple = button.querySelector('.ripple');
  if (existingRipple) {
    existingRipple.remove();
  }
  
  // Create ripple element
  const ripple = document.createElement('span');
  ripple.className = 'ripple';
  button.appendChild(ripple);
  
  // Position the ripple
  const rect = button.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  
  ripple.style.width = ripple.style.height = `${size}px`;
  ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
  ripple.style.top = `${e.clientY - rect.top - size / 2}px`;
  ripple.style.position = 'absolute';
  ripple.style.borderRadius = '50%';
  ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
  ripple.style.transform = 'scale(0)';
  ripple.style.animation = 'ripple 0.6s linear';
  
  // Clean up after animation completes
  setTimeout(() => {
    ripple.remove();
  }, 600);
}

// Initialize tab switching
function initializeTabSwitching() {
  const userTab = document.getElementById('userTab');
  const studentTab = document.getElementById('studentTab');
  const tabSlider = document.getElementById('tabSlider');
  const userContent = document.getElementById('userContent');
  const studentContent = document.getElementById('studentContent');
  
  userTab.addEventListener('click', () => {
    tabSlider.classList.remove('right');
    userTab.classList.add('active');
    studentTab.classList.remove('active');
    
    // Content switching with animation
    fadeOut(studentContent, () => {
      studentContent.classList.remove('active');
      userContent.classList.add('active');
      fadeIn(userContent);
    });
    
    // Update hidden input
    document.querySelector('input[name="login_type"]').value = 'user';
  });
  
  studentTab.addEventListener('click', () => {
    tabSlider.classList.add('right');
    studentTab.classList.add('active');
    userTab.classList.remove('active');
    
    // Content switching with animation
    fadeOut(userContent, () => {
      userContent.classList.remove('active');
      studentContent.classList.add('active');
      fadeIn(studentContent);
    });
    
    // Update hidden input
    document.querySelector('input[name="login_type"]').value = 'student';
  });
}

// Fade out animation with callback
function fadeOut(element, callback) {
  element.style.opacity = '1';
  element.style.transform = 'translateY(0)';
  
  // Create animation
  element.animate([
    { opacity: 1, transform: 'translateY(0)' },
    { opacity: 0, transform: 'translateY(-20px)' }
  ], {
    duration: 300,
    easing: 'ease-out',
    fill: 'forwards'
  }).onfinish = callback;
}

// Fade in animation
function fadeIn(element) {
  element.style.opacity = '0';
  element.style.transform = 'translateY(20px)';
  
  // Create animation
  element.animate([
    { opacity: 0, transform: 'translateY(20px)' },
    { opacity: 1, transform: 'translateY(0)' }
  ], {
    duration: 300,
    easing: 'ease-out',
    fill: 'forwards'
  });
}

// Initialize input field events and animations
function initializeFormEvents() {
  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const passwordField = this.previousElementSibling.previousElementSibling;
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      
      // Toggle eye icon
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  });
  
  // Form submission animation
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      // Validate the form
      if (!this.checkValidity()) {
        e.preventDefault();
        this.reportValidity();
        return;
      }
      
      const btn = this.querySelector('.submit-btn');
      const btnText = btn.querySelector('.btn-text');
      
      // Disable the button
      btn.disabled = true;
      
      // Create loading animation
      btnText.innerHTML = '<span class="spinner"></span>Signing in...';
      
      // Add gradient animation
      btn.style.backgroundSize = '400% 400%';
      btn.style.animation = 'gradient-shift 3s ease infinite';
    });
  });
  
  // Password strength indicator
  document.querySelectorAll('input[type="password"]').forEach(input => {
    const strengthBar = document.getElementById(input.id + 'Strength');
    const strengthContainer = input.parentElement.querySelector('.password-strength');
    
    input.addEventListener('focus', () => {
      strengthContainer.style.display = 'block';
    });
    
    input.addEventListener('blur', () => {
      if (input.value.length === 0) {
        strengthContainer.style.display = 'none';
      }
    });
    
    input.addEventListener('input', () => {
      const strength = getPasswordStrength(input.value);
      strengthBar.style.width = `${strength}%`;
      
      // Change color based on strength
      if (strength < 33) {
        strengthBar.style.background = '#ef4444';
      } else if (strength < 66) {
        strengthBar.style.background = '#f59e0b';
      } else {
        strengthBar.style.background = '#10b981';
      }
    });
  });
  
  // Interactive form feedback
  document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', () => {
      input.parentElement.classList.add('focused');
      input.parentElement.querySelector('.input-icon').style.transform = 'translateY(-50%) scale(1.1)';
    });
    
    input.addEventListener('blur', () => {
      input.parentElement.classList.remove('focused');
      input.parentElement.querySelector('.input-icon').style.transform = 'translateY(-50%) scale(1)';
    });
  });
  
  // Checkbox animation
  document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const label = this.nextElementSibling;
      
      if (this.checked) {
        label.style.color = getComputedStyle(document.documentElement).getPropertyValue('--primary-dark');
      } else {
        label.style.color = '';
      }
    });
  });
  
  // Forgot password link animation
  document.querySelectorAll('.forgot-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Add pulsing animation
      this.animate([
        { transform: 'scale(1)', opacity: 1 },
        { transform: 'scale(1.05)', opacity: 0.8 },
        { transform: 'scale(1)', opacity: 1 }
      ], {
        duration: 800,
        easing: 'ease'
      });
      
      // Show a message (in real implementation, this would open a modal or redirect)
      const form = this.closest('form');
      const email = form.querySelector('input[type="email"]').value;
      
      if (email) {
        showMessage('Password reset link has been sent to your email');
      } else {
        showMessage('Please enter your email address first');
      }
    });
  });
}

// Calculate password strength on a scale of 0-100
function getPasswordStrength(password) {
  if (!password) return 0;
  
  const length = Math.min(password.length * 10, 40);
  let complexity = 0;
  
  // Check for different character types
  if (/[A-Z]/.test(password)) complexity += 15;
  if (/[a-z]/.test(password)) complexity += 10;
  if (/[0-9]/.test(password)) complexity += 15;
  if (/[^A-Za-z0-9]/.test(password)) complexity += 20;
  
  return Math.min(length + complexity, 100);
}

// Initialize 3D tilt effect
function initializeTiltEffect() {
  const loginContainer = document.getElementById('loginContainer');
  let containerRect = loginContainer.getBoundingClientRect();
  let centerX, centerY;
  
  // Recalculate the container dimensions on resize
  window.addEventListener('resize', () => {
    containerRect = loginContainer.getBoundingClientRect();
    centerX = containerRect.left + containerRect.width / 2;
    centerY = containerRect.top + containerRect.height / 2;
  });
  
  // Calculate initial center
  centerX = containerRect.left + containerRect.width / 2;
  centerY = containerRect.top + containerRect.height / 2;
  
  document.addEventListener('mousemove', e => {
    if (window.innerWidth <= 768) return; // Disable on mobile
    
    const mouseX = e.clientX - centerX;
    const mouseY = e.clientY - centerY;
    
    // Calculate distance from center
    const distance = Math.sqrt(mouseX * mouseX + mouseY * mouseY);
    const maxDistance = Math.sqrt(containerRect.width * containerRect.width / 4 + containerRect.height * containerRect.height / 4);
    
    // Only apply effect if mouse is close enough to the container
    if (distance < maxDistance * 1.5) {
      // Calculate rotation angle - stronger when closer to container
      const strength = (1 - distance / (maxDistance * 1.5)) * 5;
      const rotateY = -mouseX / 25 * strength;
      const rotateX = mouseY / 25 * strength;
      
      // Apply 3D rotation with smooth transition
      loginContainer.style.transition = distance < maxDistance ? 'transform 0.1s ease-out' : 'transform 0.5s ease-out';
      loginContainer.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
      
      // Add subtle shadow movement
      const shadowX = -rotateY / 2;
      const shadowY = rotateX / 2;
      loginContainer.style.boxShadow = `${shadowX}px ${shadowY}px 30px rgba(0, 0, 0, 0.2)`;
    } else {
      // Reset when mouse is far away
      resetTilt();
    }
  });
  
  // Reset tilt when mouse leaves window
  document.addEventListener('mouseleave', resetTilt);
  
  function resetTilt() {
    loginContainer.style.transition = 'transform 0.8s ease-out, box-shadow 0.8s ease-out';
    loginContainer.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
    loginContainer.style.boxShadow = 'var(--card-shadow)';
  }
}

// Show feedback messages
function showMessage(message) {
  // Create message element if it doesn't exist
  let messageElement = document.getElementById('feedbackMessage');
  
  if (!messageElement) {
    messageElement = document.createElement('div');
    messageElement.id = 'feedbackMessage';
    messageElement.style.position = 'fixed';
    messageElement.style.bottom = '20px';
    messageElement.style.left = '50%';
    messageElement.style.transform = 'translateX(-50%)';
    messageElement.style.backgroundColor = 'rgba(79, 70, 229, 0.9)';
    messageElement.style.color = 'white';
    messageElement.style.padding = '10px 20px';
    messageElement.style.borderRadius = '8px';
    messageElement.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    messageElement.style.zIndex = '1000';
    messageElement.style.opacity = '0';
    messageElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    document.body.appendChild(messageElement);
  }
  
  // Set message and show
  messageElement.textContent = message;
  messageElement.style.opacity = '1';
  messageElement.style.transform = 'translateX(-50%) translateY(0)';
  
  // Hide after 3 seconds
  setTimeout(() => {
    messageElement.style.opacity = '0';
    messageElement.style.transform = 'translateX(-50%) translateY(20px)';
  }, 3000);
}

// Handle error messages from server
function renderErrorMessages() {
  const errorContainer = document.getElementById('errorContainer');
  const errorList = document.getElementById('errorList');
  
  // Check if there are error messages in the session
  if (errorContainer && errorList) {
    if (errorList.children.length > 0) {
      errorContainer.style.display = 'block';
      
      // Add shake animation
      errorContainer.animate([
        { transform: 'translateX(0)' },
        { transform: 'translateX(-5px)' },
        { transform: 'translateX(5px)' },
        { transform: 'translateX(-5px)' },
        { transform: 'translateX(0)' }
      ], {
        duration: 500,
        easing: 'ease-in-out'
      });
    } else {
      errorContainer.style.display = 'none';
    }
  }
}

// Add CSS animation rule for ripple effect
if (!document.getElementById('rippleStyle')) {
  const style = document.createElement('style');
  style.id = 'rippleStyle';
  style.textContent = `
    @keyframes ripple {
      to {
        transform: scale(2);
        opacity: 0;
      }
    }
    
    @keyframes shooting {
      from {
        transform: translateY(0) translateX(0) rotate(35deg);
        opacity: 1;
      }
      to {
        transform: translateY(100vh) translateX(100vw) rotate(35deg);
        opacity: 0;
      }
    }
    
    @keyframes gradient-shift {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }
  `;
  document.head.appendChild(style);
}
  </script>
</body>
</html>