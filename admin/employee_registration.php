<?php include_once('../header.php'); ?>

<?php 
	$message = '';
	$db = new Database();
	if( isset( $_POST['register'] ) ) {
        $sql = 'select * from employee where mobile = :mobile';
        $params = array(
                ':mobile' => $_POST['mobile']
            );
        if( !$db->display($sql, $params) ) {
            $dob = new DateTime($_POST['dob']);
            $dob = date_format($dob, 'Y-m-d');

            $sql = 'insert into employee(fname, lname, dob, sex, qualification, mobile, address_lane_1, address_lane_2, city, pin, country, password, code) values(:fname, :lname, :dob, :sex, :qualification, :mobile, :addresslane1, :addresslane2, :city, :pin, :country, :password, :code)';
            $params = array(
                    ':fname'    =>  $_POST['fname'],
                    ':lname'    =>  $_POST['lname'],
                    ':dob'      =>  $dob,
                    ':sex'      =>  $_POST['gender'],
                    ':qualification'    =>  $_POST['qualification'],
                    ':mobile'   =>  $_POST['mobile'],
                    ':addresslane1'  =>  $_POST['addresslane1'],
                    ':addresslane2'  => $_POST['addresslane2'],
                    ':city'     =>  $_POST['city'],
                    ':pin'      =>  $_POST['pin'],
                    ':country'  =>  $_POST['country'],
                    ':password' =>  md5($_POST['password']),
                    ':code'     =>  rand(1000,9999),
                );
            if( $db->execute_query($sql, $params) ) {
                
            $message = '<div class="alert alert-success" role="alert">Successfully registered! Please login using userid ' . $db->lastInsertId() . '</div>';
            }
            
        } else {
            $message = '<div class="alert alert-danger alert-dismissible" role="alert">Sorry Mobile number already exist</div>';
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
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>China</option>
                                <option>Nepal</option>
                                <option>Bhutan</option>
                                <option>Myanmar(Burma)</option>
                                <option>Bangladesh</option>
                                <option>Sri Lanka</option>
                                <option>Maldives</option>
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
                            <input type="number" class="form-control" name="pin" data-parsley-pattern="^[1-9][0-9]{5}$"  data-parsley-required="true" />
                            <label for="mobile" class="floating-label">Postal Code</label>
                        </div>
                        <div class="form-group form-material floating">
                            <label class="control-label q" for="qualification">Qualification</label>
                            <select name="qualification" class="form-control">
                              <option>SSLC</option>
                              <option>Plus Two</option>
                              <option>Graduate</option>
                              <option>Post Graduate</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" name="mobile"  data-parsley-required="true" />
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
                <div class="message" style="text-align: left;">
                    <?php if( $message ) echo $message; ?>
                </div>
                <div class="submit-button-cls" style="margin: 0">
                    <button  type="submit" name="register" class="btn btn-primary btn-block margin-top-10">Register</button>
                </div>
                
            </form>
        </div>
    </div>
<?php include_once('../footer.php'); ?>