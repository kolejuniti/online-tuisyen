<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="current-user" content="{{ Auth::user()->ic }}">
  <meta name="user-type" content="{{ Auth::user()->user_type }}">
  <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
  <title>{{ Auth::user()->user_type }} Dashboard - @yield('title')</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Vendors Style-->
  <link rel="stylesheet" href="{{ asset('assets/src/css/vendors_css.css') }}">
  
  <!-- Style-->  
  <link rel="stylesheet" href="{{ asset('assets/src/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/src/css/skin_color.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/css-skeletons@1.0.3/css/css-skeletons.min.css" />
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/customCSS.css') }}">
  <link rel="stylesheet" href="{{ asset('css/customLayoutCSS.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
  <div class="wrapper">
    <div id="loader"></div>
    
    <!-- Header -->
    <header class="main-header">
      <div class="d-flex align-items-center logo-box justify-content-start">	
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- logo-->
          <div class="logo-mini w-50">
            <span class="light-logo"><img src="{{ asset('assets/images/logo/Kolej-UNITI.png')}}" alt="logo"></span>
            <span class="dark-logo"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo"></span>
          </div>
          <div class="logo-lg d-flex align-items-center">
            <span class="light-logo">{{ Auth::user()->user_type }} Panel</span>
            <span class="dark-logo">{{ Auth::user()->user_type }} Panel</span>
          </div>
        </a>	
      </div>
      
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
          <ul class="header-megamenu nav">
            <li class="btn-group nav-item">
              <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light ms-0" 
              data-toggle-status="true" data-toggle="push-menu" role="button">
                <i data-feather="menu"></i>
              </a>
            </li>
            <li class="btn-group d-lg-inline-flex d-none">
              <div class="app-menu">
                <div class="search-bx mx-5">
                  <form>
                    <div class="input-group">
                      <input type="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                        <button class="btn" type="submit" id="button-addon3"><i class="icon-Search"><span class="path1"></span><span class="path2"></span></i></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </li>
          </ul> 
        </div>
        
        <div class="navbar-custom-menu r-side">
          <ul class="nav navbar-nav">
            <!-- Dark Mode Toggle -->
            <li class="btn-group d-md-inline-flex d-none">
              <a href="javascript:void(0)" title="Toggle Theme" class="waves-effect skin-toggle waves-light me-4">
                <label class="switch">
                  <input type="checkbox" data-mainsidebarskin="toggle" id="toggle_left_sidebar_skin">
                  <span>
                    <i data-feather="moon" class="switch-on"></i>
                    <i data-feather="sun" class="switch-off"></i>
                  </span>
                </label>
              </a>				
            </li>
            
            <!-- Notifications -->
            <li class="dropdown notifications-menu">
              <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="Notifications">
                <i data-feather="bell"></i>
              </a>
              <ul class="dropdown-menu animated bounceIn">
                <li class="header">
                  <div class="p-20">
                    <div class="flexbox">
                      <div>
                        <h4 class="mb-0 mt-0">Notifications</h4>
                      </div>
                      <div>
                        <a href="#" class="text-danger">Clear All</a>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <ul class="menu sm-scrol">
                    <li>
                      <a href="#">
                        <i class="fa fa-user text-info"></i> Example notification
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer">
                  <a href="#">View all</a>
                </li>
              </ul>
            </li>
            
            <!-- User Account-->
            <li class="dropdown user user-menu">
              <a href="#" class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow" 
                title="User Profile" data-bs-toggle="modal" data-bs-target="#quick_user_toggle">
                <div class="d-flex pt-1 align-items-center">
                  <div class="text-end me-10">
                    <p class="pt-5 fs-14 mb-0 fw-700">{{ Auth::user()->name }}</p>
                    <small class="fs-10 mb-0 text-uppercase text-mute">{{ Auth::user()->user_type }}</small>
                  </div>
                  <img src="{{ (Auth::user()->image) ? asset('storage/'.Auth::user()->image) : asset('assets/images/avatar/avatar-1.png') }}" class="avatar rounded-circle bg-primary-light h-40 w-40" alt="" />
                </div>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    
    <!-- Sidebar -->
    <aside class="main-sidebar">
      <section class="sidebar position-relative"> 
        <div class="multinav">
          <div class="multinav-scroll" style="height: 97%;">	
            <!-- Sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
              <li>
                <a href="{{ route('user.dashboard') }}">
                  <i data-feather="home"></i><span>Dashboard</span>
                </a>
              </li>
              
              <!-- Teaching Section -->
              <li class="header">TEACHING</li>
              
              <li>
                <a href="{{ route('user.subjects.index') }}">
                  <i data-feather="bookmark"></i><span>My Subjects</span>
                </a>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="users"></i>
                  <span>Class Management</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="list"></i> Class Lists</a></li>
                  <li><a href="#"><i data-feather="user-check"></i> Attendance</a></li>
                  <li><a href="#"><i data-feather="users"></i> Student Groups</a></li>
                  <li><a href="#"><i data-feather="calendar"></i> Class Schedule</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="clipboard"></i>
                  <span>Assessment Tools</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="edit-3"></i> Create Quiz</a></li>
                  <li><a href="#"><i data-feather="file-text"></i> Create Test</a></li>
                  <li><a href="#"><i data-feather="upload"></i> Assignments</a></li>
                  <li><a href="#"><i data-feather="check-square"></i> Grade Submissions</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="folder"></i>
                  <span>Content Management</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="upload"></i> Upload Materials</a></li>
                  <li><a href="#"><i data-feather="folder"></i> Organize Content</a></li>
                  <li><a href="#"><i data-feather="share-2"></i> Share Resources</a></li>
                  <li><a href="#"><i data-feather="video"></i> Video Content</a></li>
                </ul>
              </li>
              
              <!-- Communication Section -->
              <li class="header">COMMUNICATION</li>
              
              <!-- Student Messages for Users -->
              <li class="treeview">
                <a href="#">
                  <i data-feather="message-square"></i>
                  <span>Student Messages</span>
                  <span id="user-messages-count" class="count-circle hidden">0</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li>
                    <div class="sidebar-quick-search">
                      <input type="text" id="user-student-search" placeholder="Search students..." class="form-control form-control-sm">
                      <div id="user-search-results" class="sidebar-search-results"></div>
                    </div>
                  </li>
                  <li>
                    <div id="user-recent-conversations" class="sidebar-conversations">
                      <!-- Recent conversations will be loaded here -->
                    </div>
                  </li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="message-circle"></i>
                  <span>Announcements</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="plus"></i> Create Announcement</a></li>
                  <li><a href="#"><i data-feather="list"></i> My Announcements</a></li>
                  <li><a href="#"><i data-feather="calendar"></i> Scheduled Posts</a></li>
                  <li><a href="#"><i data-feather="bar-chart-2"></i> Engagement Stats</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="video"></i>
                  <span>Online Classes</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="play"></i> Start Live Class</a></li>
                  <li><a href="#"><i data-feather="calendar"></i> Schedule Class</a></li>
                  <li><a href="#"><i data-feather="video"></i> Recorded Sessions</a></li>
                  <li><a href="#"><i data-feather="users"></i> Class Participants</a></li>
                </ul>
              </li>
              
              <!-- Analytics Section -->
              <li class="header">ANALYTICS</li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="bar-chart-2"></i>
                  <span>Student Analytics</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="trending-up"></i> Performance Trends</a></li>
                  <li><a href="#"><i data-feather="target"></i> Individual Progress</a></li>
                  <li><a href="#"><i data-feather="users"></i> Class Comparisons</a></li>
                  <li><a href="#"><i data-feather="alert-circle"></i> At-Risk Students</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="file-text"></i>
                  <span>Reports</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="file-text"></i> Progress Reports</a></li>
                  <li><a href="#"><i data-feather="calendar"></i> Attendance Reports</a></li>
                  <li><a href="#"><i data-feather="bar-chart-2"></i> Assessment Reports</a></li>
                  <li><a href="#"><i data-feather="download"></i> Export Data</a></li>
                </ul>
              </li>
              
              <!-- Collaboration Section -->
              <li class="header">COLLABORATION</li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="users"></i>
                  <span>Teacher Network</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="search"></i> Find Teachers</a></li>
                  <li><a href="#"><i data-feather="message-circle"></i> Teacher Chat</a></li>
                  <li><a href="#"><i data-feather="share-2"></i> Share Resources</a></li>
                  <li><a href="#"><i data-feather="users"></i> Professional Groups</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="message-square"></i>
                  <span>Forums & Discussions</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="message-circle"></i> Subject Forums</a></li>
                  <li><a href="#"><i data-feather="help-circle"></i> Q&A Section</a></li>
                  <li><a href="#"><i data-feather="share-2"></i> Best Practices</a></li>
                  <li><a href="#"><i data-feather="trending-up"></i> Popular Topics</a></li>
                </ul>
              </li>
              
              <!-- Personal Section -->
              <li class="header">PERSONAL</li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="bell"></i>
                  <span>Notifications</span>
                  <span id="teacher-notifications-count" class="count-circle hidden">0</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="bell"></i> All Notifications</a></li>
                  <li><a href="#"><i data-feather="message-square"></i> Messages</a></li>
                  <li><a href="#"><i data-feather="calendar"></i> Reminders</a></li>
                  <li><a href="#"><i data-feather="award"></i> Achievements</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i data-feather="user"></i>
                  <span>Profile & Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible">
                  <li><a href="#"><i data-feather="user"></i> My Profile</a></li>
                  <li><a href="#"><i data-feather="lock"></i> Privacy Settings</a></li>
                  <li><a href="#"><i data-feather="bell"></i> Notification Preferences</a></li>
                  <li><a href="#"><i data-feather="help-circle"></i> Help & Support</a></li>
                </ul>
              </li>

              <li>
                <a href="#">
                  <i data-feather="settings"></i><span>Settings</span>
                </a>
              </li>
            </ul>
            
            <!-- Sidebar Widget -->
            {{-- <div class="sidebar-widgets">
              <div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
                <div class="text-center">
                  <img src="{{ asset('assets/images/svg-icon/color-svg/custom-24.svg') }}" class="sideimg p-5" alt="">
                  <h4 class="title-bx text-primary">Admin Dashboard</h4>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </section>
    </aside>

    <!-- Main Content -->
    @yield('main')
    
    <!-- Footer -->
    <footer class="main-footer">
      <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
        </ul>
      </div>
      &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Your Company</a>
    </footer>
    
    <!-- Quick User Toggle Modal -->
    <div class="modal modal-right fade" id="quick_user_toggle" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content slim-scroll3">
          <div class="modal-body p-30 bg-white">
            <div class="d-flex align-items-center justify-content-between pb-30">
              <h4 class="m-0">User Profile
                <small class="text-fade fs-12 ms-5"></small>
              </h4>
              <a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
                <span class="fa fa-close"></span>
              </a>
            </div>
            
            <div>
              <div class="d-flex flex-row">
                <div class="">
                  <img src="{{ (Auth::user()->image) ? asset('storage/'.Auth::user()->image) : asset('assets/images/avatar/avatar-1.png') }}" alt="user" class="rounded bg-danger-light w-150" width="100">
                </div>
                <div class="ps-20">
                  <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                  <p class="my-5 text-fade">{{ Auth::user()->email }}</p>
                  <a href="mailto:{{ Auth::user()->email }}">
                    <span class="icon-Mail-notification me-5 text-success">
                      <span class="path1"></span>
                      <span class="path2">{{ Auth::user()->email }}</span>
                    </span> 
                  </a>
                </div>
              </div>
            </div>
            
            <div class="dropdown-divider my-30"></div>
            
            <div>
              <div class="col-sm-12 d-flex justify-content-center">
                <a href="#" type="button" class="waves-effect waves-light btn btn-secondary btn-rounded mb-5" style="margin-right:10px;">
                  <i class="mdi mdi-account-edit"></i> Edit
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;" id="logout-form">
                  @csrf
                  <button type="submit" class="waves-effect waves-light btn btn-secondary btn-rounded mb-5">
                    <i class="mdi mdi-logout"></i>Logout
                  </button>
                </form>
                <script>
                  document.getElementById('logout-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    this.submit();
                    setTimeout(function() {
                      window.location.href = '/login';
                    }, 100);
                  });
                </script>
              </div>
            </div>
            
            <div class="dropdown-divider my-30"></div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Control Sidebar Background -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  
  <!-- Vendor and App JS -->
  <script src="{{ asset('assets/src/js/vendors.min.js') }}"></script>
  <script src="{{ asset('assets/src/js/pages/chat-popup.js') }}"></script>
  <script src="{{ asset('assets/assets/icons/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/full-calendar/moment.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/full-calendar/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/nestable/jquery.nestable.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('assets/assets/vendor_plugins/iCheck/icheck.min.js') }}"></script>
  
  <!-- App JS -->
  <script src="{{ asset('assets/src/js/demo.js') }}"></script>
  <script src="{{ asset('assets/src/js/template.js') }}"></script>
  <script src="{{ asset('assets/src/js/pages/owl-slider.js') }}"></script>
  <script src="{{ asset('assets/src/js/pages/advanced-form-element.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
  
  <!-- TextBox Vue Component -->
  <div id="textbox-app">
    <text-box></text-box>
  </div>

  <!-- Vue.js and App Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  
  <!-- User Messaging Integration -->
  <style>
    /* Count Circle for Sidebar */
    .count-circle {
      background: #ff4757;
      color: white;
      border-radius: 50%;
      min-width: 18px;
      height: 18px;
      font-size: 10px;
      font-weight: bold;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 5px;
    }
    
    .count-circle.hidden {
      display: none;
    }

    /* Sidebar Section Headers */
    .sidebar-menu .header {
      padding: 10px 15px 5px 15px;
      font-size: 11px;
      font-weight: 600;
      color: #666;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      background: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      margin-top: 10px;
    }

    /* Enhanced Sidebar Menu Items */
    .sidebar-menu li a {
      transition: all 0.3s ease;
    }

    .sidebar-menu li a:hover {
      background-color: #4f81c7;
      color: white;
    }

    .sidebar-menu li a:hover i {
      color: white;
    }

    /* Submenu Enhancements */
    .treeview-menu li a {
      padding: 8px 15px 8px 35px;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .treeview-menu li a i {
      font-size: 12px;
      width: 16px;
      text-align: center;
    }

    /* Active State Styling */
    .sidebar-menu li.active > a,
    .sidebar-menu li a.active {
      background-color: #4f81c7;
      color: white;
    }

    .sidebar-menu li.active > a i,
    .sidebar-menu li a.active i {
      color: white;
    }

    /* Sidebar Quick Messaging Styles */
    .sidebar-quick-search {
      padding: 10px 15px;
    }
    
    .sidebar-quick-search .form-control-sm {
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 15px;
      border: 1px solid #ddd;
    }
    
    .sidebar-search-results {
      position: absolute;
      top: 100%;
      left: 15px;
      right: 15px;
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-height: 200px;
      overflow-y: auto;
      z-index: 1000;
      display: none;
      margin-top: 5px;
    }
    
    .sidebar-search-results.active {
      display: block;
    }
    
    .sidebar-search-item {
      padding: 8px 12px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .sidebar-search-item:hover {
      background-color: #f8f9fa;
    }
    
    .sidebar-search-item:last-child {
      border-bottom: none;
    }
    
    .sidebar-search-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #4f81c7;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 11px;
      flex-shrink: 0;
    }
    
    .sidebar-search-info {
      flex: 1;
      min-width: 0;
    }
    
    .sidebar-search-name {
      font-weight: 600;
      font-size: 12px;
      color: #333;
      margin-bottom: 1px;
    }
    
    .sidebar-search-details {
      font-size: 10px;
      color: #666;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .sidebar-conversations {
      max-height: 250px;
      overflow-y: auto;
      padding: 0 15px;
    }
    
    .sidebar-conversation-item {
      display: flex;
      align-items: center;
      padding: 8px 0;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      transition: all 0.2s ease;
      gap: 8px;
    }
    
    .sidebar-conversation-item:hover {
      background-color: #f8f9fa;
      margin: 0 -8px;
      padding: 8px 8px;
      border-radius: 6px;
    }
    
    .sidebar-conversation-item:last-child {
      border-bottom: none;
    }
    
    .sidebar-conversation-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #4f81c7;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 12px;
      flex-shrink: 0;
      position: relative;
    }
    
    .sidebar-conversation-avatar.online::after {
      content: '';
      position: absolute;
      bottom: -1px;
      right: -1px;
      width: 10px;
      height: 10px;
      background: #2ed573;
      border: 2px solid white;
      border-radius: 50%;
    }
    
    .sidebar-conversation-details {
      flex: 1;
      min-width: 0;
    }
    
    .sidebar-conversation-name {
      font-weight: 600;
      font-size: 12px;
      color: #333;
      margin-bottom: 2px;
    }
    
    .sidebar-conversation-preview {
      font-size: 11px;
      color: #666;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .sidebar-conversation-preview.unread {
      font-weight: 600;
      color: #333;
    }
    
    .sidebar-conversation-unread {
      background: #4f81c7;
      color: white;
      border-radius: 50%;
      min-width: 16px;
      height: 16px;
      font-size: 9px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .sidebar-empty-conversations {
      padding: 15px 0;
      text-align: center;
      color: #666;
      font-size: 11px;
    }
  </style>

  <script>
    // Global variables for user messaging
    let searchTimeout;
    let currentStudentChat = null;

    // Laravel and session variables
    window.Laravel = {
      sessionUserId: '{{ Auth::user()->user_type }}',
      currentUserIc: '{{ Auth::user()->ic ?? "" }}'
    };

    // Initialize messaging functionality
    function initializeUserMessaging() {
      // Sidebar search functionality
      const searchInput = document.getElementById('user-student-search');
      const searchResults = document.getElementById('user-search-results');
      
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          clearTimeout(searchTimeout);
          const query = this.value.trim();
          
          if (query.length < 2) {
            searchResults.classList.remove('active');
            // Restore original conversations when search is cleared
            loadUserConversations();
            return;
          }
          
          searchTimeout = setTimeout(() => {
            searchStudentsForUser(query);
          }, 300);
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
          if (searchInput && searchResults && 
              !searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('active');
          }
        });
      }
      
      // Load existing conversations
      loadUserConversations();
    
      // Set up periodic refresh for conversations
      setInterval(() => {
        // Only refresh if not actively searching
        const searchInput = document.getElementById('user-student-search');
        const hasActiveSearch = searchInput && searchInput.value.trim().length >= 2;
        
        if (!hasActiveSearch) {
          loadUserConversations();
        }
      }, 10000);
    }

    function searchStudentsForUser(query) {
      fetch('/all/student/search', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ search: query })
      })
      .then(response => response.json())
      .then(students => {
        const conversationsContainer = document.getElementById('user-recent-conversations');
        
        if (students.length === 0) {
          conversationsContainer.innerHTML = `
            <div class="sidebar-empty-conversations">
              No students found
            </div>
          `;
        } else {
          conversationsContainer.innerHTML = students.map(student => `
            <div class="sidebar-conversation-item" onclick="startStudentMessageFromUser('${student.ic}', '${student.name}')">
              <div class="sidebar-conversation-avatar">
                ${student.name.charAt(0).toUpperCase()}
              </div>
              <div class="sidebar-conversation-details">
                <div class="sidebar-conversation-name">${student.name}</div>
                <div class="sidebar-conversation-preview">
                  ${student.email}
                </div>
              </div>
            </div>
          `).join('');
        }
      })
      .catch(error => {
        console.error('Error searching students:', error);
      });
    }
    
    function startStudentMessageFromUser(studentIc, studentName) {
      // Hide search results and clear search
      const searchResults = document.getElementById('user-search-results');
      const searchInput = document.getElementById('user-student-search');
      if (searchResults) searchResults.classList.remove('active');
      if (searchInput) searchInput.value = '';
      
      // Check if TextBox component is available
      if (window.textBoxComponent) {
        currentStudentChat = studentIc;
        const event = new CustomEvent('message-requested', {
          detail: {
            ic: studentIc,
            messageType: '{{ Auth::user()->user_type }}',
            studentName: studentName
          }
        });
        window.dispatchEvent(event);
      }
    }

    function loadUserConversations() {
      fetch('/all/user/conversations')
        .then(response => response.json())
        .then(conversations => {
          const container = document.getElementById('user-recent-conversations');
          
          if (conversations.length === 0) {
            container.innerHTML = `
              <div class="sidebar-empty-conversations">
                No recent conversations
              </div>
            `;
          } else {
            // Show only the first 5 conversations for the sidebar
            const recentConversations = conversations.slice(0, 5);
            
            container.innerHTML = recentConversations.map(conv => {
              const lastMessage = conv.last_message;
              const student = conv.student;
              const unreadCount = conv.unread_count;
              
              // Format message preview
              let messagePreview = 'No messages yet';
              if (lastMessage) {
                if (lastMessage.message && lastMessage.message.trim()) {
                  messagePreview = lastMessage.message;
                } else if (lastMessage.image_url) {
                  messagePreview = '📷 Photo';
                }
              }
              
              return `
                <div class="sidebar-conversation-item" onclick="startStudentMessageFromUser('${student.ic}', '${student.name}')">
                  <div class="sidebar-conversation-avatar online">
                    ${student.name.charAt(0).toUpperCase()}
                  </div>
                  <div class="sidebar-conversation-details">
                    <div class="sidebar-conversation-name">${student.name}</div>
                    <div class="sidebar-conversation-preview ${unreadCount > 0 ? 'unread' : ''}">
                      ${messagePreview}
                    </div>
                  </div>
                  ${unreadCount > 0 ? `<div class="sidebar-conversation-unread">${unreadCount}</div>` : ''}
                </div>
              `;
            }).join('');
          }
          
          // Update unread count
          const totalUnread = conversations.reduce((sum, conv) => sum + conv.unread_count, 0);
          const countElement = document.getElementById('user-messages-count');
          if (totalUnread > 0) {
            countElement.textContent = totalUnread;
            countElement.classList.remove('hidden');
          } else {
            countElement.classList.add('hidden');
          }
        })
        .catch(error => {
          console.error('Error loading user conversations:', error);
        });
    }

    // Function to open messages with specific students for users
    function openStudentMessage(studentIc, studentName) {
      const event = new CustomEvent('message-requested', {
        detail: {
          ic: studentIc,
          messageType: '{{ Auth::user()->user_type }}',
          studentName: studentName
        }
      });
      window.dispatchEvent(event);
    }

    // Global function to trigger messaging (for backward compatibility)
    function getMessage(ic, type = null) {
      const event = new CustomEvent('message-requested', {
        detail: {
          ic: ic,
          messageType: type || '{{ Auth::user()->user_type }}'
        }
      });
      window.dispatchEvent(event);
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      initializeUserMessaging();
    });
  </script>

  @yield('content')
</body>
</html>