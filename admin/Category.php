<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Customer Category</h1>
    </div>
    <div class="content-header-right">
        <a href="category-add.php" class="btn btn-primary btn-sm">Assign Categories</a>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Customer</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Change Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * 
                                    FROM tbl_category t1
                                    JOIN tbl_category_type t2
                                    ON t1.ctype_id = t2.ctype_id
                                    JOIN tbl_gender t3
                                    ON t2.gender_id = t3.gender_id
                                    ORDER BY t1.cat_id DESC
                                    ");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr class="<?php if($row['cat_status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>">
                                    <td><?php echo $i; ?></td>
                                    <!-- <td><? //php echo $row['gender_name']; ?></td>
                                    <td><? //php echo $row['ctype_name']; ?></td> -->
                                    <td><?php if ($row['customer']) {
                                            $cust_id = $row['customer'];
                                            $query = "SELECT * from tbl_user where id='$cust_id'";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->execute();
                                            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($res as $row1) {
                                                echo $row1['full_name'];
                                            }
                                        } ?></td>
                                        <td><?php echo $row['cat_name']; ?></td>
                                        <td><?php if($row['cat_status']==1) {echo 'Enable';} else {echo 'Disable';} ?></td>
									<td>
										<a href="category-change-status.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-success btn-xs">Change Status</a>
									</td>
                                    <td>
                                        <a href="category-edit.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-href="category-delete.php?id=<?php echo $row['cat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>