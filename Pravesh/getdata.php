<?php
// header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $category = !$_GET['category'] ? 'Rings' :$_GET['category'];
        $data = getCategoryItem($category);

}
if ($method == 'POST') {
    $category = !$_GET['category'] ? 'Rings' :$_GET['category'];
        $data = getCategoryItem($category);
	//echo "THIS IS A POST REQUEST";
}
if ($method == 'PUT') {
	echo "THIS IS A PUT REQUEST";
}
if ($method == 'DELETE') {
	echo "THIS IS A DELETE REQUEST";
}
function getCategoryItem($category){
    $json_data = file_get_contents('product_data.json');
    echo $json_data;
    $data = json_decode($json_data);

   echo $data;
}