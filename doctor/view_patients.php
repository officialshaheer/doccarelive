<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql='select * from patient where patient_id in ( select patient_id from  appointment where appdef_id in (select appdef_id from appointment_definition where doctor_id = ' . $_COOKIE['userid'] . ' ) )'; 
    $patients=$db->display($sql);
    if( $patients ) { 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Patient</h3>

            </div>
            <div class="panel-body">
                
                <div id="jsGrid"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#jsGrid").jsGrid({
        width: "100%",
        height: "400px",
        sorting: true,
        paging: true,

        data: <?php echo json_encode($patients); ?>,
        fields: [
            { name: "username", type: "text", title: "Username", width: 150},
            { name: "fname", type: "text", title: "First Name", width: 150},
            { name: "lname", type: "text", title: "Last Name", width: 150},
            { name: "mobile", type: "text", title: "Mobile", width: 150},
            { itemTemplate: function(value, item) {
                var $text = $("<p>").text(item.MyField);
                var $link = $("<a>").attr("href", 'view_ind_patient.php?id=' + item.patient_id).text("View Patient");
                return $("<div>").append($text).append($link);
                }
            },
        ]
    });
</script>
<?php } else {echo '<div class="alert alert-danger">No patients found!</div>';} ?>
<?php include_once( '../footer.php'); ?>