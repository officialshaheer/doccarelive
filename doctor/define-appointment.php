<?php 
    include_once( '../header.php');

    $db = new Database();
    $message = null;

    if( isset( $_POST['define'] ) ) {
        $sql = 'select * from appointment_definition where app_name = :app_name and doctor_id = :doctor_id';
        $params = array(
                ':app_name' =>  $_POST['appName'],
                ':doctor_id'    =>  $_COOKIE['userid']
            );
        if( !$db->display($sql, $params) ) {
            $stmnt = 'insert into appointment_definition(doctor_id, app_name, start_time, patient_limit, note, fees) values( :doctor_id, :app_name, :start_time, :patient_limit, :note, :fees )';
            $params = array(
                    ':app_name'      =>  $_POST['appName'],
                    ':patient_limit' => $_POST['noOfPatients'],
                    ':doctor_id'     => $_COOKIE['userid'], 
                    ':start_time'    =>  $_POST['startTime'],
                    ':note'    =>  $_POST['note'],
                    ':fees'    =>  $_POST['fees']
                );
            if( $db->execute_query( $stmnt, $params ) ) {
                $message = '<div class="alert alert-success" role="alert">Successfully Created!</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">Some error occured!</div>';
            }
        } else {
            $message = '<div class="alert alert-danger" role="alert">Sorry Appointment already exist!</div>';
        }
    }


?>
    

    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Define Appointment</h3>
        </div>
        <div class="panel-body">
                <form method="post" action="" autocomplete="off" data-parsley-validate="">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                          <input type="text" class="form-control" name="appName" data-parsley-required="true" />
                          <label class="floating-label">Appointment Name</label>
                        </div>
                        <div class="form-group form-material floating clockpicker" data-autoclose="true">
                          <input type="text" class="form-control" name="startTime"     data-parsley-required="true" data-parsley-pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" />
                          <label class="floating-label">Start Time</label>
                        </div>
                        <div class="form-group form-material floating">
                          <input type="number" class="form-control" name="fees" data-parsley-required="true" />
                          <label class="floating-label">Appointment Fees</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                          <input type="number" class="form-control" name="noOfPatients"   data-parsley-required="true" maxlength="2" />
                          <label class="floating-label">Maximum no of Patients</label>
                        </div>
                        <div class="form-group form-material floating">
                          <textarea class="form-control" name="note" maxlength="200" rows="6"></textarea> 
                          <label class="floating-label">Notes / Requirements</label>
                        </div>
                        <div class="message.left">
                            <?php if( $message ) echo $message; ?>
                        </div>
                        <div class="form-group form-material floating">
                            <button type="submit" class="btn btn-primary" name="define">Create</button>
                        </div>
                    </div>
              </form>
        </div>
    </div>
        
</div>
</div>
<?php include_once( '../footer.php') ?>