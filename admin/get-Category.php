<?php
include '../inc/config.php';
if($_POST['id'])
{
	$id = $_POST['id'];
	
	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE ctype_id=?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">Select Category</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
        <?php
	}
}