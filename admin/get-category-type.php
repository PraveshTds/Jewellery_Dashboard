<?php
include '../inc/config.php';
if($_POST['id'])
{
	$id = $_POST['id'];
	
	$statement = $pdo->prepare("SELECT * FROM tbl_category_type WHERE gender_id=?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">Select Type</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['ctype_id']; ?>"><?php echo $row['ctype_name']; ?></option>
        <?php
	}
}