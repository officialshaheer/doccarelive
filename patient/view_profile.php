<?php 
    include_once( '../header.php'); 
    $db=new Database(); 
    $sql='select * from patient where patient_id = ' .$_COOKIE['userid'] ; 
    $patient=$db->display($sql); 
    if( $patient ) { $patient = $patient[0];

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Profile</h3>

            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                Full Name
                            </td>
                            <td>
                                <?php echo ucfirst($patient['fname'] . ' ' . $patient['lname']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Date of Birth
                            </td>
                            <td>
                                <?php echo $patient['dob'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Gender
                            </td>
                            <td>
                                <?php echo $patient['sex']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Mobile
                            </td>
                            <td>
                                <?php echo $patient['mobile']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Address
                            </td>
                            <td>
                                <?php echo $patient[ 'address_lane_1'] . ' ' .$patient[ 'address_lane_2'] ; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                City
                            </td>
                            <td>
                                <?php echo $patient['city']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                pin
                            </td>
                            <td>
                                <?php echo $patient['pin']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Country
                            </td>
                            <td>
                                <?php echo $patient['country']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                Medical History
                            </td>
                            <td>
                            <?php
                                $stmnt  = 'select * from documents where patient_id=:patient_id';
                                $params = array(
                                    ':patient_id' => $patient['patient_id']
                                );
                                $images = $db->display($stmnt, $params);
                                foreach ($images as $image) { ?> 
                                  <a class="inline-block image-link" href="../uploads/<?php echo $image['url']; ?>" data-plugin="magnificPopup">
                                    <img class="img-responsive" src="../uploads/<?php echo $image['url']; ?>" alt="..." width="220">
                                  </a>
                            <?php } ?>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <?php } else { echo '<div class="alert alert-danger">No Employee found</div>';} ?>
</div>
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