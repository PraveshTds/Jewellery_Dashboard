<?php
require_once('header.php');
$local_folder = 'C:\xampp\htdocs\ECommerce\Pravesh';

function ftp_files_put($ftpConnection, $local_folder, $remote_folder)
{
    $dir = opendir($local_folder);

    // Iterate through each item in the folder
    while ($file = readdir($dir)) {
        if ($file != '.' && $file != '..') {
            $local_path = $local_folder . '/' . $file;
            $remote_path = $remote_folder . '/' . $file;

            if (is_dir($local_path)) {
                // If it's a directory, create the directory on the server and recursively upload its contents
                ftp_mkdir($ftpConnection, $remote_path);
                ftp_files_put($ftpConnection, $local_path, $remote_path);
            } else {
                // If it's a file, upload the file to the server
                ftp_put($ftpConnection, $remote_path, $local_path, FTP_BINARY);
            }
        }
    }

    // closedir($dir);
}
function getting_files_category($ftpConnection, $pdo, $customer)
{
    if (isset($_POST['category_name'])) {
        $customer = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
        $customer->execute(array($_POST['customer']));
        $total_cust = $customer->fetchAll();
        $cust = strtolower($total_cust[0]['full_name']);
    } else {
        $cust = strtolower($customer);
    }


    $ftpDirectory = "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$cust}";

    // returns files present in that directory
    $dirlist = ftp_nlist($ftpConnection, $ftpDirectory);

    if (is_array($dirlist)) {
        foreach ($dirlist as $filename) {
            // Check if the file is cat_data.json in the desired directory
            if ($filename == "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$cust}/cat_data.json") {
                // Download the JSON file
                $localFile = tempnam(sys_get_temp_dir(), 'cat_data_');
                if (ftp_get($ftpConnection, $localFile, $filename, FTP_BINARY)) {
                    // Read the JSON file into a variable
                    $json_data = file_get_contents($localFile);
                    unlink($localFile); // Remove the temporary file
                    return $json_data; // Return the JSON data
                } else {
                    // Handle error
                    return null; // Return null or handle the error accordingly
                }
            }
        }
    }
}

function getting_files_cust($ftpConnection, $cust)
{
    $ftpDirectory = "/domains/textronic.info/public_html/api_jewellery/api/Brand";

    // returns files present in that directory
    $dirlist = ftp_nlist($ftpConnection, $ftpDirectory);

    if (is_array($dirlist)) {
        foreach ($dirlist as $filename) {
            // Check if the customer file already present
            if ($filename == "/domains/textronic.info/public_html/api_jewellery/api/Brand/{$cust}") {
                return true;
            } else {
                return false;
            }
        }
    }
}

function ftp_remove_directory_contents($ftpConnection, $customer_folder)
{
    $files = ftp_nlist($ftpConnection, $customer_folder);
    foreach ($files as $file) {
        ftp_delete($ftpConnection, $file);
    }
}
