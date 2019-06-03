<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql='select * from doctors where doctor_id = ' .$_COOKIE['userid'] ; 
    $doctor=$db->display($sql); 
    if( $doctor ) { $doctor = $doctor[0];

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Profile</h3>

            </div>
            <div class="panel-body">
            <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                Username
                            </td>
                            <td>
                                <?php echo $doctor['username'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Full Name
                            </td>
                            <td>
                                <?php echo ucfirst($doctor['fname'] . ' ' . $doctor['lname']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Date of Birth
                            </td>
                            <td>
                                <?php echo $doctor['dob'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Gender
                            </td>
                            <td>
                                <?php echo $doctor['sex']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Specilization
                            </td>
                            <td>
                                <?php echo $doctor['specialized']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Mobile
                            </td>
                            <td>
                                <?php echo $doctor['mobile']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Address
                            </td>
                            <td>
                                <?php echo $doctor[ 'address_lane_1'] . ' ' .$doctor[ 'address_lane_2'] ; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                City
                            </td>
                            <td>
                                <?php echo $doctor['city']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                pin
                            </td>
                            <td>
                                <?php echo $doctor['pin']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Country
                            </td>
                            <td>
                                <?php echo $doctor['country']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                About
                            </td>
                            <td>
                                <?php echo $doctor['about']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Remarks
                            </td>
                            <td>
                                <?php echo $doctor['remarks']; ?>
                            </td>
                        </tr>
                        
                    </tbody>
            </table>
            </div>
        </div>
    </div>
    <?php } else { echo '<div class="alert alert-danger">No Employee found</div>';} ?>
</div>

<?php include_once( '../footer.php'); ?>