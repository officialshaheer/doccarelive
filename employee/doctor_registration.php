<?php 
    include_once('../header.php');
    include_once('../includes/class.fileuploader.php');

    $db = new Database();
    $message = null;
    // getting spcializations from db
    $sql = 'select * from specialization';
    $specialization = $db->display($sql);

    if( isset( $_POST['register'] ) ) {
        $sql = 'select username from doctors where username = :username';
        $params = array(
                ':username' => $_POST['username']
            );
        if( !$db->display($sql, $params) ) {
            $dob = new DateTime($_POST['dob']);
            $dob = date_format($dob, 'Y-m-d');

            $sql = 'insert into doctors(username, employee_id, fname, lname, dob, sex, qualification, specialized, hospital, mobile, address_lane_1, address_lane_2, city, pin, country, about, password, code) values(:username, :employee_id, :fname, :lname, :dob, :sex, :qualification, :specialized, :hospital, :mobile, :addresslane1, :addresslane2, :city, :pin, :country, :about, :password, :code)';
            $params = array(
                    ':username' =>  $_POST['username'],
                    ':employee_id'  =>  $_COOKIE['userid'],
                    ':fname'    =>  $_POST['fname'],
                    ':lname'    =>  $_POST['lname'],
                    ':dob'      =>  $dob,
                    ':sex'      =>  $_POST['gender'],
                    ':qualification'    =>  $_POST['qualification'],
                    ':specialized'  =>  $_POST['specialized'],
                    ':hospital' =>  $_POST['hospital'],
                    ':mobile'   =>  $_POST['mobile'],
                    ':addresslane1'  =>  $_POST['addresslane1'],
                    ':addresslane2'  => $_POST['addresslane2'],
                    ':city'     =>  $_POST['city'],
                    ':pin'      =>  $_POST['pin'],
                    ':country'  =>  $_POST['country'],
                    ':about'    =>  $_POST['about'],
                    ':password' =>  md5($_POST['password']),
                    ':code'     =>  rand(1000,9999)
                );
            if( $db->execute_query($sql, $params) ) {
                $message = '<div class="alert alert-success" role="alert">Successfully registered!</div>';

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

                        $stmnt = 'insert into documents (url, doctor_id) values(:url, :doctor_id)';
                        $params = array(
                                ':url'  =>  $name,
                                ':doctor_id'  =>  $last_id
                            );
                        $db->execute_query($stmnt, $params);
                    }
                }
                if($upload['hasWarnings']) {
                    // get the warnings
                    $warnings = $upload['warnings'];
                };
            }
            
        } else {
            $message = '<div class="alert alert-danger alert-dismissible" role="alert">Sorry username already exist</div>';
        }

    }

?>
<div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Doctor Registration</h3>
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
                        <input type="text" id="date-of-birth-picker" name="dob" class="datepicker-orient-bottom datepicker form-control"  data-parsley-required="true" datepicker-orient-bottom="true">
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
                        <input type="number" class="form-control"  data-parsley-pattern="^[1-9][0-9]{5}$" name="pin"  data-parsley-required="true" />
                        <label for="mobile" class="floating-label">Postal Code</label>
                    </div>
                    
                    <div class="form-group form-material floating">
                        <textarea class="form-control" name="about"  data-parsley-required="true" rows="2"></textarea>
                        <label for="about" class="floating-label">About Doctor</label>
                    </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-6">

                    <div class="form-group form-material floating">
                        <label class="control-label q" for="qualification">Qualification</label>
                        <select class="form-control" name="qualification"  data-parsley-required="true">
                            <option>MBBS,BMBS,MBChB,MBBCh</option>
                            <option>MD,Dr.MuD,Dr.Med</option>
                            <option>DO</option>
                            <option>MD(Res),DM</option>
                            <option>MMSc,MMedSc</option>
                            <option>MM,MMed</option>
                            <option>MS,MSurg,MChir,MCh,ChM,CM</option>
                        </select>
                    </div>

                    <div class="form-group form-material floating">
                        <label class="control-label q" for="specialized">Specialization</label>
                        <select class="form-control" name="specialized"  data-parsley-required="true">
                            <?php foreach ($specialization as $value) {
                                echo '<option value="' . $value['specialization_id'] . '">' . $value['specialization'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group form-material floating">
                        <input type="text" class="form-control" name="hospital" />
                        <label for="hospital" class="floating-label">Current working hostpital(if any)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-material floating">
                        <input type="file" name="files" required="">
                        <label for="hospital" class="floating-label" style="text-align: left;">This document should in jpeg files(identity proof, certificates etc).</label>
                    </div>
                </div>
            </div>


            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-6">
                    <div class="form-group form-material floating">
                        <input type="email" class="form-control" name="username"  data-parsley-required="true" />
                        <label for="username" class="floating-label">Username</label>
                    </div>
                    <div class="form-group form-material floating">
                        <input type="text" class="form-control" name="mobile" data-parsley-pattern="^[789]\d{9}$"  data-parsley-required="true" />
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
        </p>
    </div>
</div>
<style type="text/css">
    .datepicker {
        z-index: 99999999;
    }
</style>
<script type="text/javascript">
    $('input[name="files"]').fileuploader({extension:['jpg','jpeg','png']});
    $(document).on('show', $('.datepicker').datepicker(), function() {
        $('.datepicker').removeClass('datepicker-orient-top');
        $('.datepicker').addClass('datepicker-orient-bottom');
    });
</script>
<?php include_once('../footer.php'); ?>