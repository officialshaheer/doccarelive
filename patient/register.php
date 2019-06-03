<?php 
    include_once('../includes/connection.php');
    include_once('../includes/class.fileuploader.php');

    $db = new Database();
    $message = null;
    if( isset( $_POST['register'] ) ) {
        $sql = 'select username from patient where username = :username';
        $params = array(
                ':username' => $_POST['username']
            );
        if( !$db->display($sql, $params) ) {

            $dob = new DateTime($_POST['dob']);
            $dob = date_format($dob, 'Y-m-d');

            $sql = 'insert into patient(username, fname, lname, dob, sex, mobile, address_lane_1, address_lane_2, city, pin, country, medical_history, password, code) values(:username, :fname, :lname, :dob, :sex, :mobile, :addresslane1, :addresslane2, :city, :pin, :country, :history, :password, :code)';
            $params = array(
                    ':username' =>  $_POST['username'],
                    ':fname'    =>  $_POST['fname'],
                    ':lname'    =>  $_POST['lname'],
                    ':dob'      =>  $dob,
                    ':sex'      =>  $_POST['gender'],
                    ':mobile'   =>  $_POST['mobile'],
                    ':addresslane1'  =>  $_POST['addresslane1'],
                    ':addresslane2'  => $_POST['addresslane2'],
                    ':city'     =>  $_POST['city'],
                    ':pin'      =>  $_POST['pin'],
                    ':country'  =>  $_POST['country'],
                    ':history'    =>  $_POST['history'],
                    ':password' =>  md5($_POST['password']),
                    ':code'     =>  rand(1000,9999)
                );
            if( $db->execute_query($sql, $params) ) {

                $last_id = $db->lastInsertId();

                $FileUploader = new FileUploader('files', array(
                    
                ));
                
                // call to upload the files
                $upload = $FileUploader->upload();
                
                if($upload['isSuccess']) {
                    // get the uploaded files
                    $files = $upload['files'];

                    foreach ($files as $key => $file) {
                        $name = $file['name'];

                        $stmnt = 'insert into documents (url, patient_id) values(:url, :patient_id)';
                        $params = array(
                                ':url'  =>  $name,
                                ':patient_id'  =>  $last_id
                            );
                        $db->execute_query($stmnt, $params);
                    }
                }
                if($upload['hasWarnings']) {
                    // get the warnings
                    $warnings = $upload['warnings'];
                };
                $message = '<div class="alert alert-success" role="alert">Successfully registered! <a href="login.php">Sign In</a></div>';
            }

            
        } else {
            $message = '<div class="alert alert-danger alert-dismissible" role="alert">Sorry username already exist</div>';
        }

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

    <title>Register V3 | Patient Registration</title>

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
    <link rel="stylesheet" href="../assets/global/vendor/icheck/icheck.min-v2.2.0.css">
    <link rel="stylesheet" href="../assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min-v2.2.0.css">
    <link rel="stylesheet" href="../assets/global/vendor/dropify/dropify.min-v2.2.0.css">
    <link rel="stylesheet" type="text/css" href="../assets/file_upload/jquery.fileuploader.css">

    <!-- Page -->
    <link rel="stylesheet" href="../assets/examples/css/pages/register-v2.min-v2.2.0.css">

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
    <script>
        Breakpoints();
    </script>

    <style type="text/css">
        .page-register-v3 .panel {
            width: 900px;
        }
        .dropify-wrapper {
            height: 100px;
        }
        .page-register-main {
            width: 40%;
        }
        .page-register-v2 form {
            width: auto;
        }
        .section-form {
            margin: 60px -15px;
        }
        .datepicker {
            color: #757575;
        }
        .ribbon {
            display: none;
        }
    </style>
</head>

<body class="page-register-v2 layout-full page-dark">

      <!-- Page -->
  <div class="page animsition" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content">
      <div class="page-brand-info">
        <div class="brand">
          <img class="brand-img" src="../assets/images/logo@2x.png" alt="...">
          <h2 class="brand-text font-size-40">Online Consultation</h2>
        </div>
        <p class="font-size-20"></p>
      </div>

      <div class="page-register-main">
        <div class="brand visible-xs">
          <img class="brand-img" src="../assets/images/logo-blue@2x.png" alt="...">
          <h3 class="brand-text font-size-40">Online Consultation</h3>
        </div>
        <h3 class="font-size-24">Sign Up</h3>
        <p></p>
                    <form method="post" action="#" autocomplete="off" data-parsley-validate=""  enctype="multipart/form-data">
                        <div class="row section-form">
                            <div class="col-md-6">

                            
                                <div class="ribbon ribbon-bookmark custom-ribbon ribbon-primary">
                                    <span class="ribbon-inner">Basic Info</span>
                                </div>

                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="fname" data-parsley-required="true" />
                                    <label class="floating-label">First Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" id="date-of-birth-picker" name="dob" class="form-control"  data-parsley-required="true">
                                    <label class="floating-label">Date of Birth</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="addresslane1"  data-parsley-required="true" />
                                    <label for="mobile" class="floating-label">Address lane 1</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="city"  data-parsley-required="true" />
                                    <label for="mobile" class="floating-label">City</label>
                                </div>

                                <div class="form-group form-material floating">
                                    <label class="control-label" for="country">Country</label>
                                    <select class="form-control" name="country"  data-parsley-required="true">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="lname"  data-parsley-required="true" />
                                    <label class="floating-label">Last Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="radio" value="Male" name="gender" checked="">
                                    <label for="gender">Male</label>
                                    <input type="radio" value="Female" name="gender">
                                    <label for="gender">Female</label>
                                </div>

                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="addresslane2"  data-parsley-required="true" />
                                    <label for="mobile" class="floating-label">Address lane 2</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" name="pin"   data-parsley-pattern="^[1-9][0-9]{5}$"  data-parsley-required="true" />
                                    <label for="mobile" class="floating-label">Postal Code</label>
                                </div>
                            </div>
                        </div>
                        <div class="row section-form">
                            
                            <div class="col-md-12">

                                <div class="ribbon ribbon-bookmark custom-ribbon ribbon-primary">
                                    <span class="ribbon-inner">Ribbon</span>
                                </div>
                                
                                <div class="form-group form-material floating">
                                    <textarea class="form-control" name="history"  data-parsley-required="true" rows="5"></textarea>
                                    <label for="history" class="floating-label">Medical history(if any)</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-material floating">
                                    <input type="file" name="files" required="">
                                    <label for="hospital" class="floating-label" style="text-align: left;">This document should in jpeg files(identity proof, certificates etc).</label>
                                </div>
                            </div>
                        </div>


                        <div class="row section-form" style="margin-bottom: 30px;">
                            <div class="col-md-6">
                                <div class="ribbon ribbon-bookmark custom-ribbon ribbon-primary">
                                    <span class="ribbon-inner">Account Info</span>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="email" class="form-control" name="username"  data-parsley-required="true" />
                                    <label for="username" class="floating-label">Username</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control"  data-parsley-pattern="^[789]\d{9}$" name="mobile"  data-parsley-required="true" />
                                    <label for="mobile" class="floating-label">Mobile Phone</label>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="password" id="password" name="password" class="form-control" name="repassword" data-parsley-minlength="8"  data-parsley-required="true" />
                                    <label class="floating-label">Password</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="password" class="form-control" name="rePassword" data-parsley-equalto="#password"  data-parsley-minlength="8"  data-parsley-required="true" />
                                    <label class="floating-label">Re-enter Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="message">
                            <?php if( $message ) echo $message; ?>
                        </div>
                        <div class="submit-button-cls">
                            <button  type="submit" name="register" class="btn btn-primary btn-block btn-lg margin-top-10">Sign up</button>
                        </div>
                    </form>
                    <p>Have account already? Please go to <a href="login.php">Sign In</a></p>

        <footer class="page-copyright">
          <div class="social">
            <a class="btn btn-icon btn-round social-twitter" href="javascript:void(0)">
              <i class="icon bd-twitter" aria-hidden="true"></i>
            </a>
            <a class="btn btn-icon btn-round social-facebook" href="javascript:void(0)">
              <i class="icon bd-facebook" aria-hidden="true"></i>
            </a>
            <a class="btn btn-icon btn-round social-google-plus" href="javascript:void(0)">
              <i class="icon bd-google-plus" aria-hidden="true"></i>
            </a>
          </div>
        </footer>
      </div>

    </div>
  </div>
  <!-- End Page -->

    <!-- Core  -->
    <script src="../assets/global/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/global/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/global/vendor/animsition/animsition.min.js"></script>
    <script src="../assets/global/vendor/asscroll/jquery-asScroll.min.js"></script>
    <script src="../assets/global/vendor/mousewheel/jquery.mousewheel.min.js"></script>
    <script src="../assets/global/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>
    <script src="../assets/global/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>
    <script src="../assets/global/vendor/waves/waves.min.js"></script>

    <!-- Plugins -->
    <script src="../assets/global/vendor/switchery/switchery.min.js"></script>
    <script src="../assets/global/vendor/intro-js/intro.min.js"></script>
    <script src="../assets/global/vendor/screenfull/screenfull.min.js"></script>
    <script src="../assets/global/vendor/slidepanel/jquery-slidePanel.min.js"></script>

    <!-- Plugins For This Page -->
    <script src="../assets/global/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>
    <script src="../assets/global/vendor/icheck/icheck.min.js"></script>
    <script src="../assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/global/vendor/dropify/dropify.min.js"></script>

    <!-- Scripts -->
    <script src="../assets/global/js/core.min.js"></script>
    <script src="../assets/js/site.min.js"></script>

    <script src="../assets/js/sections/menu.min.js"></script>
    <script src="../assets/js/sections/menubar.min.js"></script>
    <script src="../assets/js/sections/sidebar.min.js"></script>

    <script src="../assets/global/js/configs/config-colors.min.js"></script>
    <script src="../assets/js/configs/config-tour.min.js"></script>

    <script src="../assets/global/js/components/asscrollable.min.js"></script>
    <script src="../assets/global/js/components/animsition.min.js"></script>
    <script src="../assets/global/js/components/slidepanel.min.js"></script>
    <script src="../assets/global/js/components/switchery.min.js"></script>
    <script src="../assets/global/js/components/tabs.min.js"></script>
    <script type="text/javascript" src="../assets/file_upload/jquery.fileuploader.js"></script>


    <script src="../assets/global/js/components/jquery-placeholder.min.js"></script>
    <script src="../assets/global/js/components/material.min.js"></script>
    <script src="../assets/global/js/parsley.js"></script>
    <script type="text/javascript" src="../assets/global/js/main.js"></script>
    <script type="text/javascript">
        $('input[name="files"]').fileuploader({extension:['jpg','jpeg','png']});
    </script>
</body>

</html>