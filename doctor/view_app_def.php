<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql="select * from appointment_definition where doctor_id = '" . $_COOKIE['userid'] . "'"; 
    $result=$db->display($sql); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Appintment Definition</h3>

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

        data: <?php echo json_encode($result); ?>,
        fields: [
            { name: "app_name", type: "text", title: "Appontment Name", width: 150},
            { name: "start_time", type: "text", title: "Start Time", width: 150},
            { name: "patient_limit", type: "text", title: "Patient Limit", width: 150},
            { name: "fees", type: "text", title: "Fee", width: 150},
            { name: "note", type: "text", title: "Note", width: 150},
        ]
    });
</script>

<?php include_once( '../footer.php'); ?>