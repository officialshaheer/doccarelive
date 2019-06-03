<?php 
	include_once( '../header.php');

	$db = new Database();
	$doctors = null;

  $sql = 'select * from specialization';
  $specialization = $db->display($sql);

  $sql = 'select * from doctors';
  $doctors = $db->display($sql);

	if( isset( $_GET['category'] ) ) {
    if( $_GET['category'] != 'none' ) {
  		$stmnt = 'select * from doctors where specialized = :specialized and fname LIKE CONCAT("%",:name)   and verified = true';
  		$params = array( 
  				':name'	=>	isset( $_GET['doctor'] ) ? $_GET['doctor'] : '',
  				':specialized'	=>	$_GET['category']
  			);
  		$doctors = $db->display($stmnt, $params);
    } else {
      if( isset( $_GET['doctor'] ) && !empty($_GET['doctor']) ) {
        $stmnt = 'select * from doctors where fname LIKE CONCAT("%",:name)  and verified = true';
        $params = array( 
            ':name' =>  isset( $_GET['doctor'] ) ? $_GET['doctor'] : '',
          );
        $doctors = $db->display($stmnt, $params);
      }
    }
	}

?>

<div class="panel panel-bordered">
	<div class="panel-heading">
		<h3 class="panel-title">Search Doctor</h3>
	</div>
    <div class="panel-body">
        <form action="" method="get">
        	<div class="col-md-5">
	            <div class="form-group">
                  <select class="form-control" name="category">
                  <option value="none">Select</option>
                  	<?php foreach ($specialization as $value) { ?>
                      <option value="<?php echo $value['specialization_id'];?>" <?php if( isset($_GET['category'] )) if( $_GET['category'] == $value['specialization_id']) echo ' selected'; ?>><?php echo $value['specialization']; ?> </option>;
                   <?php  } ?>
                  </select>
                </div>
        	</div>
        	<div class="col-md-5">
        		<div class="form-group">
                  <div class="input-search input-search-dark">
                    <i class="input-search-icon md-search" aria-hidden="true"></i>
                    <input type="text" class="form-control" name="doctor" placeholder="Search Doctor" style="border-radius: 0;" value="<?php echo isset( $_GET['doctor'] ) ? $_GET['doctor'] : ''; ?>">
                    <button type="button" name="submit" class="input-search-close icon md-close" aria-label="Close"></button>
                  </div>
                </div>
        	</div>
        	<div class="col-md-2">
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary">Search</button>
	            </div>
        	</div>
        </form>
    </div>
</div>
<?php if( $doctors ) : ?>
<div class="row page-profile">
<?php foreach ($doctors as $doctor) { ?>
	<div class="col-md-3">
          <!-- Page Widget -->
          <div class="widget widget-shadow text-center">
            <div class="widget-header">
              <div class="widget-header-content">
                <a class="avatar avatar-lg" href="javascript:void(0)">
                  <img src="../media/profile/<?php echo $doctor['profile_pic']; ?>" alt="...">
                </a>
                <h4 class="profile-user"><a href="appointment-shedule.php?id=<?php echo $doctor['doctor_id']; ?>"><?php echo ucfirst($doctor['fname'] . ' ' . $doctor['lname']); ?></h4></a>
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
<?php } ?>
</div>
<?php else: echo '<div class="alert alert-danger alert-dismissible" role="alert">Sorry no doctors found!</div>'; endif; ?>

<?php include_once( '../footer.php') ?>