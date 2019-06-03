<?php include_once( '../header.php' ); ?>

<?php 
	
	$db = new Database();
	$flag = false;
	$message = '';

	if( isset( $_GET['id'] ) ) {
		$employe_id = $_GET['id'];
		$stmnt = 'select * from employee where employee_id = :id';
		$params = array(
				':id'	=>	$employe_id
			);
		$employe = $db->display($stmnt, $params);
		
?>
<style type="text/css">.message {width: 100%;}</style>
<!-- Page -->
  <div class="animsition page-profile">
  		<?php if( $employe ) : $employe = $employe[0]; ?>
      <div class="row">
        <div class="col-md-3">
          <!-- Page Widget -->
          <div class="widget widget-shadow text-center">
            <div class="widget-header">
              <div class="widget-header-content">
                <a class="avatar avatar-lg" href="javascript:void(0)">
                  <img src="../media/profile/<?php echo $employe['profile_pic']; ?>" alt="...">
                </a>
                <h4 class="profile-user"><?php echo ucfirst($employe['fname'] . ' ' . $employe['lname']); ?></h4>
                <p><?php echo $employe['mobile']; ?></p>
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
					                    <?php echo ucfirst($employe['fname'] . ' ' . $employe['lname']); ?>
					                </td>
					            </tr>
					            <tr>
					                <td class="text-left">
					                    Date of Birth
					                </td>
					                <td>
					                    <?php echo $employe['dob'];?>
					                </td>
					            </tr>
					            <tr>
					                <td class="text-left">
					                    Gender
					                </td>
					                <td>
					                    <?php echo $employe['sex'];?>
					                </td>
					            </tr>
					            <tr>
                            <td class="text-left">
                               Address
                            </td>
                            <td>
                                <?php echo $employe[ 'address_lane_1'] . ' ' .$employe[ 'address_lane_2'] ; ?>
                            </td>
                        </tr>
					            <tr>
					                <td class="text-left">
					                    Postal Code
					                </td>
					                <td>
					                    <?php echo $employe['pin'];?>
					                </td>
					            </tr>
					            <tr>
					                <td class="text-left">
					                    Country
					                </td>
					                <td>
					                    <?php echo $employe['country'];?>
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
  <?php else: echo '<div class="alert alert-info">No employees details show!</div>';endif; ?>
  </div>
        <div class="message">
            <?php if( $message ) echo $message; ?>
        </div>

<?php } // end if ?>
  <!-- End Page -->
<?php include_once( '../footer.php' ); ?>