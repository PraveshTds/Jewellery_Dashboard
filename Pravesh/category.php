<?php
// header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
// get request method
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $data = getCatergory();
	// echo "THIS IS A GET REQUEST";
    // foreach ($data as $fruit) {
    //     echo implode(',',$fruit) . "<br>";
    // }
    echo $data;
}
if ($method == 'POST') {
	echo "THIS IS A POST REQUEST";
}
if ($method == 'PUT') {
	echo "THIS IS A PUT REQUEST";
}
if ($method == 'DELETE') {
	echo "THIS IS A DELETE REQUEST";
}
function getCatergory(){
    //$data ='{"meta":{"message":"Success","code":200},"data":[{"category": "Chains","label": "Chains","type":"neck","sequence": 10,"sets_info":[],"active_product_count":160},{"category": "Pendants","label": "Pendants","type":"neck","sequence": 3,"sets_info":[],"active_product_count":160},{"category": "Mangalsutras","label": "Mangalsutras","type":"neck","sequence": 4,"sets_info":[],"active_product_count":440},{"category": "Pendantsets","label": "Pendant Sets","type":"neck","sequence": 5,"sets_info":[{"set_category":"PendantSets","category":"Pendants","type":"neck","category_singular":"pendant","data_key":"pendant_data","code_key":"pendant"},{"set_category":"PendantSets","category":"Earrings","type":"ear","category_singular":"earring","data_key":"earring_data","code_key":"earring"}],"active_product_count":409},{"category":"Earrings","label":"Earrings","type":"ear","sequence":1,"sets_info":[],"active_product_count":160},{"category":"Necklaces","label":"Necklaces","type":"neck","sequence":2,"sets_info":[],"active_product_count":11},{"category":"Sets","label":"Sets","type":"set","sequence":3,"sets_info":[{"set_category":"Sets","category":"Earrings","type":"ear","category_singular":"earring","data_key":"earring_data","code_key":"earring"},{"set_category":"Sets","category":"Necklaces","type":"neck","category_singular":"necklace","data_key":"necklace_data","code_key":"necklace"}],"active_product_count":3},{"category":"Rings","label":"Rings","type":"finger","sequence":4,"sets_info":[],"active_product_count":24},{"category":"Bracelets","label":"Bracelets","type":"wrist","sequence":5,"sets_info":[],"active_product_count":8},{"category":"Maangtika","label":"Maangtika","type":"forehead","sequence":5,"sets_info":[],"active_product_count":0},{"category":"Nosering","label":"Nosering","type":"nose","sequence":6,"sets_info":[],"active_product_count":0},{"category":"Mathapatti","label":"Mathapatti","type":"forehead","sequence":7,"sets_info":[],"active_product_count":0},{"category":"Eyewear","label":"Eyewear","type":"eye","sequence":8,"sets_info":[],"active_product_count":0},{"category":"Watch","label":"Watch","type":"wrist","sequence":9,"sets_info":[],"active_product_count":19},{"category":"Handbag","label":"Handbag","type":"handbag","sequence":99,"sets_info":[],"active_product_count":0}]}';
    //$data ='{"meta":{"message":"Success","code":200},"data":[{"category":"Earrings","label":"Earrings","type":"ear","sequence":1,"sets_info":[],"active_product_count":16},{"category":"Necklaces","label":"Necklaces","type":"neck","sequence":2,"sets_info":[],"active_product_count":11},{"category":"Sets","label":"Sets","type":"set","sequence":3,"sets_info":[{"set_category":"Sets","category":"Earrings","type":"ear","category_singular":"earring","data_key":"earring_data","code_key":"earring"},{"set_category":"Sets","category":"Necklaces","type":"neck","category_singular":"necklace","data_key":"necklace_data","code_key":"necklace"}],"active_product_count":3},{"category":"Rings","label":"Rings","type":"finger","sequence":4,"sets_info":[],"active_product_count":24},{"category":"Bracelets","label":"Bracelets","type":"wrist","sequence":5,"sets_info":[],"active_product_count":8},{"category":"Maangtika","label":"Maangtika","type":"forehead","sequence":5,"sets_info":[],"active_product_count":0},{"category":"Nosering","label":"Nosering","type":"nose","sequence":6,"sets_info":[],"active_product_count":0},{"category":"Mathapatti","label":"Mathapatti","type":"forehead","sequence":7,"sets_info":[],"active_product_count":0},{"category":"Eyewear","label":"Eyewear","type":"eye","sequence":8,"sets_info":[],"active_product_count":0},{"category":"Watch","label":"Watch","type":"wrist","sequence":9,"sets_info":[],"active_product_count":19},{"category":"Handbag","label":"Handbag","type":"handbag","sequence":99,"sets_info":[],"active_product_count":0}]}';
    $data = file_get_contents('cat_data.json');
    return $data;
}
