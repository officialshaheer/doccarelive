<?php 

	include_once('includes/connection.php');
	$db = new Database();

	if( isset( $_POST['type'] ) ) {
		$type = $_POST['type'];

		switch ($type) {			
			case 'delete-image':
				$image = $_POST['image-id'];
				$sql = 'delete from documents where id = "' .  $image .'"';
				if( $db->execute_query($sql) ) echo 'success';
			break;

			case 'getAppDefDetails':
					$stment = 'select * from appointment_definition where appdef_id = :appdef_id';
					$params = array(
							':appdef_id' => $_POST['appId']
						);
					$details = $db->display($stment, $params);
					$details = $details[0];
					echo json_encode($details);
				break;

			case 'doPayment':
					// checking money in bank
					$stmnt = 'select * from card where card_no = :card_no and amount >= :amount';
					$params = array(
							':card_no'	=>	$_POST['card_no'],
							':amount'	=>	$_POST['amount']
						);
					$card = $db->display($stmnt, $params);
					if( $card ) {
						$card = $card[0];
						$date = new DateTime($_POST['selected_date']);
            			$date = date_format($date, 'Y-m-d');

						$to_day = new DateTime();
            			$to_day = date_format($to_day, 'Y-m-d');

            			// for token number
            			$stmnt = 'select * from appointment where appdef_id = :appdef_id and date = :date';
            			$params = array(
            					':appdef_id'	=>	$_POST['appdef_id'],
            					':date'			=>	$date
            				);
            			$prev_app = $db->display($stmnt, $params);
            			$token_no = 1;
            			if( $prev_app ) {
	            			foreach ($prev_app as $value) {
	            				$token_no++;
	            			}
	            		}

	            		// for limit and fee apponintment definition table
	            		$stment = 'select patient_limit,fees from appointment_definition where appdef_id = :appdef_id';
	            		$params = array(
	            				':appdef_id'	=>	$_POST['appdef_id']
	            			);
	            		$app_def = $db->display($stment, $params);
	            		$app_def = $app_def[0];
	            		$patient_limit = $app_def['patient_limit'];

	            		// calculating committion
	            		$fees = $app_def['fees'];
	            		$commission = (30 / 100) * $fees;

	            		// checking patient exceeded or not
	            		if( $patient_limit >= $token_no ) {

	            			// inseting appointment
							$stment = 'insert into appointment(appdef_id, patient_id, token_no, date, card_no) values(:appdef_id, :patient_id, :token_no, :date, :card_no)';
							$params = array(
								':appdef_id'	=>	$_POST['appdef_id'],
								':patient_id'	=>	$_COOKIE['userid'],
								':token_no'		=>	$token_no,
								':date'			=>	$date,
								':card_no'		=>	$card['card_no']
							);
							if( $db->execute_query($stment, $params) ) {

								// for commission
								$stmnt = 'insert into commission(app_id, commission, date) values(:app_id, :commission, :date)';
								$params = array(
										':app_id'	=>	$db->lastInsertId(),
										':commission'	=>	$commission,
										':date'		=>	$to_day
									);
								$db->execute_query($stmnt, $params);

								// card updation 
								$amount = $card['amount'] - $_POST['amount'];
								$stmnt = 'update card set amount = :amount where card_no = :card_no';
								$params = array(
										':card_no'	=>	$_POST['card_no'],
										':amount'	=>	$amount
									);
								if( $db->execute_query($stmnt, $params) ) {
									echo 'success';
								}
							}
						} else {
							echo 'exceeded';
						}
					} else {
						echo 'invalid';
					}
				break;

			case 'checkAppAvailable':

				$appdef_id = $_POST['appdef_id'];
				$sel_date = $_POST['selected_date'];

				$stmnt = 'select * from appointment_definition where appdef_id = :appdef_id';
				$params = array(
						':appdef_id' =>	$appdef_id
					);
				$app_def = $db->display($stmnt, $params);
				$app_def = $app_def[0];
				$patient_limit = $app_def['patient_limit'];

				$stmnt = 'select * from appointment where appdef_id = :appdef_id and date = :date';
				$params = array(':appdef_id' => $appdef_id, ':date' => $sel_date);
				$appointments = $db->display($stmnt, $params);

				$limit = 1;
    			if( $appointments ) {
        			foreach ($appointments as $value) {
        				if( $value['patient_id'] == $_COOKIE['userid'] ) {
        					echo 'already';
        					exit();
        				}
        				$limit++;
        			}
        		}

        		if( $patient_limit >= $limit ) {
        			echo 'available';
        		} else {
        			echo 'exceeded';
        		}

			break;

			case 'setVideoId':

				$userid = $_POST['id'];
				$table = $_POST['userType'] == 'doctor' ? 'doctors' : 'patient';
				$label = $_POST['userType'] == 'doctor' ? 'doctor_id' : 'patient_id';

				$stmnt = 'update ' . $table . ' set video_id = :video_id where ' . $label . '= :userid';
				$params = array(
						':video_id'	=>	$_POST['videoId'],
						':userid'	=>	$_POST['id']
					);
				$db->execute_query($stmnt, $params);
			break;
			case 'putVideo': 
					$patient_id = $_POST['patientId'];

					$stmnt = 'update appointment_definition set pv_id = :patient_id where appdef_id = :appdef_id';
					$params = array(
							':patient_id'	=>	$patient_id,
							':appdef_id'	=>	$_POST['appdefId']
						);
					$db->execute_query($stmnt, $params);
				break;

			case 'checkCallStatus':
					$patient_id = $_COOKIE['userid'];
					$stmnt = 'select doctors.video_id as doctor_video, appointment_definition.appdef_id from patient left join appointment_definition on appointment_definition.pv_id left join doctors on doctors.doctor_id where patient.patient_id = '. $patient_id . ' and appointment_definition.pv_id = patient.patient_id and active = true';
					$videCall = $db->display($stmnt);
					if( $videCall ) {
						echo json_encode($videCall);
					}
				break;

			case 'setPVideoID':

				$stmnt = 'update appointment_definition set videoId = :videoId where appdef_id = :appdefId and active = false';
				$params = array(
						':videoId'	=>	$_POST['videoId'],
						':appdefId'	=>	$_POST['appdefId']
					);
				$db->execute_query($stmnt, $params);
				break;

			case 'accptCallinfo':

				$stmnt = 'update appointment_definition set active = false where appdef_id = :appdefId';
				$params = array(
						':appdefId'	=>	$_POST['appdefId']
					);
				$db->execute_query($stmnt, $params);

				$sql = 'select * from appointment_definition as def inner join doctors as doc where def.appdef_id = :appdefId and def.doctor_id = doc.doctor_id';
				echo json_encode( $db->display($sql, $params) );

				break;

			case 'checkDocStatus':
				$stmnt = 'select * from appointment_definition where appdef_id = :appdef_id and pv_id IS NOT NULL and videoId is not null';
				$params = array(
						':appdef_id'	=>	$_POST['appdef_id']
					);
				$videoId = $db->display($stmnt, $params);
				if( $videoId ) {
					 echo json_encode($videoId);
				} else {
					echo 'false';
				}
			break;

			// message
			case 'insertMessage':
				$stmnt = 'insert into chats (sender, receiver, s_type, message) values(:sender, :receiver, :s_type, :message)';
				$params = array(
						':sender'	=>	$_COOKIE['userid'],
						':receiver'	=>	$_POST['userid'],
						':s_type'	=>	$_POST['user_type'],
						':message'	=>	$_POST['message']
					);
				$db->execute_query($stmnt, $params);

			break;
			case 'getMessages':
				$chat_ids = implode(json_decode($_POST['chat_ids'], true), '", "');
				//echo $chat_ids;
				$stmnt = 'SELECT * FROM chats WHERE (`sender`='.$_POST['patient'].' and receiver='.$_POST['doctor'].' and id not in ("'.$chat_ids.'") ) or (receiver ='.$_POST['patient'].' and sender = '.$_POST['doctor'].' and id not in ("'.$chat_ids.'"))   order by id ASC';
				echo json_encode($db->display($stmnt));
				break;
			case 'writePres':
				$stmnt = 'update appointment set prescription = :pres where app_id = :app_id';
				$params = array(':pres'	=>	$_POST['pres'], ':app_id' => $_POST['app_id']);
				if( $db->execute_query($stmnt, $params)) {
					echo 'success';
				}
			break;
			case 'getMessages-prev':
				$stmnt = 'SELECT * FROM chats WHERE (`sender`='.$_POST['patient'].' and receiver='.$_POST['doctor'].') or (receiver ='.$_POST['patient'].' and sender = '.$_POST['doctor'].') order by id ASC';
				echo json_encode($db->display($stmnt));
			break;
			case 'getcurrentappid': 
				$date = new DateTime();
    			$date = date_format($date, 'Y-m-d');
				$stmnt = 'select prescription from appointment where appdef_id = :appdef_id and date = :date and patient_id = :patient_id';
				$params = array(
						':appdef_id' => $_POST['appdefId'],
						':date'	=>	$date,
						':patient_id'	=>	$_COOKIE['userid']
					);
				$app = $db->display($stmnt, $params);
				$app = $app[0];
				echo json_encode(array($app['prescription']));
			break;
			default:
				# code...
				break;
		}
	}

	// http://www.mytechblog.in/wp-content/uploads/2015/09/Commands-Procedure.txt

?>