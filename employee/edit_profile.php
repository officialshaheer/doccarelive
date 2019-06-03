<?php include_once('../header.php'); ?>

<?php 
	$message = '';
	$db = new Database();
	if( isset( $_POST['register'] ) ) {
        $sql = 'update employee set fname=:fname, lname=:lname, qualification=:qualification, mobile=:mobile, address_lane_1=:addresslane1, address_lane_2=:addresslane2, city=:city, pin=:pin where employee_id = ' . $_COOKIE['userid'];
        $params = array(
                ':fname'    =>  $_POST['fname'],
                ':lname'    =>  $_POST['lname'],
                ':qualification'    =>  $_POST['qualification'],
                ':mobile'   =>  $_POST['mobile'],
                ':addresslane1'  =>  $_POST['addresslane1'],
                ':addresslane2'  => $_POST['addresslane2'],
                ':city'     =>  $_POST['city'],
                ':pin'      =>  $_POST['pin'],
            );
        if( $db->execute_query($sql, $params) ) {
            $message = '<div class="alert alert-success" role="alert">Profile updated</div>';
        }
    }
    $sql = 'select * from employee where employee_id = ' . $_COOKIE['userid'];
    $employee = $db->display($sql);
    $employee = $employee[0];
 ?>

    <div class="panel panel-bordered">
    	<div class="panel-heading">
            <h3 class="panel-title">Profile Updation</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="#" autocomplete="off" data-parsley-validate=""  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $employee['fname'] ?>" name="fname" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z ]*$" required="" />
                            <label class="floating-label">First Name</label>
                        </div>
                        <div class="form-group form-material floating">
                            <textarea class="form-control" name="addresslane1" data-parsley-required="true"><?php echo $employee['address_lane_1']; ?></textarea>
                            <label for="mobile" class="floating-label">Address lane 1</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $employee['city'] ?>" name="city"  data-parsley-required="true" />
                            <label for="mobile" class="floating-label">City</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="number" class="form-control" value="<?php echo $employee['pin'] ?>" name="pin"  data-parsley-required="true" data-parsley-pattern="^[1-9][0-9]{5}$"  minlength="6" maxlength="6"  />
                            <label for="mobile" class="floating-label">Postal Code</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $employee['lname'] ?>" name="lname"  data-parsley-required="true" data-parsley-pattern="^[a-zA-Z ]*$" required="" />
                            <label class="floating-label">Last Name</label>
                        </div>

                        <div class="form-group form-material floating">
                            <textarea class="form-control" name="addresslane2" data-parsley-required="true"><?php echo $employee['address_lane_2']; ?></textarea>
                            <label for="mobile" class="floating-label">Address lane 2</label>
                        </div>
                        <div class="form-group form-material floating">
                            <label class="control-label q" for="qualification">Qualification</label>
                            <select name="qualification" class="form-control">
                              <option <?php if( $employee['qualification'] == 'SSLC') echo 'selected'; ?>>SSLC</option>
                              <option <?php if( $employee['qualification'] == 'Plus Two') echo 'selected'; ?>>Plus Two</option>
                              <option <?php if( $employee['qualification'] == 'Graduate') echo 'selected'; ?>>Graduate</option>
                              <option <?php if( $employee['qualification'] == 'Post Graduate') echo 'selected'; ?>>Post Graduate</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $employee['mobile'] ?>" name="mobile"  data-parsley-required="true" />
                            <label for="mobile" class="floating-label">Mobile Phone</label>
                        </div>
                    </div> 
                </div>
                <div class="message" style="text-align: left;">
                    <?php if( $message ) echo $message; ?>
                </div>
                <div class="submit-button-cls" style="margin: 0">
                    <button  type="submit" name="register" class="btn btn-primary btn-block margin-top-10">Update</button>
                </div>
                
            </form>
        </div>
    </div>
<?php include_once('../footer.php'); ?>