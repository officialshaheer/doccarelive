<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql="select * from appointment_definition"; 
    $result=$db->display($sql); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Appointment</h3>

            </div>
            <div class="panel-body">
                <!-- Contacts -->
                <table class="table is-indent tablesaw">
                    <thead>
                        <tr>

                            <th class="cell-300" scope="col">Appointment Name</th>
                            <th class="cell-300" scope="col">Start Time</th>
                            <th scope="cell-300">Appointment Fees</th>
                            <th scope="col">Maximum no of Patients</th>
                            <th scope="col">Notes / Requirements</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $value) {?>
                        <tr class="panel-hover-tb">
                            <td class="cell-30">
                                <?php echo $value[ 'app_name']; ?>
                            </td>
                            <td class="cell-300">
                                <?php echo $value[ 'start_time']; ?>
                            </td>
                            <td class="cell-300">
                                <?php echo $value[ 'fees']; ?>
                            </td>
                            <td class="cell-300">
                                <?php echo $value[ 'patient_limit']; ?>
                            </td>
                            <td class="cell-300">
                                <?php echo $value[ 'note']; ?>
                            </td>
                            <td class="suf-cell"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

<?php include_once( '../footer.php'); ?>