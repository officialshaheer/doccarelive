<?php include_once( '../header.php' ); ?>

<?php 
    $db = new Database();
    $sql = 'select * from appointment as ap inner join appointment_definition as ad where ap.patient_id = "' . $_COOKIE['userid'] . '" and ap.appdef_id = ad.appdef_id and `date` >= CURDATE() and ap.prescription is null order by date desc';
    $appointments = $db->display($sql);
?>

<style type="text/css">
    .panel-hover-tb:hover {
        background: #efefef;
        cursor: pointer;
        border-bottom: 1px solid #e0e0e0;
    }
    .panel-hover-tb a {
        text-decoration: none;
    }
</style>

    <div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Upcoming Appontments</h3>
        </div>
        <div class="panel-body">
            <!-- Contacts -->
            <?php if($appointments): ?>
            <table class="table is-indent tablesaw">
                <thead>
                    <tr>
                        <th class="cell-30" scope="col">
                        </th>
                        <th class="cell-300" scope="col">Appointment Name</th>
                        <th class="cell-300" scope="col">Appontment Date/Time</th>
                        <th scope="cell-300">Doctor</th>
                        <th scope="col">Token Number</th>
                        <th scope="col">Requirements</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appointment) { ?>
                    <tr class="panel-hover-tb">
                        <td class="cell-30">
                        </td>
                        <td class="cell-300">
                            <?php echo ucfirst( $appointment['app_name'] ); ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['date']; ?> / 
                            <?php echo $appointment['start_time']; ?>
                        </td>
                        <td>
                            <?php 
                                $sql = 'select * from doctors where doctor_id = ' . $appointment['doctor_id'];
                                if( $doctor = $db->display($sql) ) $doctor = $doctor[0];
                             ?>
                            <?php echo ucfirst( $doctor['fname'] . $doctor['lname'] ); ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['token_no']; ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['note']; ?>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        <?php else: echo'<div class="alert alert-info">No Upcoming appointments</div>'; endif; ?>
        </div>
    </div>
    </div>

<?php include_once( '../footer.php' ); ?>