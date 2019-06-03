<?php 
    include_once( '../header.php'); 
    $db=new Database();
    $comm_details = array(); 

    $sql = 'select * from commission where app_id in ( select app_id from appointment where appdef_id in ( select appdef_id from appointment_definition where doctor_id in ( select doctor_id from doctors where employee_id = "' . $_COOKIE['userid'] . '" )  ) )';
    $commissions = $db->display($sql); 

    $i=0;$total = 0;
    foreach ($commissions as $comm) {
        $sql = 'select * from appointment where app_id = ' . $comm['app_id'];
        $comm_details[$i] = array();
        array_push($comm_details[$i],$comm);
        $item = $db->display($sql);
        array_push( $comm_details[$i],$item[0] );
        $total += $comm['commission'];

        $sql = 'select * from appointment_definition where appdef_id = ' . $item[0]['appdef_id'];
        $def = $db->display($sql);
        array_push( $comm_details[$i],$def[0] );

        $sql = 'select * from patient where patient_id = ' . $item[0]['patient_id'];
        $doc = $db->display($sql);
        array_push( $comm_details[$i],$doc[0] );

        $i++;
    }
    $result = $comm_details;
    if( $result ) {
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Commission</h3>
            </div>
            <div class="panel-body">
                
                <div id="jsGrid"></div>
                <b>Total Commission : <?php echo $total; ?></b>
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
        filtering: true,

        data: <?php echo json_encode($result); ?>,
        fields: [
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[0].app_id);
                }, title: "Appointment Id"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[0].date);
                }, title: "Date"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[2].app_name);
                }, title: "Appointment"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[3].fname + ' ' + item[3].lname);
                }, title: "Doctor"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[3].fname + ' ' + item[3].lname);
                }, title: "Patient"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item[0].commission);
                }, title: "Commission"
            },
        ]
    });
</script>
<?php } else {'<div class="alert alert-danger">No commissions</div>';} ?>
<?php include_once( '../footer.php'); ?>