<?php include_once('../header.php') ?>



<input type="hidden" id="pt-id" name="">
<input type="hidden" id="app-id" name="">


<button type="button" id="trgigger-prescription" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal4" data-backdrop="static" data-keyboard="false">Open Modal</button>

<!-- Modal -->
<div id="myModal4" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Prescription</h4>
            </div>
            <div class="modal-body">
            	<div class="prescription-content">
            		
            	</div>
            </div>
            <a class="btn btn-info" style="float: right;" href="../patient/">Home</a>
        </div>

    </div>
</div>

<button type="button" id="trgigger-video" style="display: none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3" data-backdrop="static" data-keyboard="false">Open Modal</button>
	<div class="row" id="video-section">

		        	<!-- Modal content-->
<div id="myModal3" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
<div class="modal-dialog"  style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="video-wrapper">
                    <div class="half">
                        <div class="video-frame">
                            <div class="connecting-loader">
                                <img src="../assets/images/svg-loaders/puff.svg">
                                <div class="connecting-message"></div>
                            </div>
                            <div class="doc-video"></div>
                            <div class="pat-video" id="pat-video"></div>
                        </div>
                    </div>
                    <div class="half" id="chat-section">
                        <div class="panel" style="box-shadow: none;display: block;margin-bottom: 200px;height: 300px;">
                            <div class="panel-header">
                                <div class="panel-title">
                                    <a class="pull-left" href="javascript:void(0)"><i aria-hidden="true" class="icon md-chevron-left"></i></a>
                                    <div class="text-right" style="position: fixed;top: 0;right: 0px; margin-top: 20px; padding: 0 50px; background: #E2C577; color: #fff; z-index: 9999;">
                                        Dr. <b><span class="conv-name"></span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="padding-bottom: 0;">
                                <div class="chat-box" style="overflow-x: hidden;">
                                    <div class="chats" id="chat-content" style="padding-bottom: 0;"></div>
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



		        	<div class="hidden">
			        	<label>Your ID:</label><br/>
					    <textarea id="yourId"></textarea><br/>
					    <label>Other ID:</label><br/>
					    <textarea id="otherId"></textarea>
					    <button id="connect1">connect</button><br/>

					    <button id="connect">connect</button><br/>
					    <label>Enter Message:</label><br/>
					    <textarea id="yourMessage"></textarea>
					    <button id="send">send</button>
					    <pre id="messages"></pre>
	        		</div>
	        		<div class="videoFrame">
	        			
	        		</div>
</div></div>
	</div>

		<div id="calling-info" class="btn btn-primary">
			Answer the call
		</div>
	<style type="text/css">
		#calling-info {
			display: none;    
			position: fixed;
			right: 20px;
			top: 90px;
			z-index: 99999999;
		}
	</style>

	<script type="text/javascript">
		jQuery(function() {
			
		});
    	if( $('body').attr('data-type') == 'patient' ) {
    		videoCall();
    	};

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

    	function videoCall() {
    		$.ajax({
    			url: '../ajax.php',
    			type:'POST',
    			data:{
    				'type': 'checkCallStatus',
    			},
    			success: function(result){ 
    				if ( result) {
    					var appdef_id = $.parseJSON(result)[0][1];
    					var videCall = $.parseJSON(result)[0];

    					$('#calling-info').show();

	    				navigator.webkitGetUserMedia({
				    		video: true,
				    		audio: true
				    	},function(stream) {


			                var pat_video = document.createElement('video');
			                $('#pat-video').html(pat_video);
			                pat_video.srcObject = stream;

				    		var peer = new SimplePeer({
					    		initiator: location.hash === '#init',
					    		trickle: false,
					    		stream: stream
					    	});
					    	peer.on('signal', function(data){
								document.getElementById('yourId').value = JSON.stringify(data);
		    					//var docVideoId = JSON.stringify(data);
		    					$.ajax({
					    			url: '../ajax.php',
					    			type:'POST',
					    			data:{
					    				'type': 'setPVideoID',
					    				'videoId': JSON.stringify(data),
	    								'appdefId': appdef_id
					    			},
					    			success: function(result){
					    				chats();
					    			}
					    		});
					    	});

					    	$('#calling-info').on('click', function(){
					    		var otherId = videCall.doctor_video;
					    		peer.signal(otherId);
					    		$('#calling-info').hide();
					    		
					    		$.ajax({
					    			url: '../ajax.php',
					    			type: 'POST',
					    			data: {
					    				'type': 'accptCallinfo',
	    								'appdefId': appdef_id
					    			},
					    			success: function(result){
					    				$('#pt-id').val(JSON.parse(result)[0].doctor_id);
					    				$('#trgigger-video').click();
					    				$('.conv-name').html(JSON.parse(result)[0].fname + ' ' + JSON.parse(result)[0].lname);
										check_complete(appdef_id);
					    			}
					    		});
					    	})

					    	peer.on('stream', function(stream){
					    		var video = document.createElement('video');
					    		$('.doc-video').html(video);

					    		video.srcObject = stream;
					    		video.play();
					    	})

					    	peer.on('close', function () {

					    	});

					    },function(err) {
					    	console.log(err);
					    });
	    			} else {
	    				$('#calling-info').hide();
	    			}
	    			setTimeout(videoCall, 5000);
    			}
    		});
    	};

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
                        'user_type': 'patient',
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
                        if( value.s_type == 'patient' ) {
                            flag = 'chat-right';
                        } else {
                            flag = '';
                        }
                        $('#chat-content').append('<div chat_id="'+value.id+'" class="chat ' + flag +'"> <div class="chat-body"> <div class="chat-content" data-toggle="tooltip"> <p>' + value.message + ' </p> </div> </div> </div>');
                    });
                    if( con_flag != $('.chat-content').length ) {
                    	$("#chat-section .panel").animate({ scrollTop: $("#chat-section .panel")[0].scrollHeight}, 1000);
                	}
                    con_flag = $('.chat-content').length;

                    setTimeout(chats, storiesInterval);
                }
            });
        }

        var check_complete = function(appdef_id) {
        	var appdef_id = appdef_id;
        	//console.log(appdef_id);
            $.ajax({
				url: '../ajax.php',
				type: 'POST',
				data: {
					'type': 'getcurrentappid',
					'appdefId': appdef_id
				},
				success: function(result){ console.log(result);
                	if( result != '[null]' ) {
						console.log('asd- ' + result);
						$('#video-section').remove();
						$('#trgigger-prescription').click();
						$('.prescription-content').html(JSON.parse(result));
                	} else {
                		setTimeout(check_complete.bind(null, appdef_id), storiesInterval);
                	}
				}
			});
        }

	</script>

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
	.doc-video {
	    z-index: 999999;
	    position: absolute;
	}
    .pat-video {
        height: 150px;
        width: 150px;
        position: absolute;
        bottom: 0;
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
	
<?php include_once('../footer.php') ?>