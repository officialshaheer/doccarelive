<?php 
	include_once('../header.php');

	$db = new Database();
	$app_details = array();

	$stmnt = 'select * from appointment_definition where doctor_id = ' . $_COOKIE['userid'];
	$app_def = $db->display($stmnt);
	$info = '';

	if( isset($_POST['selected-def-sub'] ) ) {
		$date = date_format(new DateTime(), 'Y-m-d');
		$stmnt = 'select * from appointment LEFT JOIN patient ON appointment.patient_id = patient.patient_id where appointment.appdef_id = ' . $_POST['selected-def'] . ' and date = "' . $date . '" and prescription is null order by token_no';
		$app_details = $db->display($stmnt); 

		if( empty($app_details) ) {
			$info = "Sorry no appointments  today!";
		}
	}
?>
<button type="button" id="trgigger-app-model" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Open Modal</button>

<button type="button" id="trgigger-video-model" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false">Open Modal</button>

<button type="button" id="trgigger-prescription" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3" data-backdrop="static" data-keyboard="false">Open Modal</button>

<!-- Modal -->
<div id="myModal3" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Write Prescription</h4>
            </div>
            <div class="modal-body">
                <textarea id="p-editor" name="pres-text"></textarea>
                <div class="p-message">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="pres-submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Submit</button>
                <button type="submit" id="next-appointment"  onClick="location.reload();" class="btn btn-info waves-effect waves-light" style="float: right; display: none;">Next Appontment</button>
            </div>
        </div>

    </div>
</div>

<input type="hidden" id="pt-id" name="">
<input type="hidden" id="app-id" name="">

<div style="position: relative;height: 100%; width: 100%">
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title">Choose Appointment</h4>
            </div>
            <div class="modal-body">

                <?php if( $app_def ) : ?>
                <form action="" method="post">
                    <div class="form-group form-material floating">
                        <select class="form-control" name="selected-def" id="selected-def">
                            <?php foreach ($app_def as $value) { ?>
                            <option value="<?php echo $value['appdef_id']; ?>">
                                <?php echo $value[ 'app_name']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="no-info">
                        <?php echo $info; ?>
                    </div>
                    <button class="btn btn-primary align-right" name="selected-def-sub">Select</button>                    
                    <a class="btn btn-info" style="float: right;" href="../doctor/">Home</a>
                </form>
                <?php endif; ?>
                <div style="display: none;">
                    <label>Your ID:</label>
                    <br/>
                    <textarea id="yourId"></textarea>
                    <br/>
                    <label>Other ID:</label>
                    <br/>
                    <textarea id="otherId"></textarea>
                    <button id="connect">connect</button>
                    <br/>

                    <label>Enter Message:</label>
                    <br/>
                    <textarea id="yourMessage"></textarea>
                    <button id="send">send</button>
                    <pre id="messages"></pre>
                </div>
            </div>

        </div>
        <div class="modal-footer">

        </div>

    </div>
</div>
</div>

<!-- video model -->
<!-- Modal -->
<div id="myModal2" class="modal " role="dialog" style="margin-top: 50px;">
    <div class="modal-dialog" style="width: 90%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
            	<div class="video-wrapper">
	            	<div class="half">
	            		<div class="video-frame">
	            			<div class="connecting-loader">
	            				<img src="../assets/images/svg-loaders/puff.svg">
	            				<div class="connecting-message">
	            					
	            				</div>
	            			</div>
                            <button class="btn btn-primary" id="end-app">End Session</button>
	            			<div class="patient-video">
	            			</div>
	            			<div class="doc-video" id="doc-video">
	            				
	            			</div>

	            		</div>
	            	</div>
	            	<div class="half" id="chat-section">
	            		<div class="panel" style="box-shadow: none;display: block;margin-bottom: 200px;height: 300px;">

        <div class="panel-header">
          <div class="panel-title">
            <a class="pull-left" href="javascript:void(0)">
              <i class="icon md-chevron-left" aria-hidden="true"></i>
            </a>
            <div class="text-right" style="position: fixed;top: 0;right: 0px; margin-top: 20px; padding: 0 50px; background: #E2C577; color: #fff; z-index: 9999;">
                <b><span class="conv-name"></span></b>
            </div>
          </div>
        </div>
        <div class="panel-body" style="padding-bottom: 0;">
          <div class="chat-box" style="overflow-x: hidden;">
            <div class="chats" id="chat-content" style="padding-bottom: 0;">
              
              
            </div>
          </div>
        </div>
      </div>

        <div style="position: absolute;padding:0 20px;bottom: 25px; background: #fff; border-top: 1px solid #efefef; margin: 0; padding-top: 12px;">
            <div class="input-group form-material">
             <!--  <span class="input-group-btn">
                <a href="javascript: void(0)" class="btn btn-pure btn-default icon md-camera"></a>
              </span> -->
              <!-- <input class="form-control" id="chat-input" type="text" placeholder="Type message here ..."> -->
              <textarea id="f-editor"></textarea>
              <span class="input-group-btn">
                <buttn type="button" id="send-message-btn" class="btn btn-pure btn-default icon md-mail-send">
                  </button>
              </span>
            </div>
        </div>
	            	</div>
            	</div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
	.half {
		width: 49%;
		display: inline-block;
		min-height: 500px;
		max-height: 500px;
	}
	.half .panel {
		height: 100%;
		overflow-x: hidden;
	}
	.video-frame {
		position: relative;
		background: #2C3E50;
		min-height: 500px;
		width: 100%;
		text-align: center;
	}
	.video-frame img {
		width: 100px;
		margin-top: 30%;
		position: relative;
	}
	video {
		width: 100%;
    	height: 100%;
    	max-height: 100%;
	}
	.connecting-loader {
	    position: absolute;
	    height: 100%;
	    width: 100%;
	}
	.connecting-message {
		color: #fff;
	}
	.patient-video {
	    z-index: 999999;
	    position: absolute;
	}
    .doc-video {
        height: 150px;
        width: 150px;
        position: absolute;
        bottom: 17px;
        left: 0;
        z-index: 999999999;
    }
    #end-app {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
    }
    .p-message {
        margin-top: 20px;
    }
</style>

<audio id="connecting-tone" src="../assets/audio/tone.mp3" autostart="false" style="display: none;" ></audio>

<?php if($app_details) : ?>
<!-- Firends Sidebar -->
<div class="page-aside" id="video-section">
    <div class="page-aside-switch">
        <i class="icon md-chevron-left" aria-hidden="true"></i>
        <i class="icon md-chevron-right" aria-hidden="true"></i>
    </div>
    <div class="page-aside-inner">
        <!-- Search Panel -->
        <div class="search-friends panel" style="height: auto;">
            <div class="panel-heading">
                <div class="panel-actions">
                    <div class="input-search input-group-sm">
                        <button type="submit" class="input-search-btn">
                            <i class="icon md-search" aria-hidden="true"></i>
                        </button>
                        <input type="text" class="form-control" name="" placeholder="Search...">
                    </div>
                </div>
                <h3 class="panel-title">Friends</h3>
            </div>
        </div>
        <!-- End Search Panel -->
        <!-- Firends List -->
        <div class="app-location-list" data-plugin="pageAsideScroll">
            <div data-role="container">
                <div data-role="content">
                    <div class="list-group row">
                        <?php foreach ($app_details as $patient): ?>
                        <div class="list-group-item col-xlg-6 col-lg-12 friend-info x-item"  appp-id="<?php echo $patient['app_id']; ?>">
                            <div class="widget widget-shadow">
                                <textarea class="hidden">
                                    <?php echo $patient[ 'video_id']; ?>
                                </textarea>
                                <div class="widget-content text-center bg-white padding-20">
                                    <a href="javascript:void(0)" class="avatar margin-bottom-5" style="float: left;">
                                        <img class="img-responsive" src="../media/profile/<?php echo $patient['profile_pic']; ?>" alt="Adam_photo" />
                                    </a>
                                    <div class="friend-name" style="text-align: left;padding-left: 70px;">
                                        <?php echo ucfirst( $patient[ 'fname'] . ' ' .$patient[ 'lname'] ); ?>
                                    </div>
                                    <div class="friend-title margin-bottom-20 blue-grey-400" style="text-align: left;padding-left: 70px;">
                                        Hi~ I&#x27;m Adam.
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Firends List -->
    </div>
</div>
<!-- End Firends Sidebar -->
<div class="page-main">
    <div id="map">
        <?php foreach ($app_details as $patient): ?>
                <div class="patient-details" d-id="<?php echo $patient['patient_id']; ?>" style="display: none;" custom-app="<?php echo $patient['app_id']; ?>" >
                    <div class="page-invoice-table table-responsive" style="padding: 20px; margin-top: 30px;">
                        <table class="table table-hover text-right">
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        Full Name
                                    </td>
                                    <td>
                                        <?php echo ucfirst($patient['fname'] . $patient['lname']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        Date of Birth
                                    </td>
                                    <td>
                                        <?php echo $patient['dob'];; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        Gender
                                    </td>
                                    <td>
                                        <?php echo $patient['sex'];; ?>                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        Medical History
                                    </td>
                                    <td>
                                        <?php echo $patient['medical_history']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="p-item btn btn-primary" id="<?php echo $patient['patient_id']; ?>" appId="<?php echo $patient['app_id']; ?>">Connect
                        <span class="friend-name" style="display: none;"><?php echo ucfirst($patient['fname'] . $patient['lname']); ?></span>
                        </button>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- <div class="row" id="video-section">
			




		<?php if($app_details) : ?>
		<div class="col-md-4">
			<div class="panel panel-bordered">
		        <div class="panel-heading">
		            <h3 class="panel-title">Define Appointment</h3>
		        </div>
		        <div class="panel-body">
			        	<table class="table is-indent tablesaw">
				        	<tbody>
				        	<?php foreach ($app_details as $patient): ?>
					        	<tr class="panel-hover-tb p-item" id="<?php echo $patient['patient_id']; ?>">
			                        <td class="cell">
					        			<textarea class="hidden"><?php echo $patient['video_id']; ?></textarea>
			                            <a class="avatar" href="javascript:void(0)">
			                                <img class="img-responsive" src="../media/profile/<?php echo $patient['profile_pic']; ?>" alt="...">
			                            </a>
			                            <?php echo ucfirst( $patient['fname'] . ' ' .$patient['lname'] ); ?>
			                        </td>
			                    </tr>
				        <?php endforeach; ?>
			                </tbody>
				        </table>
		        </div>
		    </div>
		</div>
		<?php endif; ?>
		<div class="col-md-8">
			<div class="panel panel-bordered">
		        <div class="panel-heading">
		            <h3 class="panel-title">Define Appointment</h3>
		        </div>
		        <div class="panel-body">
		        </div>
		    </div>
		</div>

	</div> -->

    <!-- Modal dialog -->
<div class="modal fade" id="frmPrenotazione" tabindex="-1">
    <!-- CUTTED -->
    <div id="step1" class="modal-footer">
      <button type="button" class="glyphicon glyphicon-erase btn btn-default" id="btnDelete"> Delete</button>
    </div>
</div>

<!-- Modal confirm -->
<div class="modal" id="confirmModal" style="display: none; z-index: 999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="confirmMessage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmOk">Ok</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function(document, window, $) {
        'use strict';
        jQuery(function() {
            if (!$('.p-item').length) {
                jQuery('#trgigger-app-model').click();
            }
        });

		$('#f-editor').froalaEditor({

			toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'subscript', 'emoticons', 'insertImage'],
			height: 120,
			pasteAllowLocalImages: true,
            imageUploadURL: '../upload_image.php',
            imageUploadParams: {
                id: 'f-editor'
            }
		}); 
        $('#p-editor').froalaEditor({height: 150});

        var tone = document.getElementById("connecting-tone");
        if ($('#video-section').length) {

            navigator.webkitGetUserMedia({
                video: true,
                audio: true
            }, function(stream) {console.log(stream);
                var doc_video = document.createElement('video');
                $('#doc-video').html(doc_video);
                doc_video.srcObject = stream;

                var peer = new SimplePeer({
                    initiator: location.hash === '#init',
                    trickle: false,
                    stream: stream
                });

                peer.on('signal', function(data) {

                    document.getElementById('yourId').value = JSON.stringify(data);
                    var docVideoId = JSON.stringify(data);

                    $.ajax({
                        url: '../ajax.php',
                        type: 'POST',
                        data: {
                            'type': 'setVideoId',
                            'userType': $('body').attr('data-type'),
                            'id': $('body').attr('data-id'),
                            'videoId': JSON.stringify(data)
                        },
                        success: function(result) {
                            if ($('body').attr('data-type') == 'doctor') {
                                $('.p-item').on('click', function() {
                                    $('#patient-details').hide(); 

                                    console.log($(this).attr('appp-id'));

                                    $('div[custom-app="' + $(this).attr('appp-id') + '"]').show();

                                	jQuery('#trgigger-video-model').click();
                                	$('.connecting-message').html('Connecting...');
                                    $('.conv-name').html($(this).find('.friend-name').html());

                                    var videoId = $(this).find('textarea').val();
                                    var patientId = $(this).attr('id');
                                    $('#app-id').val($(this).attr('appId'));
                                    $('#pt-id').val(patientId);
                                    tone.play();

                                    $.ajax({
                                        url: '../ajax.php',
                                        type: 'POST',
                                        data: {
                                            'type': 'putVideo',
                                            'patientId': patientId,
                                            'appdefId': $('#selected-def').val()
                                        },
                                        success: function(result) {
                                            //console.log(result);
                                        }
                                    });
                                    chats();
                                });
                            }
                        }
                    });

                });

                document.getElementById('connect').addEventListener('click', function() {
                    var otherId = JSON.parse(document.getElementById('otherId').value);
                    peer.signal(otherId);
                })

                document.getElementById('send').addEventListener('click', function() {
                    var yourMessage = document.getElementById('yourMessage').value;
                    peer.send(yourMessage);
                })

                peer.on('data', function(data) {
                    document.getElementById('messages').textContent += data + '\n';
                })

                peer.on('stream', function(stream) {
                    var video = document.createElement('video');
                    //document.body.appendChild(video);
                    $('.patient-video').html(video);

                    video.srcObject = stream;
                    video.play();
                })

                peer.on("error", function(err) {
                    console.error(err);
                });
                callStatus(peer);

                $('#btnDelete').on('click', function(e,peer){
                    confirmDialog('You want to end this?', function(){
                        $('#trgigger-prescription').click();
                        tone.pause();
                        jQuery('#trgigger-video-model').click();
                    });
                });
                
                $('#end-app').on('click', function(peer){
                    $('#btnDelete').click();
                });

                function confirmDialog(message, onConfirm, peer){
                    var fClose = function(){
                        modal.modal("hide");
                    };
                    var modal = $("#confirmModal");
                    modal.modal("show");
                    $("#confirmMessage").empty().append(message);
                    $("#confirmOk").one('click', onConfirm);
                    $("#confirmOk").one('click', fClose);
                    $("#confirmCancel").one("click", fClose);
                }

            }, function(err) {
                console.log(err);
            })
        }

        function callStatus(peer) {
            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: {
                    'type': 'checkDocStatus',
                    'appdef_id': $('#selected-def').val()
                },
                success: function(result) {
                    if (result == 'false') {
                        setTimeout(callStatus(peer), 5000);
                    } else {
                        peer.signal(JSON.parse(result)[0].videoId);
	                    tone.pause();
                    }
                }
            })
        }

        $('#send-message-btn').click(function (e) {
			var message = $('#f-editor').val();
			if(message != '') {
				//$('#chat-content').append('<div class="chat chat-right"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip" title="8:35 am"> <p>' + $('#f-editor').froalaEditor('html.get')  +' </p> </div> </div> </div>');
				
				$("#chat-section .panel").animate({ scrollTop: $("#chat-section .panel")[0].scrollHeight}, 1000);
                $('#f-editor').froalaEditor('html.set','');

				$.ajax({
	                url: '../ajax.php',
	                type: 'POST',
	                data: {
	                    'type': 'insertMessage',
                        'user_type': 'doctor',
	                    'userid': $('#pt-id').val(),
	                    'message': message
	                },
	                success: function(result) {
	                    //alert(result);
	                }
	            });

			}
		});  

        var storiesInterval = 10 * 100;
        var con_flag = 0;
        var chats = function(){

            var chatId = [];
            $('#chat-content .chat').map(function(){
              chatId.push($(this).attr('chat_id'));
            });

            $.ajax({
                url: '../ajax.php',
                type: 'POST',
                data: {
                    'type': 'getMessages',
                    'doctor': $('body').attr('data-id'),
                    'patient': $('#pt-id').val(),
                    'chat_ids': JSON.stringify(chatId)
                },
                success: function(result) {
                    var chat = JSON.parse(result);
                    var flag;
                    $.each( chat, function( key, value ) {
                        if( value.s_type == 'doctor' ) {
                            flag = 'chat-right';
                        } else {
                            flag = '';
                        }
                        $('#chat-content').append('<div chat_id="'+value.id+'" class="chat ' + flag +'"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip" title="8:35 am"> <p>' + value.message + ' </p> </div> </div> </div>');
                    });
                    if( con_flag != $('.chat-content').length ) {
                        $("#chat-section .panel").animate({ scrollTop: $("#chat-section .panel")[0].scrollHeight}, 1000);
                    }
                    con_flag = $('.chat-content').length;

                    setTimeout(chats, storiesInterval);
                }
            });
        }

        $('#pres-submit').click(function(){
            if( $('#p-editor').val() != '' ) {
                $.ajax({
                    url:'../ajax.php',
                    type: 'POST',
                    data: { 
                        'type': 'writePres',
                        'app_id': $('#app-id').val(),
                        'pres': $('#p-editor').val()
                    },
                    success:function(result){
                        if( result == 'success' ) {
                            $('.p-message').html('<div class="alert alert-success alert-dismissible" role="alert">Appointment done!</div>');
                            $('#pres-submit').css('display', 'none');
                            $('#next-appointment').css('display', 'block');
                        } else {
                            $('.p-message').html('<div class="alert alert-danger alert-dismissible" role="alert">Some error occured!</div>');
                        }
                    }
                });
            }
        })

        $('.x-item').on('click', function() {
            $('.patient-details').hide(); 
            console.log($(this).attr('appp-id'));
            $('div[custom-app="' + $(this).attr('appp-id') + '"]').show();
        });

    })(document, window, jQuery);
</script>

<?php include_once( '../footer.php') ?>