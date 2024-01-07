<?php include 'header.php'; ?>

<?php
if (isset($_POST['form_update'])) {
    try {
        if ($_POST['full_name'] == '') {
            throw new Exception("Fullname can not be empty");
        }

        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }

        $statement = $pdo->prepare("UPDATE agents SET 
                                    full_name=?, 
                                    email=?,
                                    company=?,
                                    designation=?,
                                    biography=?,
                                    phone=?,
                                    country=?,
                                    address=?,
                                    state=?,
                                    city=?,
                                    zip_code=?,
                                    website=?,
                                    facebook=?,
                                    twitter=?,
                                    linkedin=?,
                                    pinterest=?,
                                    instagram=?,
                                    youtube=?

                                    WHERE id=?");
        $statement->execute([
            $_POST['full_name'],
            $_POST['email'],
            $_POST['company'],
            $_POST['designation'],
            $_POST['biography'],
            $_POST['phone'],
            $_POST['country'],
            $_POST['address'],
            $_POST['state'],
            $_POST['city'],
            $_POST['zip_code'],
            $_POST['website'],
            $_POST['facebook'],
            $_POST['twitter'],
            $_POST['linkedin'],
            $_POST['pinterest'],
            $_POST['instagram'],
            $_POST['youtube'],
            $_SESSION['agent']['id']
        ]);

        if ($_POST['password'] != '' || $_POST['retype_password'] != '') {
            if ($_POST['password'] != $_POST['retype_password']) {
                throw new Exception("Passwords do not match");
            } else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $statement = $pdo->prepare('UPDATE agents SET password = ? WHERE id = ?');
                $statement->execute([$password, $_SESSION['agent']['id']]);
            }
        }

        // Update photo
        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path != '') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time() . "." . $extension;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);

            if ($mime == 'image/jpeg' || $mime == 'image/png') {
                if ($_SESSION['agent']['photo']) {
                    unlink('/uploads', $_SESSION['agent']['photo']);
                }

                move_uploaded_file($path_tmp, 'uploads/' . $filename);

                $statement = $pdo->prepare('UPDATE agents SET photo = ? WHERE id = ?');
                $statement->execute([$filename, $_SESSION['agent']['id']]);

                $_SESSION['agent']['photo'] = $filename;
            } else {
                throw new Exception("Please upload a valid photo");
            }
        }

        $_SESSION['agent']['full_name'] = $_POST['full_name'];
        $_SESSION['agent']['email'] = $_POST['email'];
        $_SESSION['agent']['company'] = $_POST['company'];
        $_SESSION['agent']['designation'] = $_POST['designation'];
        $_SESSION['agent']['biography'] = $_POST['biography'];
        $_SESSION['agent']['phone'] = $_POST['phone'];
        $_SESSION['agent']['country'] = $_POST['country'];
        $_SESSION['agent']['address'] = $_POST['address'];
        $_SESSION['agent']['state'] = $_POST['state'];
        $_SESSION['agent']['city'] = $_POST['city'];
        $_SESSION['agent']['zip_code'] = $_POST['zip_code'];
        $_SESSION['agent']['website'] = $_POST['website'];
        $_SESSION['agent']['facebook'] = $_POST['facebook'];
        $_SESSION['agent']['twitter'] = $_POST['twitter'];
        $_SESSION['agent']['linkedin'] = $_POST['linkedin'];
        $_SESSION['agent']['pinterest'] = $_POST['pinterest'];
        $_SESSION['agent']['instagram'] = $_POST['instagram'];
        $_SESSION['agent']['youtube'] = $_POST['youtube'];


        $success_message = 'Profile data is updated successfully!';
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Orders</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'agent-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Transaction Id</th>
                                <th>Plan Name</th>
                                <th>Price</th>
                                <th>Order Date</th>
                                <th>Expire Date</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $statement = $pdo->prepare("SELECT * 
                                                        FROM orders 
                                                        JOIN packages
                                                        ON orders.package_id = packages.id
                                                        WHERE orders.agent_id=?
                                                        ORDER BY orders.id DESC
                                                        ");

                            $statement->execute([$_SESSION['agent']['id']]);
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            // $total = $statement->rowCount();
                            $i = 0;
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['transaction_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>$<?php echo $row['price']; ?></td>
                                    <td><?php echo $row['purchase_date']; ?></td>
                                    <td><?php echo $row['expire_date']; ?></td>
                                    <td><?php echo $row['payment_method']; ?></td>
                                    <td>
                                        <?php if ($row['currently_active'] == 1) : ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>