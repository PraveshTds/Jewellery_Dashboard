<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['gender_id'])) {
        $valid = 0;
        $error_message .= "You must have to select gender<br>";
    }

    if(empty($_POST['ctype_name'])) {
        $valid = 0;
        $error_message .= "Category type can not be empty<br>";
    }

    if($valid == 1) {

		// Saving data into the main table tbl_category_type
		$statement = $pdo->prepare("INSERT INTO tbl_category_type (ctype_name,gender_id) VALUES (?,?)");
		$statement->execute(array($_POST['ctype_name'],$_POST['gender_id']));
	
    	$success_message = 'Category type is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Category Type</h1>
	</div>
	<div class="content-header-right">
		<a href="cust-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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
							<label for="" class="col-sm-3 control-label"> Gender <span>*</span></label>
							<div class="col-sm-4">
								<select name="gender_id" class="form-control select2">
									<option value="">Select Gender</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_gender ORDER BY gender_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
									foreach ($result as $row) {
										?>
										<option value="<?php echo $row['gender_id']; ?>"><?php echo $row['gender_name']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"> Category Type <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="ctype_name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>