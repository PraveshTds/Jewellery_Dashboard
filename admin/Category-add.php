<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['gender_id'])) {
		$valid = 0;
		$error_message .= "You must have to select Gender<br>";
	}

	if (empty($_POST['ctype_id'])) {
		$valid = 0;
		$error_message .= "You must have to select category type<br>";
	}

	if ($_POST['category_name']) {
		if (empty($_POST['category_name'])) {
			$valid = 0;
			$error_message .= "Category name can not be empty<br>";
		} else {
			if (!preg_match("/^[a-zA-Z]+(_[a-zA-Z]+)*$/", $_POST['category_name'])) {
				$valid = 0;
				$error_message .= "Category name should only contain alphabets and underscores, and no spaces are allowed<br>";
			} else {
				// Check if the category already exists
				$cat_count = 0;
				$existing_cat = $pdo->prepare("SELECT * FROM tbl_category WHERE category_name=?");
				$existing_cat->execute(array($_POST['category_name']));
				$total = $existing_cat->rowCount();
				if ($total) {
					$error_message .= "Category for this customer already exists, cannot create a new category<br>";
					$valid = 0;
				}
			}
		}
	}

	if ($valid == 1) {
		$statement = $pdo->prepare("INSERT INTO tbl_category (category_name,ctype_id) VALUES (?,?)");
		$statement->execute(array($_POST['category_name'], $_POST['ctype_id']));



		$success_message = 'Category is added successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Category</h1>
	</div>
	<div class="content-header-right">
		<a href="category.php" class="btn btn-primary btn-sm">View All</a>
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
								<select name="gender_id" class="form-control select2 gender">
									<option value="">Gender</option>
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
							<label for="" class="col-sm-3 control-label">Type<span>*</span></label>
							<div class="col-sm-4">
								<select name="ctype_id" class="form-control select2 cat-type">
									<option value="">Select Type</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Category<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="category_name">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-3 text-right ">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
							<div class="col-sm-5 text-right ">
								<a href="category.php" class="btn btn-danger pull-left" name="cancel">Cancel</a>
							</div>
						</div>

					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>