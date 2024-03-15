<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['gender_id'])) {
        $valid = 0;
        $error_message .= "You must have to select Gender<br>";
    }

    if(empty($_POST['ctype_id'])) {
        $valid = 0;
        $error_message .= "You must have to select category type<br>";
    }

    if(empty($_POST['cat_name'])) {
        $valid = 0;
        $error_message .= "Category name can not be empty<br>";
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_cust_category SET cat_name=?,ctype_id=? WHERE cat_id=?");
		$statement->execute(array($_POST['cat_name'],$_POST['ctype_id'],$_REQUEST['id']));

    	$success_message = 'Category is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * 
                            FROM tbl_cust_category t1
                            JOIN tbl_category_type t2
                            ON t1.ctype_id = t2.ctype_id
                            JOIN tbl_gender t3
                            ON t2.gender_id = t3.gender_id
                            WHERE t1.cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Category</h1>
	</div>
	<div class="content-header-right">
		<a href="cust-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$cat_name = $row['cat_name'];
    $ctype_id = $row['ctype_id'];
    $gender_id = $row['gender_id'];
    $id = $row['customer'];
}
?>

<section class="content">

  <div class="row">
    <div class="col-md-12">

		<?php if($error_message): ?>
		<div class="callout callout-danger">
		
		<p>
		<?php echo $error_message; ?>
		</p>
		</div>
		<?php endif; ?>

		<?php if($success_message): ?>
		<div class="callout callout-success">
		
		<p><?php echo $success_message; ?></p>
		</div>
		<?php endif; ?>

        <form class="form-horizontal" action="" method="post">

        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Gender <span>*</span></label>
                    <div class="col-sm-4">
                        <select name="gender_id" class="form-control select2 gender">
                            <option value="">Select Category</option>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_gender ORDER BY gender_name ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['gender_id']; ?>" <?php if($row['gender_id'] == $gender_id){echo 'selected';} ?>><?php echo $row['gender_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Customer <span>*</span></label>
                    <div class="col-sm-4">
                        <select name="cust_id" class="form-control select2 customer">
                            <option value="">Select Customer</option>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_user ORDER BY full_name ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $id){echo 'selected';} ?>><?php echo $row['full_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Category Type<span>*</span></label>
                    <div class="col-sm-4">
                        <select name="ctype_id" class="form-control select2 cat-type">
                            <option value="">Select Type</option>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_category_type WHERE gender_id = ? ORDER BY ctype_name ASC");
                            $statement->execute(array($gender_id));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['ctype_id']; ?>" <?php if($row['ctype_id'] == $ctype_id){echo 'selected';} ?>><?php echo $row['ctype_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Category Name<span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="cat_name" value="<?php echo $cat_name; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                	<label for="" class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                    </div>
                </div>

            </div>

        </div>

        </form>



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
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>