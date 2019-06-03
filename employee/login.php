<?php 
    
    include_once('../includes/connection.php');

    $db = new Database();
    $message = null;

    if( isset( $_POST['login'] ) ) {
        $sql = 'select * from employee where employee_id = :employee_id and password = :password';
        $params = array(
                ':employee_id' =>  $_POST['employee_id'],
                ':password' =>  md5($_POST['password'])
            );
        $employee = $db->display( $sql, $params );
        if( $employee ) {
            setcookie('userid', $employee[0]['employee_id'], time() + (86400 * 30), "/");
            setcookie('type', 'employee', time() + (86400 * 30), "/");
            header('Location: dashboard.php');
            exit();
        } else {
            $message = '<div class="alert alert-danger alert-dismissible" role="alert">Invalid Employee ID or password!</div>';
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

    <title>Login | Employee</title>

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

    <!-- Page -->
    <link rel="stylesheet" href="../assets/examples/css/pages/login-v3.min-v2.2.0.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="../assets/global/fonts/material-design/material-design.min-v2.2.0.css">
    <link rel="stylesheet" href="../assets/global/fonts/brand-icons/brand-icons.min-v2.2.0.css">

    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700'>

    <!-- Scripts -->
    <script src="../assets/global/vendor/modernizr/modernizr.min.js"></script>
    <script src="../assets/global/vendor/breakpoints/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>

<body class="page-login-v3 layout-full">
    <div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle">
            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <img class="brand-img" src="../assets/images/logo-blue.png" alt="...">
                        <h2 class="brand-text font-size-18">Online Consultation</h2>
                    </div>
                    <form method="post" action=""  autocomplete="off" data-parsley-validate="">
                        <div class="form-group form-material floating">
                            <input type="number" class="form-control" name="employee_id"  data-parsley-required="true" />
                            <label class="floating-label">Employee ID</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="password" class="form-control" name="password"  data-parsley-required="true" />
                            <label class="floating-label">Password</label>
                        </div>
                        <div class="message">
                            <?php if( $message ) echo $message; ?>
                        </div>
                        <div class="submit-button-cls">
                            <button type="submit" name="login" class="btn btn-primary btn-block btn-lg margin-top-40">Sign in</button>
                        </div>
                    </form>
                    </p>
                </div>
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

    <!-- Plugins -->
    <script src="../assets/global/vendor/switchery/switchery.min.js"></script>
    <script src="../assets/global/vendor/intro-js/intro.min.js"></script>
    <script src="../assets/global/vendor/screenfull/screenfull.min.js"></script>
    <script src="../assets/global/vendor/slidepanel/jquery-slidePanel.min.js"></script>

    <!-- Plugins For This Page -->
    <script src="../assets/global/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>

    <!-- Scripts -->
    <script src="../assets/global/js/core.min.js"></script>
    <script src="../assets/js/site.min.js"></script>

    <script src="../assets/global/js/sections/menu.min.js"></script>
    <script src="../assets/global/js/sections/menubar.min.js"></script>
    <script src="../assets/global/js/sections/gridmenu.min.js"></script>
    <script src="../assets/global/js/sections/sidebar.min.js"></script>

    <script src="../assets/global/js/configs/config-colors.min.js"></script>
    <script src="../assets/js/configs/config-tour.min.js"></script>

    <script src="../assets/global/js/components/asscrollable.min.js"></script>
    <script src="../assets/global/js/components/animsition.min.js"></script>
    <script src="../assets/global/js/components/slidepanel.min.js"></script>
    <script src="../assets/global/js/components/switchery.min.js"></script>


    <script src="../assets/global/js/components/jquery-placeholder.min.js"></script>
    <script src="../assets/global/js/components/material.min.js"></script>
    <script src="../assets/global/js/parsley.js"></script>
    <script type="text/javascript" src="../assets/global/js/main.js"></script>

</body>

</html>