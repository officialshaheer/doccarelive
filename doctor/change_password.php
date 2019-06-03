<?php include_once('../header.php'); ?>

<?php 
	$message = '';
	$db = new Database();
	if( isset( $_POST['register'] ) ) {
        $sql = 'select * from doctors where password = :password and doctor_id = :doctor_id';
        $params = array(
                ':password' => md5($_POST['current_password']),
                ':doctor_id' => $_COOKIE['userid']
            );
        if( $db->display($sql, $params) ) {

            $sql = 'update doctors set password = :password where doctor_id = ' . $_COOKIE['userid'];
            $params = array(
                    ':password' =>  md5($_POST['password']),
                );
            if( $db->execute_query($sql, $params) ) {
                $message = '<div class="alert alert-success" role="alert">Password changed</div>';
            }
            
        } else {
            $message = '<div class="alert alert-danger alert-dismissible" role="alert">Sorry incurrct old password</div>';
        }

    }
 ?>

    <div class="panel panel-bordered">
    	<div class="panel-heading">
            <h3 class="panel-title">Employee Registration</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="#" autocomplete="off" data-parsley-validate=""  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="password" class="form-control" name="current_password"  data-parsley-required="true" />
                            <label for="current_password" class="floating-label">Current Password</label>
                        </div>
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
                <div class="message" style="text-align: left;">
                    <?php if( $message ) echo $message; ?>
                </div>
                <div class="submit-button-cls" style="margin: 0">
                    <button  type="submit" name="register" class="btn btn-primary btn-block margin-top-10">Change password</button>
                </div>
            </form>
        </div>
    </div>
<?php include_once('../footer.php'); ?>