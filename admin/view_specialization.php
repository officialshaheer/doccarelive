<?php include_once( '../header.php' ); ?>

<?php 
    
    $db = new Database();
    $sql = 'select * from specialization';
    $spec = $db->display($sql);
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
            <h3 class="panel-title">Specializations</h3>
        </div>
        <div class="panel-body">
            <!-- Contacts -->
            <?php if($spec): ?>
            <table class="table is-indent tablesaw">
                <thead>
                    <tr>
                        <th class="cell-30" scope="col">
                        </th>
                        <th class="cell-300" scope="col">Specialization</th>
                        <th class="cell-300" scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($spec as $spe) { ?>
                    <tr class="panel-hover-tb">
                        <td class="cell-30">
                        </td>
                        <td class="cell-300">
                            <?php echo ucfirst( $spe['specialization'] ); ?>
                        </td>
                        <td class="cell-300"><?php echo $spe['description']; ?></td>
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