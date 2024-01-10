<?php include 'header.php'; ?>

<?php
if (!isset($_SESSION['agent'])) {
    header('location:' . BASE_URL . 'agent-login');
}
?>

<?php

if (isset($_POST['form_paypal'])) {
    try {
        $statement = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
        $statement->execute([$_POST['package_id']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $allowed_properties = $row['allowed_properties'];
            $_SESSION['package_id'] = $row['id'];
            $_SESSION['price'] = $row['price'];
            $_SESSION['allowed_days'] = $row['allowed_days'];
        }
        $statement = $pdo->prepare("SELECT * FROM properties WHERE agent_id = ?");
        $statement->execute([$_SESSION['agent']['id']]);
        $total_properties = $statement->rowCount();

        if ($allowed_properties != -1) {
            if ($total_properties > $allowed_properties) {
                unset($_SESSION['package_id']);
                unset($_SESSION['price']);
                unset($_SESSION['allowed_days']);
                throw new Exception('You are going to downgrade the package. Please delete some properties first');
            }
        }

        $response = $gateway->purchase(array(
            'amount' => $_SESSION['price'],
            'currency' => PAYPAL_CURRENCY,
            'returnUrl' => PAYPAL_RETURN_URL,
            'cancelUrl' => PAYPAL_CANCEL_URL,
        ))->send();
        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo $response->getMessage();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('location: ' . BASE_URL . 'agent-payment');
        exit;
    }
}
?>


<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Payment</h2>
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
                <div class="col-lg-9 col-md-12">
                    <h4>Current Active Plan</h4>

                    <div class="row box-items mb-4">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM orders 
                                                    LEFT JOIN packages 
                                                    ON orders.package_id=packages.id
                                                    WHERE agent_id=? AND currently_active=?");

                        $statement->execute([$_SESSION['agent']['id'], 1]);
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                        $total = $statement->rowCount();
                        // foreach ($result as $row) {

                        // }
                        ?>

                        <?php if ($total) : ?>
                            <div class="col-md-4">
                                <?php
                                foreach ($result as $row) {
                                ?>
                                    <div class="box1">
                                        <h4>$<?php echo $row['price']; ?></h4>
                                        <p><?php echo $row['name']; ?></p>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>

                        <?php else : ?>
                            <div class="col-md-12 text-danger">
                                No package found.
                            </div>
                        <?php endif; ?>

                    </div>

                    <h4>Upgrade Plan (Make Payment)</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered upgrade-plan-table">
                            <tr>
                                <td>
                                    <form action="" method="post">
                                        <select name="package_id" class="form-control select2">
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM packages ORDER BY id ASC");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($result as $row) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> ($<?php echo $row['price'] ?>)</option>

                                            <?php
                                            }
                                            ?>

                                        </select>
                                </td>
                                <td>
                                    <button type="submit" name="form_paypal" href="" class="btn btn-secondary btn-sm buy-button">Pay with PayPal</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="" class="form-control select2">
                                        <option value="">Basic ($19)</option>
                                        <option value="">Platinum ($29)</option>
                                        <option value="">Gold ($39)</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="" class="btn btn-secondary btn-sm buy-button">Pay with Card</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>