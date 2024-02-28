<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['tcat_id'])) {
		$valid = 0;
		$error_message .= "You must have to select Gender<br>";
	}

	if (empty($_POST['mcat_id'])) {
		$valid = 0;
		$error_message .= "You must have to select category type<br>";
	}

	if (empty($_POST['ecat_name'])) {
		$valid = 0;
		$error_message .= "Category name can not be empty<br>";
	}

	if ($valid == 1) {

		//Saving data into the main table tbl_end_category
		$statement = $pdo->prepare("INSERT INTO tbl_end_category (ecat_name,mcat_id,sequence,active_product_count,customer) VALUES (?,?,?,?,?)");
		$statement->execute(array($_POST['ecat_name'], $_POST['mcat_id'], $_POST['sequence'], $_POST['active_product_count'], $_POST['customer']));

		$success_message = 'Category is added successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Category</h1>
	</div>
	<div class="content-header-right">
		<a href="Category-List.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message) : ?>
				<div class="callout callout-danger">

					<p>
						<?php echo $error_message; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Gender<span>*</span></label>
							<div class="col-sm-4">
								<select name="tcat_id" class="form-control select2 top-cat">
									<option value="">Gender</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Type<span>*</span></label>
							<div class="col-sm-4">
								<select name="mcat_id" class="form-control select2 mid-cat">
									<option value="">Select Type</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Category<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="ecat_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">sequence<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="sequence">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">active_product_count<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="active_product_count">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Customer<span>*</span></label>
							<div class="col-sm-4">
								<select name="customer" class="form-control">
									<option value="">Customer</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE role = 'customer'");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
									<?php
									}
									?>
								</select>
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