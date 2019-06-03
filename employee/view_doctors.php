<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql="select * from doctors where employee_id = '" . $_COOKIE['userid'] . "'"; 
    $result=$db->display($sql); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">View Doctors</h3>

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
        paging: true,

        data: <?php echo json_encode($result); ?>,
        fields: [
            { name: "username", type: "text", title: "Username", width: 150},
            { name: "fname", type: "text", title: "First Name", width: 150},
            { name: "specialized", type: "text", title: "Specialized", width: 150},
            { name: "mobile", type: "text", title: "Mobile", width: 150},
            { itemTemplate: function(value, item) {
                var $text = $("<p>").text(item.MyField);
                var $link = $("<a>").attr("href", 'view_ind_doctor.php?id=' + item.doctor_id).text("View Doctor");
                return $("<div>").append($text).append($link);
                }
            },
        ]
    });
</script>

<?php include_once( '../footer.php'); ?>