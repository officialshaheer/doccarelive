<?php include_once( '../header.php' ); ?>

<?php 
	
	$db = new Database();
	$flag = false;
	$message = '';

	if (isset($_POST['approve'])) {
		$sql = 'update doctors set verified = true, remarks = null where doctor_id = "' . $_POST['doc-id'] . '"';
		$db->execute_query($sql);
		$message = '<div class="alert alert-success" role="alert">Successfully Approved!</div>';
	}
	if (isset($_POST['reject'])) {
		$sql = 'update doctors set remarks = "' . $_POST['reject-reason'] . '" where doctor_id = "' . $_POST['doc-id'] . '"';
		$db->execute_query($sql);
		$message = '<div class="alert alert-danger" role="alert">Doctor has been rejected!</div>';
	}

	if( isset( $_GET['id'] ) ) {
		$doctor_id = $_GET['id'];
		$stmnt = 'select * from doctors where doctor_id = :id';
		$params = array(
				':id'	=>	$doctor_id
			);
		$doctor = $db->display($stmnt, $params);
?>

<?php
$zip = zip_open("../media/uploads/doctor/a.zip");
$za = new ZipArchive(); 

$za->open('../media/uploads/doctor/a.zip'); 

for( $i = 0; $i < $za->numFiles; $i++ ){ 
    $stat = $za->statIndex( $i ); 
    print_r( basename( $stat['name'] ) . PHP_EOL ); 
    //echo '<img src="' . basename( $stat['name'] ) . '">';
} ?>
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
                <p class="profile-job"><?php echo $doctor['specialized']; ?></p>
                
              </div>
            <?php if( $doctor['verified'] == false ) : ?>
              <form action="" method="POST"> 
              	<input type="hidden" name="doc-id" value="<?php echo $doctor['doctor_id']; ?>">
				<button type="button" id="trgigger-prescription" class="btn btn-danger btn-block margin-top-10" data-toggle="modal" data-target="#myModal1" data-backdrop="static" data-keyboard="false">Reject</button>
              	<button  type="submit" name="approve" class="btn btn-primary btn-block margin-top-10">Approve</button>
              </form>
        	<?php endif; ?>
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
                <li role="presentation"><a data-toggle="tab" href="profile.html#documents" aria-controls="profile" role="tab">Documents</a></li>
                
              </ul>

              <div class="tab-content">
                <div class="tab-pane active animation-slide-left" id="profile" role="tabpanel">
                	<div class="page-invoice-table table-responsive" style="padding: 20px; margin-top: 30px;">
					    <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                Username
                            </td>
                            <td>
                                <?php echo $doctor['username'];?>
                            </td>
                        </tr>
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
                                Date of Birth
                            </td>
                            <td>
                                <?php echo $doctor['dob'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Gender
                            </td>
                            <td>
                                <?php echo $doctor['sex']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Specialization
                            </td>
                            <td>
                                <?php 
                                $sql = 'select * from specialization where specialization_id = ' . $doctor['specialized'];
                                $spec = $db->display($sql);
                                print_r($spec[0]['specialization']);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Mobile
                            </td>
                            <td>
                                <?php echo $doctor['mobile']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Address
                            </td>
                            <td>
                                <?php echo $doctor[ 'address_lane_1'] . ' ' .$doctor[ 'address_lane_2'] ; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                City
                            </td>
                            <td>
                                <?php echo $doctor['city']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                pin
                            </td>
                            <td>
                                <?php echo $doctor['pin']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Country
                            </td>
                            <td>
                                <?php echo $doctor['country']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                About
                            </td>
                            <td>
                                <?php echo $doctor['about']; ?>
                            </td>
                        </tr>
                        
                        
                    </tbody>
                </table>
					</div>
                </div>
                <div class="tab-pane animation-slide-left" id="documents" role="tabpanel" style="padding: 30px;">
                	<?php
                      $stmnt  = 'select * from documents where doctor_id=:doctor_id';
                      $params = array(
                          ':doctor_id' => $doctor['doctor_id']
                      );
                      $images = $db->display($stmnt, $params);
                      foreach ($images as $image) { ?> 
                        <a class="inline-block image-link" href="../uploads/<?php echo $image['url']; ?>" data-plugin="magnificPopup">
                          <img class="img-responsive" src="../uploads/<?php echo $image['url']; ?>" alt="..." width="220">
                        </a>
                  <?php } ?>
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
                <h4 class="modal-title">Reject Reason</h4>
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
<style type="text/css">
    .image-link img {
        max-height: 100px;
        max-width: 100px;
        float: left;
    }
      .uploaded-image {
        height: 100px;
        width: 100px;
        display: inline-block;
        margin-right: 10px;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover !important;
        position: relative;
    }
    .uploaded-image:hover .actions-holder {
      display: block;
    }
    .actions-holder {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: none;
      border-radius: 4px;
      background: rgba(33, 33, 33, 0.55);
      text-align: right;
      -webkit-transition: opacity 0.2s ease;
      transition: opacity 0.2s ease;
      z-index: 3;
    }
    .actions-holder i {
      position: absolute;
      color: #fff;
      cursor: pointer;
      font-size: 15px;
      z-index: 99;
      right: 10px;
      top: 10px;
    }
    </style>
    <script type="text/javascript">
        $('.image-link').magnificPopup({type:'image'});
    </script>
<?php include_once( '../footer.php'); ?>