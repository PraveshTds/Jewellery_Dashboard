<?php require_once('header.php'); ?>
<?php
// server connection
// $local_folder = 'C:\xampp\htdocs\ECommerce\Pravesh';
// function ftp_recursive_put($ftpConnection, $local_folder, $remote_folder) {
//     $dir = opendir($local_folder);

// //     // Iterate through each item in the folder
//     while ($file = readdir($dir)) {
//         if ($file != '.' && $file != '..') {
//             $local_path = $local_folder . '/' . $file;
//             $remote_path = $remote_folder . '/' . $file;

//             if (is_dir($local_path)) {
//                 // If it's a directory, create the directory on the server and recursively upload its contents
//                 ftp_mkdir($ftpConnection, $remote_path);
//                 ftp_recursive_put($ftpConnection, $local_path, $remote_path);
//             } else {
//                 // If it's a file, upload the file to the server
//                 ftp_put($ftpConnection, $remote_path, $local_path, FTP_BINARY);
//             }
//         }
//     }

//     closedir($dir);
// }
?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= "Customer name cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= "Email address cannot be empty" . "<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= "Email doesnt Match" . "<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();
            if ($total) {
                $valid = 0;
                $error_message .= "This email is already registered. Please use another one." . "<br>";
            }
        }
    }

    if (empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= "Phone number cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= "Address cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= "Country cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= "City cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= "State cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= "Zip code cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= "Both password fields are required" . "<br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= "Password do not match . Please re-enter your password." . "<br>";
        }
    }

    if ($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_cname,
                                        cust_email,
                                        cust_phone,
                                        cust_country,
                                        cust_address,
                                        cust_city,
                                        cust_state,
                                        cust_zip,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            strip_tags($_POST['cust_name']),
            strip_tags($_POST['cust_cname']),
            strip_tags($_POST['cust_email']),
            strip_tags($_POST['cust_phone']),
            strip_tags($_POST['cust_country']),
            strip_tags($_POST['cust_address']),
            strip_tags($_POST['cust_city']),
            strip_tags($_POST['cust_state']),
            strip_tags($_POST['cust_zip']),
            md5($_POST['cust_password']),
            $token,
            $cust_datetime,
            $cust_timestamp,
            0
        ));
        "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // saving into db for creating customer 
        $statement = $pdo->prepare("INSERT INTO tbl_user (
    full_name,
    email,
    phone,
    password,
    photo,
    role,
    status
) VALUES (?,?,?,?,?,?,?)");
        $statement->execute(array(
            strip_tags($_POST['cust_name']),
            strip_tags($_POST['cust_email']),
            strip_tags($_POST['cust_phone']),
            md5($_POST['cust_password']),
            strip_tags('test.png'),
            strip_tags('Admin'),
            strip_tags('Active')
        ));
        // end

        // Create a new folder
        // if (ftp_mkdir($ftpConnection, $ftpDirectory . strip_tags($_POST['cust_name']))) {
        //     echo 'Folder created successfully';
        // } else {
        //     echo 'Failed to create folder';
        // }
        // $server_folder = strip_tags($_POST['cust_name']);
        // $remote_folder = "public_html/api_jewellery/api/Brand/{$server_folder}";
        // ftp_recursive_put($ftpConnection, $local_folder, $remote_folder);

        // Sending Email
        // mail($to, $subject, $message, $headers);

        unset($_POST['cust_name']);
        unset($_POST['cust_cname']);
        unset($_POST['cust_email']);
        unset($_POST['cust_phone']);
        unset($_POST['cust_address']);
        unset($_POST['cust_city']);
        unset($_POST['cust_state']);
        unset($_POST['cust_zip']);
        // ftp_close($ftpConnection);
        $success_message = "Customer has been added successfully.";
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Product</h1>
    </div>
    <div class="content-header-right">
        <a href="customer.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="user-content">
                            <form action="" method="post">
                                <?php $csrf->echoInputField(); ?>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">

                                        <?php
                                        if ($error_message != '') {
                                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                                        }
                                        if ($success_message != '') {
                                            echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                        }
                                        ?>

                                        <div class="col-md-6 form-group">
                                            <label for="">Customer Name *</label>
                                            <input type="text" class="form-control" name="cust_name" value="<?php if (isset($_POST['cust_name'])) {
                                                                                                                echo $_POST['cust_name'];
                                                                                                            } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Company Name *</label>
                                            <input type="text" class="form-control" name="cust_cname" value="<?php if (isset($_POST['cust_cname'])) {
                                                                                                                    echo $_POST['cust_cname'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Email *</label>
                                            <input type="email" class="form-control" name="cust_email" value="<?php if (isset($_POST['cust_email'])) {
                                                                                                                    echo $_POST['cust_email'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Phone *</label>
                                            <input type="text" class="form-control" name="cust_phone" value="<?php if (isset($_POST['cust_phone'])) {
                                                                                                                    echo $_POST['cust_phone'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="">Address *</label>
                                            <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php if (isset($_POST['cust_address'])) {
                                                                                                                                            echo $_POST['cust_address'];
                                                                                                                                        } ?></textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Country *</label>
                                            <select name="cust_country" class="form-control select2">
                                                <option value="">Select country</option>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                    <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="">City *</label>
                                            <input type="text" class="form-control" name="cust_city" value="<?php if (isset($_POST['cust_city'])) {
                                                                                                                echo $_POST['cust_city'];
                                                                                                            } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">State *</label>
                                            <input type="text" class="form-control" name="cust_state" value="<?php if (isset($_POST['cust_state'])) {
                                                                                                                    echo $_POST['cust_state'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Zipcode *</label>
                                            <input type="text" class="form-control" name="cust_zip" value="<?php if (isset($_POST['cust_zip'])) {
                                                                                                                echo $_POST['cust_zip'];
                                                                                                            } ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Password *</label>
                                            <input type="password" class="form-control" name="cust_password">
                                        </div>
                                        <div class="col-md-6 form-group">

                                            <label for="">Confirm Password *</label>
                                            <input type="password" class="form-control" name="cust_re_password">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="">Role *</label>
                                            <input type="text" class="form-control" name="cust_role">
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for=""></label>
                                                <input type="submit" class="btn btn-success" value="Submit" name="form1">
                                            </div>
                                            <div class="col-sm-5 text-right ">
                                                <a href="customer.php" class="btn btn-danger pull-right" name="cancel">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>