<?php include_once( '../header.php' ); ?>

<?php 
	
	$db = new Database();
	$flag = false;
	$message = '';

	if( isset( $_GET['id'] ) ) {
		$doctor_id = $_GET['id'];
		$stmnt = 'select * from doctors where doctor_id = :id';
		$params = array(
				':id'	=>	$doctor_id
			);
		$doctor = $db->display($stmnt, $params);
?>
<style type="text/css">.message {width: 100%;}</style>
<!-- Page -->
  <div class="animsition page-profile">
  	<?php if( $doctor ) : $doctor = $doctor[0]; ?>
      <div class="row">
        <div class="col-md-3">
          <!-- Page Widget -->
          <div class="widget widget-shadow text-center">
            <div class="widget-header">
              <div class="widget-header-content">
                <a class="avatar avatar-lg" href="javascript:void(0)">
                  <img src="../media/profile/<?php echo $doctor['profile_pic']; ?>" alt="...">
                </a>
                <h4 class="profile-user"><?php echo ucfirst($doctor['fname'] . ' ' . $doctor['lname']); ?></h4>
                <p class="profile-job">
                	<?php 
                		$sql = 'select * from specialization where specialization_id = ' . $doctor['specialized']; 
                		$sp = $db->display($sql);
                		echo $sp[0]['specialization'];
                	?>
                </p>
                <p><?php echo $doctor['about']; ?></p>
              </div>
            </div>
            
          </div>
          <!-- End Page Widget -->
        </div>

        <div class="col-md-9">
          <!-- Panel -->
          <div class="panel">
            <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
              <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a data-toggle="tab" href="profile.html#profile" aria-controls="profile"
                  role="tab">Profile</a></li>
                
              </ul>

              <div class="tab-content">
                <div class="tab-pane active animation-slide-left" id="profile" role="tabpanel">
                	<div class="page-invoice-table table-responsive" style="padding: 20px; margin-top: 30px;">
					    <table class="table table-hover text-right">
					        <tbody>
					            <tr>
					                <td class="text-left">
					                    Full Name
					                </td>
					                <td>
					                    <?php echo ucfirst($doctor['fname'] . ' ' . $doctor['lname']); ?>
					                </td>
					            </tr>
					            <tr>
					                <td class="text-left">
					                    Gender
					                </td>
					                <td>
					                    <?php echo $doctor['sex'];?>
					                </td>
					            </tr>
					            <tr>
					                <td class="text-left">
					                    Specialized
					                </td>
					                <td>
					                    <?php echo $doctor['specialized']; ?>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					</div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Panel -->
        </div>
      </div>
        <?php else: echo '<div class="alert alert-info">No doctor details show!</div>';endif; ?>
  </div>
        <div class="message">
            <?php if( $message ) echo $message; ?>
        </div>



<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog" style="margin-top: 50px;z-index: 999999999;">
    <div class="modal-dialog">
        <!-- Modal content-->
                <form method="POST" action="" data-parsley-validate="">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rejct Reason</h4>
            </div>
            <div class="modal-body">
                <textarea id="p-editor" required="" name="reject-reason" class="form-control" placeholder="Enter reject reason"></textarea>
            </div>
            <div class="modal-footer">
              		<input type="hidden" name="doc-id" value="<?php echo $doctor['doctor_id']; ?>">
                    <button type="submit" name="reject" class="btn btn-info waves-effect waves-light">Submit</button>
            </div>
        </div>
        </form>

    </div>
</div>
<?php } // end if ?>
  <!-- End Page -->
<?php include_once( '../footer.php' ); ?>