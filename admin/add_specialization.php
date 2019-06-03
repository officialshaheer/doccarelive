<?php 
    include_once( '../header.php');

    $db = new Database();
    $message = null;

    if( isset( $_POST['create'] ) ) {
        $sql = 'select * from specialization where specialization = :specialization';
        $params = array(
                ':specialization' =>  $_POST['specialization']
            );
        if( !$db->display($sql, $params) ) {
            $stmnt = 'insert into specialization(specialization, description) values( :specialization, :description )';
            $params = array(
                    ':specialization' => $_POST['specialization'],
                    ':description'     => $_POST['description']
                );
            if( $db->execute_query( $stmnt, $params ) ) {
                $message = '<div class="alert alert-success" role="alert">Successfully Created!</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">Some error occured!</div>';
            }
        } else {
            $message = '<div class="alert alert-danger" role="alert">Sorry specialization name already exist!</div>';
        }
    }


?>
    

    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Add Specialization</h3>
        </div>
        <div class="panel-body">
                <form method="post" action="" autocomplete="off" data-parsley-validate="">
                    <div class="col-md-6">
                        <div class="form-group form-material floating">
                          <input type="text" class="form-control" name="specialization" data-parsley-required="true" />
                          <label class="floating-label">Specialization Name</label>
                        </div>
                        <div class="form-group form-material floating">
                          <textarea name="description" class="form-control" required=""></textarea>
                          <label class="floating-label">Description</label>
                        </div>
                        <div class="message.left">
                            <?php if( $message ) echo $message; ?>
                        </div>
                        <div class="form-group form-material floating">
                            <button type="submit" class="btn btn-primary" name="create">Add Specialization</button>
                        </div>
                    </div>
              </form>
        </div>
    </div>
        
</div>
</div>
<?php include_once( '../footer.php') ?>