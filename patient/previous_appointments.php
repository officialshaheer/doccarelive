<?php include_once( '../header.php' ); ?>

<?php 
    
    $db = new Database();
    $appointments = null;

    $sql = 'select * from appointment where `date` <= CURDATE() and patient_id = ' . $_COOKIE['userid'] . ' order by date desc';
    $dates = $db->display($sql); 

    $sql = 'select * from appointment as ap inner join appointment_definition as ad where ap.patient_id = "' . $_COOKIE['userid'] . '" and ap.appdef_id = ad.appdef_id and `date` < CURDATE() order by date desc';
    $appointments = $db->display($sql);

    if( isset( $_POST['date'] ) ) {

        $sql = 'select * from appointment as ap inner join appointment_definition as ad where ap.patient_id = "' . $_COOKIE['userid'] . '" and ap.appdef_id = ad.appdef_id and `date` = "' . $_POST['date'] . '" order by date desc';
        $appointments = $db->display($sql);
    }
?>

<style type="text/css">
    .panel-hover-tb:hover {
        background: #efefef;
        cursor: pointer;
        border-bottom: 1px solid #e0e0e0;
    }
    .panel-hover-tb a {
        text-decoration: none;
    }
</style>
    <button type="button" id="trgigger-chatioi" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalioi" >Open Modal</button>

    <div id="myModalioi" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;min-height: 500px;max-height: 500px;overflow-y: hidden;">
        <div class="modal-dialog"  style="width: 50%;">
                <div class="panel-body" style="padding-bottom: 0;">
                    <div class="chat-box" style="overflow-x: hidden;overflow-y: scroll;max-height: 500px;">
                        <div class="chats" id="chat-content2" style="padding-bottom: 0;overflow-y: scroll;"></div>
                    </div>
                </div>
        </div>
    </div>


    <div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Previous Appointments</h3>
        </div>
        <div class="panel-body">
            <?php if( $dates ) : ?>
                <form method="post" action="">
                    <div class="form-group form-material floating">
                        <label class="control-label" for="country">Select date</label>
                        <select  class="form-control" name="date" onchange="this.form.submit();">
                            <option>Select</option>
                            <?php foreach ($dates as $date): ?>
                                <option value="<?php echo $date['date']; ?>" <?php if( isset( $_POST['date'] ) ) if( $_POST['date'] == $date['date'] ) echo ' selected'; ?>><?php echo $date['date']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </form>
            <?php else: ?>
                <!-- <div class="alert alert-info">No Appointments</div> -->
            <?php endif; ?>
            <?php if($appointments): ?>
            <table class="table is-indent tablesaw">
                <thead>
                    <tr>
                        <th class="cell-30" scope="col">
                        </th>
                        <th class="cell-300" scope="col">Appointment Name</th>
                        <th class="cell-300" scope="col">Appontment Date/Time</th>
                        <th scope="cell-300">Doctor</th>
                        <th scope="col">Token Number</th>
                        <th scope="col">Prescription</th>
                        <th scope="col">Conversations</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appointment) { ?>
                    <tr class="panel-hover-tb">
                        <td class="cell-30">
                        </td>
                        <td class="cell-300">
                            <?php echo ucfirst( $appointment['app_name'] ); ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['date']; ?> / 
                            <?php echo $appointment['start_time']; ?>
                        </td>
                        <td>
                            <?php 
                                $sql = 'select * from doctors where doctor_id = ' . $appointment['doctor_id'];
                                if( $doctor = $db->display($sql) ) $doctor = $doctor[0];
                             ?>
                            <?php echo ucfirst( $doctor['fname'] . $doctor['lname'] ); ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['token_no']; ?>
                        </td>
                        <td class="cell-300">
                            <?php echo $appointment['prescription']; ?>
                        </td>
                        <td class="cell-300">
                            <button class="view_chats btn btn-success" data-id="<?php echo $appointment['doctor_id'] ?>">View full conversation</button>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        <?php elseif(!$appointments && $_POST): echo'<div class="alert alert-info">No Appointments</div>'; endif; ?>
        </div>
    </div>
    </div>

<script type="text/javascript">
    $('.view_chats').on('click', function(){
        var clicked = $(this);
        $('#trgigger-chatioi').click();
        $.ajax({
            url: '../ajax.php',
            type: 'POST',
            data: {
                'type': 'getMessages-prev',
                'doctor': clicked.attr('data-id'),
                'patient': <?php echo $_COOKIE['userid']; ?>,
            },
            success: function(result) {
                var chat = JSON.parse(result);
                console.log(result);
                var flag;
                $.each( chat, function( key, value ) {
                    if( value.s_type == 'patient' ) {
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

<?php include_once( '../footer.php' ); ?>