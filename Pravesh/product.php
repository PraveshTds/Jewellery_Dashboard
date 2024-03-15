<?php
// header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');


// switch ($_SERVER['REQUEST_METHOD']) {
//     case 'GET':
//         get_fabrics();
//         break;
//     case 'POST':
//         add_fabric();
//         break;
//     default:
//         header('HTTP/1.1 405 Method Not Allowed');
//         header('Allow: GET, POST');
//         break;
// }



// get request method
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $category = !$_GET['category'] ? 'Rings' :$_GET['category'];
        $data = getCategoryItem($category);
	// echo "THIS IS A GET REQUEST";
    // foreach ($data as $fruit) {
    //     echo implode(',',$fruit) . "<br>";
    // }
    //echo $data;
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
    $data = json_decode($json_data);
    $filtered_data = array();
    foreach ($data as $item) {
        if ($item->cat == $category) {
            $filtered_data[] = $item;
        }
    }
    $json_filtered_data = json_encode($filtered_data);
    // $productResponse = array_filter($data, function($number){
    //     return $number % 2 == 0;
    //   });
      //$allProductResponse
    //echo "Category Iteams THIS IS A Get REQUEST";
   //echo $allProductResponse;
   echo $json_filtered_data;
}