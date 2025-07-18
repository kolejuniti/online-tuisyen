<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
              <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="Notifications" id="notificationBell">
                <i data-feather="bell"></i>
                <span class="badge badge-danger badge-sm unread-count" id="unreadCount" style="display: none;"></span>
              </a>
              <ul class="dropdown-menu animated bounceIn" id="notificationDropdown">
                <li class="header">
                  <div class="p-20">
                    <div class="flexbox">
                      <div>
                        <h4 class="mb-0 mt-0">Notifications</h4>
                      </div>
                      <div>
                        <a href="#" class="text-danger" id="clearAllNotifications">Clear All</a>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <ul class="menu sm-scrol" id="notificationList">
                    <li class="text-center p-20">
                      <i class="fa fa-spinner fa-spin"></i> Loading notifications...
                    </li>
                  </ul>
                </li>
                <li class="footer">
                  <a href="#" id="viewAllNotifications">View all</a>
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
                <a href="{{ route('student.dashboard') }}">
                  <i data-feather="home"></i><span>Dashboard</span>
                </a>
              </li>
              <li>
                <a href="{{ route('student.subjects.show', Session::get('teachers')->id) }}" class="{{ Request::is('user/summary/*') ? 'active' : '' }}"><i data-feather="archive"></i><span>Course Summary</span></a>
              </li>
              <li>
                <a href="{{ route('student.content', Session::get('subjects')->id) }}" class="{{ Request::is('/content/*') ? 'active' : '' }}"><i data-feather="airplay"></i><span>Course Content</span></a>
              </li>
              <li class="treeview">
                <a href="#"><i data-feather="book-open"></i><span>Course Assessment</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu treeview-menu-visible" id="treeview-menu-visible">
                <li class="treeview">
                  <a href="#"><span>Quiz</span>
                  </a>
                  <ul class="treeview-menu treeview-menu-visible" id="treeview-menu-visible">
                  <li><a href="{{ route('student.quiz', Session::get('subjects')->id) }}" class="">Online</a></li>
                  <li><a href="{{ route('student.quiz2', Session::get('subjects')->id) }}" class="">Offline</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#"><span>Test</span>
                  </a>
                  <ul class="treeview-menu treeview-menu-visible" id="treeview-menu-visible">
                  <li><a href="{{ route('student.test', Session::get('subjects')->id) }}" class="">Online</a></li>
                  <li><a href="{{ route('student.test2', Session::get('subjects')->id) }}" class="">Offline</a></li>
                  </ul>
                </li>
                <li><a href="" class="">Report</a></li>
                </ul>
              </li>
              <li>
                <a href="{{ route('student.forum', Session::get('subjects')->id) }}" class="{{ Request::is('student/forum/*') ? 'active' : '' }}"><i data-feather="message-square"></i><span>Forum</span></a>
              </li>
              <li>
                <a href="{{ route('student.online-class.index', Session::get('subjects')->id) }}" class="{{ Request::is('student/online-class/*') ? 'active' : '' }}"><i data-feather="video"></i><span>Online Classes</span></a>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  
  <!-- Form Builder Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-builder.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js"></script>
  
  <!-- Notification Styles -->
  <style>
  .unread-count {
      position: absolute;
      top: 3px;
      right: 3px;
      background-color: #dc3545;
      color: white;
      border-radius: 50%;
      padding: 3px 7px;
      font-size: 9px;
      font-weight: bold;
      min-width: 15px;
      text-align: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      z-index: 1000;
  }
  
  .notification-item {
      padding: 10px 15px !important;
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.2s ease;
  }
  
  .notification-item:hover {
      background-color: #f8f9fa !important;
  }
  
  .notification-message {
      font-size: 13px;
      line-height: 1.4;
  }
  
  .bg-light {
      background-color: #f8f9fa !important;
  }
  
  #notificationDropdown {
      min-width: 300px;
      max-height: 400px;
      overflow-y: auto;
  }
  
  #notificationList {
      max-height: 250px;
      overflow-y: auto;
  }
  
  .notifications-menu {
      position: relative !important;
  }
  
  .notifications-menu > a {
      position: relative !important;
      display: inline-block !important;
  }
  </style>
  
  <!-- Notification JavaScript -->
  <script>
  $(document).ready(function() {
      // Load notifications when page loads
      loadNotifications();
      
      // Refresh notifications every 30 seconds
      setInterval(loadNotifications, 30000);
      
      // Clear all notifications
      $('#clearAllNotifications').click(function(e) {
          e.preventDefault();
          markAllAsRead();
      });
  });

  function loadNotifications() {
      $.ajax({
          url: '{{ route("student.notifications.for-layout") }}',
          type: 'GET',
          success: function(response) {
              updateNotificationUI(response);
          },
          error: function(xhr, status, error) {
              console.error('Error loading notifications:', error);
              $('#notificationList').html('<li class="text-center p-20 text-danger">Error loading notifications</li>');
          }
      });
  }

  function updateNotificationUI(data) {
      const notifications = data.notifications;
      const unreadCount = data.unread_count;
      
      // Update unread count badge
      if (unreadCount > 0) {
          $('#unreadCount').text(unreadCount).show();
      } else {
          $('#unreadCount').hide();
      }
      
      // Update notification list
      let notificationHtml = '';
      
      if (notifications.length === 0) {
          notificationHtml = '<li class="text-center p-20 text-muted">No notifications</li>';
      } else {
          notifications.forEach(function(notification) {
              const isUnread = notification.is_unread;
              const bgClass = isUnread ? 'bg-light' : '';
              const notificationType = notification.data.type || 'default';
              const iconClass = getNotificationIcon(notificationType);
              
              notificationHtml += `
                  <li class="${bgClass}">
                      <a href="#" data-notification-id="${notification.id}" class="notification-item" 
                         data-url="${notification.data.url || '#'}" data-is-read="${!isUnread}">
                          <i class="${iconClass}"></i> 
                          <span class="notification-message">${notification.message}</span>
                          <small class="text-muted d-block">${notification.created_at}</small>
                      </a>
                  </li>
              `;
          });
      }
      
      $('#notificationList').html(notificationHtml);
      
      // Bind click events to notification items
      $('.notification-item').click(function(e) {
          e.preventDefault();
          const notificationId = $(this).data('notification-id');
          const url = $(this).data('url');
          const isRead = $(this).data('is-read');
          
          if (!isRead) {
              markAsRead(notificationId);
          }
          
          if (url && url !== '#') {
              window.location.href = url;
          }
      });
  }

  function getNotificationIcon(type) {
      switch(type) {
          case 'quiz':
              return 'fa fa-question-circle text-info';
          case 'test':
              return 'fa fa-file-text text-warning';
          case 'online_class':
              return 'fa fa-video text-success';
          default:
              return 'fa fa-bell text-info';
      }
  }

  function markAsRead(notificationId) {
      $.ajax({
          url: `{{ url('student/notifications') }}/${notificationId}/mark-as-read`,
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}'
          },
          success: function(response) {
              if (response.success) {
                  loadNotifications(); // Refresh notifications
              }
          },
          error: function(xhr, status, error) {
              console.error('Error marking notification as read:', error);
          }
      });
  }

  function markAllAsRead() {
      $.ajax({
          url: '{{ route("student.notifications.mark-all-as-read") }}',
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}'
          },
          success: function(response) {
              if (response.success) {
                  loadNotifications(); // Refresh notifications
              }
          },
          error: function(xhr, status, error) {
              console.error('Error marking all notifications as read:', error);
          }
      });
  }
  </script>
  
  @yield('content')
</body>
</html>