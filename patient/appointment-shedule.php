<?php 
	include_once( '../header.php'); 
	$db = new Database(); 
	$doctors = array(); 
    $select_app = null;
    $chooseApp = '';

    if( isset( $_GET['chooseApp'] ) && isset( $_GET[ 'id'] ) ) {
        $chooseApp = $_GET['chooseApp'];
        if( $_GET['chooseApp'] != 'none' ) :
            $stmnt = 'select * from appointment_definition where doctor_id = :id and appdef_id = :appdef_id';
            $params = array(':appdef_id' => $_GET['chooseApp'], ':id' => $_GET['id']);
            $select_app = $db->display($stmnt, $params);
            if( $select_app ) {
                $select_app = $select_app[0];
            }
        endif;
    }

	if( isset( $_GET[ 'id'] ) ) { 
		$stmnt = 'select * from doctors where doctor_id = :id and verified = true'; 
		$params = array( ':id'=> $_GET['id'] ); 
		$doctor = $db->display($stmnt, $params); 
		if( $doctor ) {
			$doctor = $doctor[0];
			$stmnt = 'select * from appointment_definition where doctor_id = :id';
			$app_def = $db->display($stmnt, $params);
?>

<div class=" page-profile">
    <div class="col-md-3">
        <!-- Page Widget -->
        <div class="widget widget-shadow text-center">
            <div class="widget-header">
                <div class="widget-header-content">
                    <a class="avatar avatar-lg" href="javascript:void(0)">
              <img src="../media/profile/<?php echo $doctor['profile_pic']; ?>" alt="...">
            </a>
                    <h4 class="profile-user">
                        <a href="doctor_details.php?id=<?php echo $doctor['doctor_id']; ?>">
                            <?php echo ucfirst($doctor['fname'] . ' ' . $doctor['lname']); ?>
                        </a>
                    </h4>
                    <p>
                        
                    <?php 
                        $sql = 'select * from specialization where specialization_id = ' . $doctor['specialized']; 
                        $sp = $db->display($sql);
                        echo $sp[0]['specialization'];
                    ?>
                    </p>
                </div>
            </div>

        </div>
        <!-- End Page Widget -->
    </div>
    <div class="col-md-9 app-documents">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Choose Appointment</h3>
            </div>
            <div class="panel-body">
                <?php if( $app_def ) : ?>
                    <form name="app-sel-form" action="" method="GET">
                       <input type="hidden" name="id" value="<?php echo $_GET[ 'id']; ?>">
                	   <select class="form-control" name="chooseApp" id="choose-appointment-drop" onchange="this.form.submit()"> 
            			 <option value="none">Choose an Appointment</option>
	                	  <?php foreach ($app_def as $def): ?>
							 <option value="<?php echo $def['appdef_id']; ?>" <?php if( $chooseApp ==  $def['appdef_id'] ) echo 'selected'; ?>><?php echo $def['app_name'];?></option>
	                	  <?php endforeach; ?>
            		  </select >
                    </form>
                    <?php if( $select_app ) :  ?>
                	<ul id="app-details-list" class="col-md-10 grid-list-table">
	                    <li>
	                        <div class="ul-list">Start Time</div>
	                        <div class="ul-list d"><?php echo $select_app['start_time']; ?></div>
	                    </li>
	                    <li>
	                        <div class="ul-list">Number of Patients</div>
	                        <div class="ul-list d"><?php echo $select_app['patient_limit']; ?></div>
	                    </li>
	                    <li>
	                        <div class="ul-list">Fee</div>
	                        <div class="ul-list d"><?php echo $select_app['fees']; ?></div>
	                    </li>
	                    <li>
	                        <div class="ul-list">Notes/Requirements</div>
	                        <div class="ul-list d"><?php echo $select_app['note']; ?></div>
	                    </li>
	                    <li>
	                        <div class="ul-list" style="margin-top: 20px;">Choose Date</div>
	                        <div class="ul-list d">
	                        	<div class="form-group form-material floating">
	                                    <input type="text" id="app-date-picker" name="date" class="form-control"  data-parsley-required="true">
	                                    <label class="floating-label">Choose Date</label>
	                                </div>
	                        </div>
	                    </li>
	                    <li>
	                    	<div class="ul-list" style="margin-top: 20px;">Documents/Reports(if any)</div>
	                    	<div class="ul-list d" style="margin-bottom: 50px;">
	                    		<div class="form-group form-material floating">
                                    <input type="file" id="input-file-now" class="dropify" name="documents" data-plugin="dropify" data-default-file="" data-allowed-file-extensions="zip" />
                                    <label for="hospital" class="floating-label" style="text-align: left;">This document should be a zip that contains all documents.</label>
                                </div>
                            </div>
	                    </li>
	                </ul>
                    <?php elseif($select_app == 'empty'): echo '<div class="alert alert-danger alert-dismissible" role="alert">Sorry something went wrong!</div>'; endif; ?>
                <?php else:  echo '<div class="alert alert-danger alert-dismissible" role="alert">Sorry no appointments found!</div>'; endif; ?>
            </div>
	        <div class="app-messgae"></div>
            <div class="panel-footer text-right">
            	<?php if( $app_def && $select_app ) : ?>
                <button class="btn btn-primary" id="payment-model-gen" type="button">Generate</button>
            	<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paymentModelBox" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
        	<form id="card-form" autocomplete="off" data-parsley-validate="" method="post">
            <div class="modal-header">
                <button type="button" class="close" id="model-close-btn" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Card Details</h4>
            </div>
            <div class="modal-body row">
            	<div class="payable-price">
            		<h4>Total Payable : Rs. <span class="payable-price-label"><?php echo $select_app['fees']; ?></span> /-</h4>
            	</div>
            	<div class="col-md-3">
                	<input type="text" id="cardtextBox1" class="form-control" name="" data-parsley-required="true" placeholder="XXXX"  maxlength='4' minlength="4" data-parsley-maxlength="4" data-parsley-maxlength="4">
                </div>
                <div class="col-md-3">
                	<input type="text" id="cardtextBox2" class="form-control" name="" data-parsley-required="true"  placeholder="XXXX" minlength="4" maxlength="4">
                </div>
                <div class="col-md-3">
                	<input type="text" id="cardtextBox3" class="form-control" name="" data-parsley-required="true"  placeholder="XXXX" minlength="4" maxlength="4">
                </div>
                <div class="col-md-3">
                	<input type="text" id="cardtextBox4" class="form-control" name="" data-parsley-required="true" placeholder="XXXX" minlength="4" maxlength="4">
                </div>
            </div>
            <div class="custom-message">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="doPayPayment">Pay</button>
            </div></form>
        </div>
    </div>
</div>
<!-- End Modal -->
<style type="text/css">
	.modal-body input[type="text"] {
		text-align: center;
    	letter-spacing: 15px;
	}
	.payable-price {    
		display: block;
	    padding-left: 15px;
	    margin-bottom: 30px;
	    margin-top: -20px;
	    border-top: 1px solid #efefef;
	    padding-top: 20px;
	}
	.modal-footer {
		padding-top: 20px;
		margin-top: 20px;
	    border-top: 1px solid #efefef;
	}
	.custom-message {
		padding-left: 20px;
		font-size: 13px;
	}
	.custom-message .error {
		color: red;
	}
	.custom-message .success {
		color: green;
	}
	.app-messgae {    
		margin-top: -30px;
		padding: 0 40px;
	}
    #choose-appointment-drop {
        margin-bottom: 30px;
    }
</style>
<?php } } ?>
<script type="text/javascript">
    $('#choose-appointment-drop').change(function(){
       // alert();
        //app-details-list
    })
</script>
<?php include_once( '../footer.php'); ?>