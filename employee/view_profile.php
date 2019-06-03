<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql='select * from employee where employee_id = ' .$_COOKIE['userid'] ; 
    $employee=$db->display($sql); 
    if( $employee ) { $employee = $employee[0];

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
                                <?php echo $employee['employee_id'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Full Name
                            </td>
                            <td>
                                <?php echo ucfirst($employee['fname'] . ' ' . $employee['lname']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Date of Birth
                            </td>
                            <td>
                                <?php echo $employee['dob'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Gender
                            </td>
                            <td>
                                <?php echo $employee['sex']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Mobile
                            </td>
                            <td>
                                <?php echo $employee['mobile']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Address
                            </td>
                            <td>
                                <?php echo $employee[ 'address_lane_1'] . ' ' .$employee[ 'address_lane_2'] ; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                City
                            </td>
                            <td>
                                <?php echo $employee['city']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                pin
                            </td>
                            <td>
                                <?php echo $employee['pin']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Country
                            </td>
                            <td>
                                <?php echo $employee['country']; ?>
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