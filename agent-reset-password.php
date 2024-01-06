<?php include 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM agents WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'], $_REQUEST['token']]);
$total = $statement->rowCount();
if (!$total) {
    header('location: ' . BASE_URL . 'agent-login.php');
    exit;
}

?>

<?php
if (isset($_POST['form_submit'])) {
    try {

        if ($_POST['password'] == '' || $_POST['retype_password'] == '') {
            throw new Exception("Password can not be empty");
        }

        if ($_POST['password'] != $_POST['retype_password']) {
            throw new Exception("Passwords do not match");
        }

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $statement = $pdo->prepare("UPDATE agents SET token=?, password=? WHERE email=? AND token=?");
        $statement->execute(['', $password, $_REQUEST['email'], $_REQUEST['token']]);

        $_SESSION['success_message'] = "You can login now!";
        header('location: ' . BASE_URL . 'agent-login.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Agent Forget Password</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="" class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Retype Password *</label>
                            <input type="password" name="retype_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-website" name="form_submit">
                                Submit
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>