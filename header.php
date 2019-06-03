<?php 
    include_once( 'includes/connection.php' );
    include_once( 'includes/functions.php' );
    auth_login(); 
      $db = new Database();
    $type = array();
    if( user_type() == 'doctor' ){
      $type = array('table'=>'doctors','id'=>'doctor_id');
    } elseif( user_type() == 'patient' ){
      $type = array('table'=>'patient','id'=>'patient_id');
    } else {  
      $type = array('table'=>'employee','id'=>'employee_id');
    } 
    $sql = 'select * from ' . $type['table'] . ' where ' . $type['id'] . '= '. $_COOKIE['userid'];
    $current_user = $db->display($sql);

    // Needed executions
    if( user_type() == 'doctor' ) {
      $stmnt = 'update appointment_definition set pv_id = null, active = true, videoId = null where doctor_id = ' . $_COOKIE['userid'];
      $db->execute_query($stmnt);
    }
?>

<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap material admin template">
  <meta name="author" content="">

  <title>Dashboard | Online Consultation</title>

  <link rel="apple-touch-icon" href="../assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="../assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../assets/global/css/bootstrap.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/css/bootstrap-extend.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/css/site.min-v2.2.0.css">
    <link rel="stylesheet" type="text/css" href="../assets/global/css/main.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="../assets/global/vendor/animsition/animsition.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/asscrollable/asScrollable.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/switchery/switchery.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/intro-js/introjs.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/slidepanel/slidePanel.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/flag-icon-css/flag-icon.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/waves/waves.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/clockpicker/clockpicker.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/alertify-js/alertify.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/dropify/dropify.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/jsgrid/jsgrid.min-v2.2.0.css">

  <!-- Plugins For This Page -->
  <link rel="stylesheet" href="../assets/global/vendor/chartist-js/chartist.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/jvectormap/jquery-jvectormap.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/toastr/toastr.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/filament-tablesaw/tablesaw.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/vendor/slidepanel/slidePanel.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/apps/contacts.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/advanced/rating.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/apps/documents.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/advanced/alertify.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/advanced/lightbox.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/froala/css/froala_editor.pkgd.min.css">
  <link rel="stylesheet" href="../assets/froala/css/froala_style.min.css">

  <!-- Page -->
  <link rel="stylesheet" href="../assets/examples/css/dashboard/v1.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/pages/profile.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/examples/css/apps/location.min-v2.2.0.css">

  <!-- Fonts -->
  <link rel="stylesheet" href="../assets/global/fonts/material-design/material-design.min-v2.2.0.css">
  <link rel="stylesheet" href="../assets/global/fonts/brand-icons/brand-icons.min-v2.2.0.css">

  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700'>


  <!--[if lt IE 9]>
    <script src="../assets/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="../assets/global/vendor/media-match/media.match.min.js"></script>
    <script src="../assets/global/vendor/respond/respond.min.js"></script>
    <![endif]-->

  <!-- Scripts -->
  <script src="../assets/global/vendor/modernizr/modernizr.min.js"></script>
  <script src="../assets/global/vendor/breakpoints/breakpoints.min.js"></script>
  <script src="../assets/global/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/js/editor.js"></script>
  <script src="../assets/froala/js/plugins/image.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../assets/file_upload/jquery.fileuploader.css">
  <script type="text/javascript" src="../assets/file_upload/jquery.fileuploader.js"></script>
  <script src="../assets/global/vendor/jsgrid/jsgrid.min.js"></script>
  <script src="../assets/global/js/components/magnific-popup.min.js"></script>
  <script>
    Breakpoints();
  </script>
</head>
<body class="dashboard site-menubar-unfold" data-type="<?php echo user_type(); ?>" data-id="<?php echo $_COOKIE['userid']; ?>">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
 
  <nav class="site-navbar navbar navbar-inverse navbar-fixed-top navbar-mega bg-blue-600" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
      data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
      data-toggle="collapse">
        <i class="icon md-more" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <img class="navbar-brand-logo" src="../assets/images/logo.png" title="Online Consultation">
        <span class="navbar-brand-text hidden-xs"> Online Consultation</span> 
      </div>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon md-search" aria-hidden="true"></i>
      </button>
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="alertify.html#" aria-expanded="false"
            data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="../assets/global/portraits/5.jpg" alt="...">
                <i></i>
              </span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <?php if( $_COOKIE['type'] != 'admin' ): ?>
              <li><h5 style="padding: 20px;"><?php echo $current_user[0]['fname'] . $current_user[0]['lname']; ?></h5></li>
              <li class="divider" role="presentation"></li>
            <?php endif; ?>
              <li role="presentation">
                <a href="../logout.php" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
              </li>
            </ul>
          </li>
          
          
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon md-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
              data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>
  <div class="site-menubar  site-menubar-dark">
    

    <div class="site-menubar-body ">
      <div>
        <div>
          <ul class="site-menu">
          <li class="site-menu-category">General</li>
            <li class="site-menu-item">
              <a class="animsition-link" href="dashboard.php">
                <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
              </a>
            </li>
            <?php if( user_type() == 'admin' ) : ?>
              <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Miscellaneous</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="add_specialization.php">
                    <span class="site-menu-title">Add Specialization</span>
                  </a>

                  <a class="animsition-link" href="view_specialization.php">
                    <span class="site-menu-title">View Specilization </span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Doctors</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="approve-doctorlist.php">
                    <span class="site-menu-title">Approve Doctor</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="doctor_list.php">
                    <span class="site-menu-title">View all Doctors</span>
                  </a>
                </li>
                
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Employees</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="employee_registration.php">
                    <span class="site-menu-title">Register Employees</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="employee_list.php">
                    <span class="site-menu-title">View all Employees</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Revenue</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="report.php">
                    <span class="site-menu-title">Report</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if( user_type() == 'employee' ) : ?>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Doctors</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="doctor_registration.php">
                    <span class="site-menu-title">Register Doctor</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_doctors.php">
                    <span class="site-menu-title">View Doctors</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Profile</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_profile.php">
                    <span class="site-menu-title">View Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="edit_profile.php">
                    <span class="site-menu-title">Edit Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="change_password.php">
                    <span class="site-menu-title">Change Password</span>
                  </a>
                </li>
              </ul>
            </li>
            <!-- <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Commission</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="commission.php">
                    <span class="site-menu-title">Commission</span>
                  </a>
                </li>
              </ul>
            </li> -->
            <?php endif; ?>
            <?php if( user_type() == 'doctor' ) : ?>
              <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Appointment Definition</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="define-appointment.php">
                    <span class="site-menu-title">Define Appointment</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_app_def.php">
                    <span class="site-menu-title">View Appointment Definitions</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="edit_appointment.php">
                    <span class="site-menu-title">Edit Appointment</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Appointments</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="appointment.php#init">
                    <span class="site-menu-title">Start Appointment</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="previous_appointments.php">
                    <span class="site-menu-title">Previous Appointments</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Profile</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_profile.php">
                    <span class="site-menu-title">View Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="edit_profile.php">
                    <span class="site-menu-title">Edit Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="change_password.php">
                    <span class="site-menu-title">Change Password</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Patients</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_patients.php">
                    <span class="site-menu-title">View Patients</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Earnings</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="earnings.php">
                    <span class="site-menu-title">Report</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if( user_type() == 'patient' ) : ?>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Appointments</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="search-doctor.php">
                    <span class="site-menu-title">Search</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="upcoming_appointments.php">
                    <span class="site-menu-title">Upcoming</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="previous_appointments.php">
                    <span class="site-menu-title">Previous</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                <span class="site-menu-title">Profile</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="view_profile.php">
                    <span class="site-menu-title">View Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="edit_profile.php">
                    <span class="site-menu-title">Edit Profile</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="change_password.php">
                    <span class="site-menu-title">Change Password</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>


  <!-- Page -->
  <div class="page animsition">
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">


      <?php if( user_type() == 'patient' ) : ?>
          <input type="hidden" id="pt-id" name="">
          <input type="hidden" id="app-id" name="">


          <button type="button" id="trgigger-prescription" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal4" data-backdrop="static" data-keyboard="false">Open Modal</button>

          <!-- Modal -->
          <div id="myModal4" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
              <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title">Prescription</h4>
                      </div>
                      <div class="modal-body">
                        <div class="prescription-content">
                          
                        </div>
                      </div>
                  </div>

              </div>
          </div>

          <button type="button" id="trgigger-video" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3" data-backdrop="static" data-keyboard="false">Open Modal</button>
            <div class="row" id="video-section">

                        <!-- Modal content-->
          <div id="myModal3" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
          <div class="modal-dialog"  style="width: 90%;">
                  <div class="modal-content">
                      <div class="modal-body">
                          <div class="video-wrapper">
                              <div class="half">
                                  <div class="video-frame">
                                      <div class="connecting-loader">
                                          <img src="../assets/images/svg-loaders/puff.svg">
                                          <div class="connecting-message"></div>
                                      </div>
                                      <div class="doc-video"></div>
                                      <div class="pat-video" id="pat-video"></div>
                                  </div>
                              </div>
                              <div class="half" id="chat-section">
                                  <div class="panel" style="box-shadow: none;display: block;margin-bottom: 200px;height: 300px;">
                                      <div class="panel-header">
                                          <div class="panel-title">
                                              <a class="pull-left" href="javascript:void(0)"><i aria-hidden="true" class="icon md-chevron-left"></i></a>
                                              <div class="text-right" style="position: fixed;top: 0;right: 0px; margin-top: 20px; padding: 0 50px; background: #E2C577; color: #fff; z-index: 9999;">
                                                  Dr. <b><span class="conv-name"></span></b>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="panel-body" style="padding-bottom: 0;">
                                          <div class="chat-box" style="overflow-x: hidden;">
                                              <div class="chats" id="chat-content" style="padding-bottom: 0;"></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div style="position: absolute;padding:0 20px;bottom: 25px; background: #fff; border-top: 1px solid #efefef; margin: 0; padding-top: 12px;">
                                      <div class="input-group form-material">
                                          <!--  <span class="input-group-btn">
                  <a href="javascript: void(0)" class="btn btn-pure btn-default icon md-camera"></a>
                </span> -->
                                          <!-- <input class="form-control" id="chat-input" type="text" placeholder="Type message here ..."> -->
                                          <textarea id="f-editor"></textarea>
                        <span class="input-group-btn">
                          <buttn type="button" id="send-message-btn" class="btn btn-pure btn-default icon md-mail-send">
                            </button>
                        </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>



                        <div class="hidden">
                          <label>Your ID:</label><br/>
                        <textarea id="yourId"></textarea><br/>
                        <label>Other ID:</label><br/>
                        <textarea id="otherId"></textarea>
                        <button id="connect1">connect</button><br/>

                        <button id="connect">connect</button><br/>
                        <label>Enter Message:</label><br/>
                        <textarea id="yourMessage"></textarea>
                        <button id="send">send</button>
                        <pre id="messages"></pre>
                        </div>
                        <div class="videoFrame">
                          
                        </div>
          </div></div>
            </div>

              <div id="calling-info" class="btn btn-primary">
                Answer the call
              </div>
            <style type="text/css">
              #calling-info {
                display: none;    
                position: fixed;
                right: 20px;
                top: 90px;
                z-index: 99999999;
              }
            </style>

            <script type="text/javascript">
              jQuery(function() {
                
              });
                if( $('body').attr('data-type') == 'patient' ) {
                  videoCall();
                };

                $('#f-editor').froalaEditor({

                toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'subscript', 'emoticons', 'insertImage'],
                height: 120,
                pasteAllowLocalImages: true,
                      imageUploadURL: '../upload_image.php',
                      imageUploadParams: {
                          id: 'f-editor'
                      }
              }); 
                  $('#p-editor').froalaEditor({height: 150});

                function videoCall() {
                  $.ajax({
                    url: '../ajax.php',
                    type:'POST',
                    data:{
                      'type': 'checkCallStatus',
                    },
                    success: function(result){ 
                      if ( result) {
                        var appdef_id = $.parseJSON(result)[0][1];
                        var videCall = $.parseJSON(result)[0];

                        $('#calling-info').show();

                        navigator.webkitGetUserMedia({
                          video: true,
                          audio: false
                        },function(stream) {


                                var pat_video = document.createElement('video');
                                $('#pat-video').html(pat_video);
                                pat_video.srcObject = stream;

                          var peer = new SimplePeer({
                           // initiator: location.hash === '#init',
                            trickle: false,
                            stream: stream
                          });
                          peer.on('signal', function(data){
                          document.getElementById('yourId').value = JSON.stringify(data);
                            //var docVideoId = JSON.stringify(data);
                            $.ajax({
                              url: '../ajax.php',
                              type:'POST',
                              data:{
                                'type': 'setPVideoID',
                                'videoId': JSON.stringify(data),
                                'appdefId': appdef_id
                              },
                              success: function(result){
                                chats();
                              }
                            });
                          });

                          $('#calling-info').on('click', function(){
                            var otherId = videCall.doctor_video;
                            peer.signal(otherId);
                            $('#calling-info').hide();
                            
                            $.ajax({
                              url: '../ajax.php',
                              type: 'POST',
                              data: {
                                'type': 'accptCallinfo',
                                'appdefId': appdef_id
                              },
                              success: function(result){
                                $('#pt-id').val(JSON.parse(result)[0].doctor_id);
                                $('#trgigger-video').click();
                                $('.conv-name').html(JSON.parse(result)[0].fname + ' ' + JSON.parse(result)[0].lname);
                              check_complete(appdef_id);
                              }
                            });
                          })

                          peer.on('stream', function(stream){
                            var video = document.createElement('video');
                            $('.doc-video').html(video);

                            video.srcObject = stream;
                            video.play();
                          })

                          peer.on('close', function () {

                          });

                        },function(err) {
                          console.log(err);
                        });
                      } else {
                        $('#calling-info').hide();
                      }
                      setTimeout(videoCall, 5000);
                    }
                  });
                };

                $('#send-message-btn').click(function (e) {
                var message = $('#f-editor').val();
                if(message != '') {
                  //$('#chat-content').append('<div class="chat chat-right"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip" title="8:35 am"> <p>' + $('#f-editor').froalaEditor('html.get')  +' </p> </div> </div> </div>');
                  
                  $("#chat-section .panel").animate({ scrollTop: $("#chat-section .panel")[0].scrollHeight}, 1000);
                          $('#f-editor').froalaEditor('html.set','');

                  $.ajax({
                            url: '../ajax.php',
                            type: 'POST',
                            data: {
                                'type': 'insertMessage',
                                  'user_type': 'patient',
                                'userid': $('#pt-id').val(),
                                'message': message
                            },
                            success: function(result) {
                                //alert(result);
                            }
                        });

                }
              });  

                var storiesInterval = 10 * 100;
                var con_flag = 0;
                  var chats = function(){

                      var chatId = [];
                      $('#chat-content .chat').map(function(){
                        chatId.push($(this).attr('chat_id'));
                      });

                      $.ajax({
                          url: '../ajax.php',
                          type: 'POST',
                          data: {
                              'type': 'getMessages',
                              'doctor': $('body').attr('data-id'),
                              'patient': $('#pt-id').val(),
                              'chat_ids': JSON.stringify(chatId)
                          },
                          success: function(result) {
                              var chat = JSON.parse(result);
                              var flag;
                              $.each( chat, function( key, value ) {
                                  if( value.s_type == 'patient' ) {
                                      flag = 'chat-right';
                                  } else {
                                      flag = '';
                                  }
                                  $('#chat-content').append('<div chat_id="'+value.id+'" class="chat ' + flag +'"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip"> <p>' + value.message + ' </p> </div> </div> </div>');
                              });
                              if( con_flag != $('.chat-content').length ) {
                                $("#chat-section .panel").animate({ scrollTop: $("#chat-section .panel")[0].scrollHeight}, 1000);
                            }
                              con_flag = $('.chat-content').length;

                              setTimeout(chats, storiesInterval);
                          }
                      });
                  }

                  var check_complete = function(appdef_id) {
                    var appdef_id = appdef_id;
                    //console.log(appdef_id);
                      $.ajax({
                  url: '../ajax.php',
                  type: 'POST',
                  data: {
                    'type': 'getcurrentappid',
                    'appdefId': appdef_id
                  },
                  success: function(result){ console.log(result);
                            if( result != '[null]' ) {
                      console.log('asd- ' + result);
                      $('#video-section').remove();
                      $('#trgigger-prescription').click();
                      $('.prescription-content').html(JSON.parse(result));
                            } else {
                              setTimeout(check_complete.bind(null, appdef_id), storiesInterval);
                            }
                  }
                });
                  }

            </script>

            <style type="text/css">
              
            .half {
              width: 49%;
              display: inline-block;
              min-height: 500px;
              max-height: 500px;
            }
            .half .panel {
              height: 100%;
              overflow-x: hidden;
            }
            .video-frame {
              position: relative;
              background: #2C3E50;
              min-height: 500px;
              width: 100%;
              text-align: center;
            }
            .video-frame img {
              width: 100px;
              margin-top: 30%;
              position: relative;
            }
            video {
              width: 100%;
                height: 100%;
                max-height: 100%;
            }
            .connecting-loader {
                position: absolute;
                height: 100%;
                width: 100%;
            }
            .connecting-message {
              color: #fff;
            }
            .doc-video {
                z-index: 999999;
                position: absolute;
            }
              .pat-video {
                  height: 150px;
                  width: 150px;
                  position: absolute;
                  bottom: 0;
                  left: 0;
                  z-index: 999999999;
              }
              #end-app {
                  position: absolute;
                  bottom: 0;
                  left: 0;
                  width: 100%;
              }
              .p-message {
                  margin-top: 20px;
              }

            </style>
      <?php endif; ?>
