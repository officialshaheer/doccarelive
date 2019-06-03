
<?php
include_once('../header.php');
$db=new Database();
$sql='select * from appointment_definition where doctor_id = "' . $_COOKIE['userid'] . '"';
$result=$db->display($sql);
?>
        

    <div class="panel">
<div class="panel-body">
<h3 class="title-hero">
    Edit Appointment
</h3>
<div class="example-box-wrapper">

<table id="datatable-row-highlight" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
<tr>
    
    <th>Appointment Name</th>
    <th>Start Time</th>
    <th>Appointment fees</th>
    <th>Maximum no of patients</th>
    <th>Notes / Requirements</th>
    <th>Edit</th>
    
</tr>
</thead>
<tbody>
    <?php  
     foreach($result as $value) {?>
<tr>
    
    <td><?php echo $value['app_name']; ?></td>
    <td><?php echo $value['start_time']; ?></td>
    <td><?php echo $value['fees']; ?></td>
    <td><?php echo $value['patient_limit']; ?></td>
    <td><?php echo $value['note']; ?></td>
    <td><a href="update_appointment.php?id=<?php echo $value['appdef_id']; ?>" class="btn btn-primary">Edit</a> </td>
    
</tr>
<?php 
     }
    ?> 
</tbody>
</table>
</div>
</div>
</div>
<?php include_once('../footer.php');  ?>