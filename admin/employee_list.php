<?php include_once( '../header.php' ); ?>

<?php 
    
    $db = new Database();
    $sql = 'select * from employee';
    $employees = $db->display($sql);
?>

<style type="text/css">
    .panel-hover-tb:hover {
        background: #efefef;
        cursor: pointer;
        border-bottom: 1px solid #e0e0e0;
    }
    .panel-hover-tb a {
        text-decoration: none;
    }
</style>

    <div class="panel panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Empoyees</h3>
        </div>
        <div class="panel-body">
            <!-- Contacts -->
            <?php if($employees): ?>
            <table class="table is-indent tablesaw">
                <thead>
                    <tr>
                        <th class="cell-30" scope="col">
                        </th>
                        <th class="cell-300" scope="col">Name</th>
                        <th class="cell-300" scope="col">Phone</th>
                        <th scope="cell-300">City</th>
                        <th scope="col">View</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employe) { ?>
                    <tr class="panel-hover-tb">
                        <td class="cell-30">
                        </td>
                        <td class="cell-300">
                            <a class="avatar" href="javascript:void(0)">
                                <img class="img-responsive" src="../media/profile/<?php echo $employe['profile_pic']; ?>" alt="...">
                            </a>
                            <?php echo ucfirst( $employe['fname'] . ' ' .$employe['lname'] ); ?>
                        </td>
                        <td class="cell-300"><?php echo $employe['mobile']; ?></td>
                        <td><?php echo $employe['city']; ?></td>
                        <td><a class="btn btn-primary" href="employe.php?id=<?php echo $employe['employee_id']; ?>">View</a></td>
                        <td class="suf-cell"></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        <?php else: echo'<div class="alert alert-info">No employees found!</div>'; endif; ?>
        </div>
    </div>
    </div>

<?php include_once( '../footer.php' ); ?>