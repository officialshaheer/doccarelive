<?php 
    include_once( '../header.php');

    $db = new Database();
    $message = null;

    if( isset( $_POST['update'] ) ) {
        $sql = 'select * from appointment_definition where app_name = :app_name and appdef_id <> :appdef_id';
        $params = array(
                ':app_name' =>  $_POST['appName'],
                ':appdef_id'    =>  $_POST['app_id']
            );
        if( !$db->display($sql, $params) ) {
            $stmnt = 'update appointment_definition set app_name=:app_name, start_time=:start_time, patient_limit=:patient_limit, note=:note, fees=:fees where appdef_id = :appdef_id';
            $params = array(
                    ':app_name'      =>  $_POST['appName'],
                    ':patient_limit' => $_POST['noOfPatients'],
                    ':start_time'    =>  $_POST['startTime'],
                    ':note'    =>  $_POST['note'],
                    ':fees'    =>  $_POST['fees'],
                    ':appdef_id' => $_POST['app_id']
                );
            if( $db->execute_query( $stmnt, $params ) ) {
                $message = '<div class="alert alert-success" role="alert">Successfully Updated!</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">Some error occured!</div>';
            }
        } else {
            $message = '<div class="alert alert-danger" role="alert">Sorry Appointment already exist!</div>';
        }
    }

    if( isset( $_GET['id'] ) ) {
        $sql = 'select * from appointment_definition where appdef_id = "' . $_GET['id'] . '" and doctor_id = "' . $_COOKIE['userid'] . '"';
        $app_def = $db->display($sql);

        if( $app_def ) {
            $app_def = $app_def[0];
?>
    

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Update Appointment</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" autocomplete="off" data-parsley-validate="">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="hidden" name="app_id" value="<?php echo $app_def['appdef_id']; ?>">
                          <input type="text" class="form-control" name="appName" value="<?php echo $app_def['app_name']; ?>"  data-parsley-required="true" />
                          <label class="floating-label">Appointment Name</label>
                        </div>
                        <div class="form-group form-material floating clockpicker" data-autoclose="true">
                          <input type="text" class="form-control" name="startTime" data-parsley-required="true" data-parsley-pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" value="<?php echo $app_def['start_time']; ?>" />
                          <label class="floating-label">Start Time</label>
                        </div>
                        <div class="form-group form-material floating">
                          <input type="number" class="form-control" value="<?php echo $app_def['fees']; ?>"  name="fees" data-parsley-required="true" />
                          <label class="floating-label">Appointment Fees</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                          <input type="number" class="form-control" value="<?php echo $app_def['patient_limit']; ?>"  name="noOfPatients"   data-parsley-required="true" maxlength="2" />
                          <label class="floating-label">Maximum no of Patients</label>
                        </div>
                        <div class="form-group form-material floating">
                          <textarea class="form-control" name="note" maxlength="200" rows="6"><?php echo $app_def['note']; ?></textarea> 
                          <label class="floating-label">Notes / Requirements</label>
                        </div>
                        <div class="message.left">
                            <?php if( $message ) echo $message; ?>
                        </div>
                        <div class="form-group form-material floating">
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>
<?php } else {echo '<div class="alert alert-danger">No appointments found!<div>';} ?>
<?php } else {echo '<div class="alert alert-danger">No appointments selected!<div>';} ?>

<?php include_once( '../footer.php') ?>