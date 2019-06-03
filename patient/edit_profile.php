<?php include_once('../header.php'); 
    include_once('../includes/class.fileuploader.php');?>

<?php 
	$message = '';
	$db = new Database();
	if( isset( $_POST['update'] ) ) {
        $sql = 'update patient set fname=:fname, lname=:lname, mobile=:mobile, address_lane_1=:addresslane1, address_lane_2=:addresslane2, city=:city, pin=:pin where patient_id = ' . $_COOKIE['userid'];
        $params = array(
                ':fname'    =>  $_POST['fname'],
                ':lname'    =>  $_POST['lname'],
                ':mobile'   =>  $_POST['mobile'],
                ':addresslane1'  =>  $_POST['addresslane1'],
                ':addresslane2'  => $_POST['addresslane2'],
                ':city'     =>  $_POST['city'],
                ':pin'      =>  $_POST['pin'],
            );
        if( $db->execute_query($sql, $params) ) {
            $message = '<div class="alert alert-success" role="alert">Profile updated</div>';
            //if( isset( $_POST['files'] ) ) {
                $FileUploader = new FileUploader('files', array(
                    
                ));
                // call to upload the files
                $upload = $FileUploader->upload();
                
                if($upload['isSuccess']) {
                    // get the uploaded files
                    $files = $upload['files'];

                    foreach ($files as $key => $file) {
                        $name = $file['name'];

                        $stmnt = 'insert into documents (url, patient_id) values(:url, :patient_id)';
                        $params = array(
                                ':url'  =>  $name,
                                ':patient_id'  =>  $_COOKIE['userid']
                            );
                        $db->execute_query($stmnt, $params);
                    }
                }
                if($upload['hasWarnings']) {
                    // get the warnings
                    $warnings = $upload['warnings'];
                };
            //}
        }
    }
    $sql = 'select * from patient where patient_id = ' . $_COOKIE['userid'];
    $patient = $db->display($sql);
    $patient = $patient[0];

    $stmnt  = 'select * from documents where patient_id=:patient_id';
    $params = array(
        ':patient_id' => $patient['patient_id']
    );
    $docs = $db->display($stmnt, $params);
 ?>

    <div class="panel panel-bordered">
    	<div class="panel-heading">
            <h3 class="panel-title">Profile Updation</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="#" autocomplete="off" data-parsley-validate=""  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $patient['fname'] ?>" name="fname" data-parsley-required="true" data-parsley-pattern="^[a-zA-Z ]*$" required="" />
                            <label class="floating-label">First Name</label>
                        </div>
                        <div class="form-group form-material floating">
                            <textarea class="form-control" name="addresslane1" data-parsley-required="true"><?php echo $patient['address_lane_1']; ?></textarea>
                            <label for="mobile" class="floating-label">Address lane 1</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $patient['city'] ?>" name="city"  data-parsley-required="true" />
                            <label for="mobile" class="floating-label">City</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="number" class="form-control" value="<?php echo $patient['pin'] ?>" name="pin"  data-parsley-required="true" data-parsley-pattern="^[1-9][0-9]{5}$"  minlength="6" maxlength="6"  />
                            <label for="mobile" class="floating-label">Postal Code</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" value="<?php echo $patient['lname'] ?>" name="lname"  data-parsley-required="true" data-parsley-pattern="^[a-zA-Z ]*$" required="" />
                            <label class="floating-label">Last Name</label>
                        </div>

                        <div class="form-group form-material floating">
                            <textarea class="form-control" name="addresslane2" data-parsley-required="true"><?php echo $patient['address_lane_2']; ?></textarea>
                            <label for="mobile" class="floating-label">Address lane 2</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" data-parsley-pattern="^[789]\d{9}$" value="<?php echo $patient['mobile'] ?>" name="mobile"  data-parsley-required="true" />
                            <label for="mobile" class="floating-label">Mobile Phone</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                            <input type="file" name="files">
                            <label for="hospital" class="floating-label" style="text-align: left;">This document should in jpeg files(identity proof, certificates etc).</label>
                            <?php
                            foreach ($docs as $image) { ?> 
                              <div class="uploaded-image" style="background:url('../uploads/<?php
                                echo $image['url'];
                            ?>') center center;"> 
                                <div class="actions-holder"> 
                                  <i class="icon-trash glyph-icon" img-id="<?php echo $image['id'];?>">X</i> 
                                </div> 
                              </div> 
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="submit-button-cls" style="margin: 0">
                    <button  type="submit" name="update" class="btn btn-primary btn-block margin-top-10">Update</button>
                </div>
                <div class="message" style="text-align: left;">
                    <?php if( $message ) echo $message; ?>
                </div>
                
            </form>
        </div>
    </div>
    <script type="text/javascript">
      $('.uploaded-image i').click(function(){
        var image_id = $(this).attr('img-id');
        $.ajax({
          method: 'post',
          url: '../ajax.php',
          data:{
            'type': 'delete-image',
            'image-id': image_id
          },
          success:function(result){
            if( result == 'success' ) {
              $('.uploaded-image').each(function() {
                  if( $(this).find('i').attr('img-id') == image_id ) {
                    $(this).remove();
                  }
              });
            }
          }
        });
      });
      $('input[name="files"]').fileuploader({extension:['jpg','jpeg','png']});
    </script>
    <style type="text/css">
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
<?php include_once('../footer.php'); ?>