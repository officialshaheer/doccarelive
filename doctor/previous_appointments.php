<?php 
    include_once( '../header.php');

    $db = new Database();
    $message = null;
    $app_dates = null;

    if( isset( $_POST['appdef_id'] ) ) {
        $sql = 'select * from appointment where appdef_id  = "' . $_POST['appdef_id'] . '" and date <= CURDATE() group by date';
        $app_dates = $db->display($sql);
    }

    if( isset( $_POST['appdef_id'] ) && isset( $_POST['app_date'] ) ) { 
        $sql = 'select * from appointment as app inner join patient as pat where app.appdef_id  = "' . $_POST['appdef_id'] . '" and app.date = "' . $_POST['app_date'] . '" and pat.patient_id = app.patient_id';
        $prev_apmnts = $db->display($sql);
    }

    $sql = 'select * from appointment_definition where doctor_id = ' . $_COOKIE['userid'];
    $app_defs = $db->display($sql);
    if( $app_defs ) {
?>

<button type="button" id="trgigger-chatioi" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalioi">Open Modal</button>

<div id="myModalioi" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;min-height: 500px;max-height: 500px;overflow-y: hidden;">
    <div class="modal-dialog"  style="width: 50%;">
            <div class="panel-body" style="padding-bottom: 0;">
                <div class="chat-box" style="overflow-x: hidden;overflow-y: scroll;max-height: 500px;">
                    <div class="chats" id="chat-content2" style="padding-bottom: 0;"></div>
                </div>
            </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Prev Appointments</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" autocomplete="off" data-parsley-validate="">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <select name="appdef_id" class="form-control" onchange="this.form.submit();">
                                <option></option>
                                <?php foreach ($app_defs as $value): ?>
                                    <option value="<?php echo $value['appdef_id']; ?>" <?php if( isset($_POST['appdef_id'])) if( $_POST['appdef_id'] ==  $value['appdef_id'] ) echo ' selected'; ?>><?php echo $value['app_name']; ?></option>
                                <?php endforeach ?>
                            </select>
                          <label class="floating-label">Appointment Name</label>
                        </div>
                    </div>
                </form>
                <?php if( $app_dates ): ?>
                <form method="post" action="" autocomplete="off" data-parsley-validate="">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="hidden" name="appdef_id" value="<?php echo $_POST['appdef_id']; ?>">
                            <select name="app_date" class="form-control" onchange="this.form.submit();">
                                <option></option>
                                <?php foreach ($app_dates as $value): ?>
                                    <option value="<?php echo $value['date']; ?>" <?php if( isset($_POST['app_date'])) if( $_POST['app_date'] ==  $value['date'] ) echo ' selected'; ?>><?php echo $value['date']; ?></option>
                                <?php endforeach ?>
                            </select>
                          <label class="floating-label">Appointment Date</label>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">

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

        data: <?php echo json_encode($prev_apmnts); ?>,
        fields: [
            { name: "fname", type: "text", title: "Patient Name", width: 150},
            { name: "token_no", type: "text", title: "Token No", width: 150},
            { name: "prescription", type: "text", title: "Prescription", width: 150},
            { itemTemplate: function(value, item) {
                    var done = null;
                    if( item.prescription ) {
                        done = 'Attended';
                    }else {
                        done = 'Not Attended';
                    }
                    return $("<div>").append(done);
                },title: "Attended",
            },
            { itemTemplate: function(value, item) {
                    var button = 'No conversations';
                    if( item.prescription ) {
                        var button = '<button class="view_chats btn btn-success" data-id="'+ item.patient_id +'">View full conversation</button>';
                    }
                    return $("<div>").append(button);
                },title: "Conversation",
            },
        ]
    });
</script>


<script type="text/javascript">
    $('.view_chats').on('click', function(){
        var clicked = $(this);
        $('#trgigger-chatioi').click();
        $.ajax({
            url: '../ajax.php',
            type: 'POST',
            data: {
                'type': 'getMessages-prev',
                'patient': clicked.attr('data-id'),
                'doctor': <?php echo $_COOKIE['userid']; ?>,
            },
            success: function(result) {
                var chat = JSON.parse(result);
                console.log(result);
                var flag;
                $.each( chat, function( key, value ) {
                    if( value.s_type == 'doctor' ) {
                        flag = 'chat-right';
                    } else {
                        flag = '';
                    }
                    $('#chat-content2').append('<div chat_id="'+value.id+'" class="chat ' + flag +'"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip"> <p>' + value.message + ' </p> </div> </div> </div>');
                });
            }
        });
    });
</script>

<?php } ?>

<?php include_once( '../footer.php') ?>