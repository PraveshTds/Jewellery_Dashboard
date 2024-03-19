<?php
require_once('header.php'); ?>


<?php
function addCategory($pdo, $ftpConnection, $cat_name, $cat_type_name, $sequence, $error_message, $success_message)
{
	$customer = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$customer->execute(array($_POST['customer']));
	$total_cust = $customer->fetchAll();
	$cust = strtolower($total_cust[0]['full_name']);

	$json_data = getting_files_category($ftpConnection, $pdo,$cust);
	$categories = json_decode($json_data, true);

	$categoryExists = false;
	foreach ($categories['data'] as &$category) {
		if ($category['category'] === $cat_name){
			$categoryExists = true;
			$new_category = array(
				$category['category'] => $cat_name,
				$category['label'] => $cat_name, // Assuming label is same as category name
				$category['type'] => $cat_type_name, // Assuming ctype_id corresponds to type
				$category['sequence'] => (int)$sequence,
				$category['sets_info'] => array(),
				"active_product_count" => 0
			);
		}
	}

	if (!$categoryExists){
		// Construct new category data
		$new_category = array(
			"category" => $cat_name,
			"label" => $cat_name, // Assuming label is same as category name
			"type" => $cat_type_name, // Assuming ctype_id corresponds to type
			"sequence" => (int)$sequence,
			"sets_info" => array(),
			"active_product_count" => 0
		);
		// Append new category to existing categories array
		$categories['data'][] = $new_category;
	}

	// Convert array back to JSON
	$updated_json = json_encode($categories, JSON_PRETTY_PRINT);

	$remote_json_file = "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$cust}/cat_data.json";

	// Write updated JSON to a temporary local file
	$temp_file = tempnam(sys_get_temp_dir(), 'updated_json_');
	if ($temp_file === false) {
		$error_message .= 'Unable to create temporary file.';
	} else {
		if (file_put_contents($temp_file, $updated_json)) {
			$upload_result = ftp_put($ftpConnection, $remote_json_file, $temp_file, FTP_BINARY);
			if ($upload_result === false) {
				$error_message .= 'Unable to upload JSON data to the server.';
			} else {
				$success_message .= ' JSON data updated successfully.';
			}
			unlink($temp_file);
		} else {
			$error_message .= 'Unable to write JSON data to temporary file.';
		}
	}

	ftp_close($ftpConnection);
}

function updateCategoryActiveProductCount($pdo, $ftpConnection, $categoryName, $newActiveProductCount, $customer)
{
    // Get the JSON data from the server
    $json_data = getting_files_category($ftpConnection, $pdo,$customer);

    // Decode the JSON data
    $categories = json_decode($json_data, true);

    // Find the category by name and update its active_product_count
    foreach ($categories['data'] as &$category) {
        if ($category['category'] == $categoryName) {
            $category['active_product_count'] = $newActiveProductCount;
            break; // No need to continue once the category is found and updated
        }
    }

    // Convert array back to JSON
    $updated_json = json_encode($categories, JSON_PRETTY_PRINT);

    // Remote JSON file path
    $remote_json_file = "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$customer}/cat_data.json";

    // Write updated JSON to a temporary local file
    $temp_file = tempnam(sys_get_temp_dir(), 'updated_json_');
    if ($temp_file !== false) {
        if (file_put_contents($temp_file, $updated_json)) {
            // Upload the temporary file to the server using FTP
            $upload_result = ftp_put($ftpConnection, $remote_json_file, $temp_file, FTP_BINARY);
            if ($upload_result === false) {
                // Handle upload error
                return 'Unable to upload JSON data to the server.';
            } else {
                return 'Active product count updated successfully.';
            }
            unlink($temp_file);
        } else {
            return 'Unable to write JSON data to temporary file.';
        }
    } else {
        return 'Unable to create temporary file.';
    }
}

function deleteCategory($pdo, $ftpConnection, $categoryName, $customer)
{
	$json_data = getting_files_category($ftpConnection, $pdo, $customer);

    // Decode the JSON data
    $categories = json_decode($json_data, true);

    // Find the index of the category to delete
    $indexToDelete = null;
    foreach ($categories['data'] as $index => $category) {
        if ($category['category'] == $categoryName) {
            $indexToDelete = $index;
            break;
        }
    }

    // If the category is found, remove it from the array
    if ($indexToDelete !== null) {
        unset($categories['data'][$indexToDelete]);

        // Re-index the array to avoid gaps in the index
        $categories['data'] = array_values($categories['data']);

        // Convert array back to JSON
        $updated_json = json_encode($categories, JSON_PRETTY_PRINT);

        // Remote JSON file path
        $remote_json_file = "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$customer}/cat_data.json";

        // Write updated JSON to a temporary local file
        $temp_file = tempnam(sys_get_temp_dir(), 'updated_json_');
        if ($temp_file !== false) {
            if (file_put_contents($temp_file, $updated_json)) {
                // Upload the temporary file to the server using FTP
                $upload_result = ftp_put($ftpConnection, $remote_json_file, $temp_file, FTP_BINARY);
                if ($upload_result === false) {
                    // Handle upload error
                    return 'Unable to upload JSON data to the server.';
                } else {
                    return true; // Category deleted successfully
                }
                unlink($temp_file);
            } else {
                return 'Unable to write JSON data to temporary file.';
            }
        } else {
            return 'Unable to create temporary file.';
        }
    } else {
        return 'Category not found.';
    }
}

function updateCategory($pdo, $ftpConnection, $previouscategoryname, $newCategoryName, $newCategoryType, $customer)
{
	$json_data = getting_files_category($ftpConnection, $pdo,$customer);

    // Decode the JSON data
    $categories = json_decode($json_data, true);

    // Find the category by name and update its active_product_count
    foreach ($categories['data'] as &$category) {
        if ($category['category'] == $previouscategoryname) {
            $category['category'] = $newCategoryName;
				$category['label'] = $newCategoryName; // Assuming label is same as category name
				$category['type'] = $newCategoryType;
            break; // No need to continue once the category is found and updated
        }
    }

    // Convert array back to JSON
    $updated_json = json_encode($categories, JSON_PRETTY_PRINT);

    // Remote JSON file path
    $remote_json_file = "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$customer}/cat_data.json";

    // Write updated JSON to a temporary local file
    $temp_file = tempnam(sys_get_temp_dir(), 'updated_json_');
    if ($temp_file !== false) {
        if (file_put_contents($temp_file, $updated_json)) {
            // Upload the temporary file to the server using FTP
            $upload_result = ftp_put($ftpConnection, $remote_json_file, $temp_file, FTP_BINARY);
            if ($upload_result === false) {
                // Handle upload error
                return 'Unable to upload JSON data to the server.';
            } else {
                return 'Active product count updated successfully.';
            }
            unlink($temp_file);
        } else {
            return 'Unable to write JSON data to temporary file.';
        }
    } else {
        return 'Unable to create temporary file.';
    }
}

?>
