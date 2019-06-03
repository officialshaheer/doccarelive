<?php 
    include_once( '../header.php'); 
    $db=new Database();
    $earn_details = array(); 
    $total = null;

    $sql = 'select * from appointment_definition where doctor_id = "' . $_COOKIE['userid'] . '"';
    $appointments = $db->display($sql);

    if( $appointments ) {

        foreach ($appointments as $value) {
            $sql = 'select count(*) from appointment where appdef_id = "' . $value['appdef_id'] . '"';
            $apps = $db->display($sql);
            $earn_details[] = array(
                    'app_name' => $value['app_name'],
                    'fees' => $value['fees'],
                    'total_apps' => $apps[0],
                    'total' =>  $apps[0][0] * $value['fees']
                );
            $total += $apps[0][0] * $value['fees'];
        }
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Earnings</h3>
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

        data: <?php echo json_encode($earn_details); ?>,
        fields: [
            { itemTemplate: function(value, item) {
                return $("<div>").append(item.app_name);
                }, title: "Appointment"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item.fees);
                }, title: "Fees"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item.total_apps[0]);
                }, title: "Total appointments taken"
            },
            { itemTemplate: function(value, item) {
                return $("<div>").append(item.total);
                }, title: "Total"
            },
        ]
    });
</script>
<?php } else {'<div class="alert alert-danger">No commissions</div>';} ?>
<?php include_once( '../footer.php'); ?>