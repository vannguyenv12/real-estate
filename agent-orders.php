<?php include 'header.php'; ?>

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