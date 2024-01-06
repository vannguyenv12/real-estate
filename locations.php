<?php include 'header.php' ?>
<div class="page-top" style="background-image: url('uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Locations</h2>
            </div>
        </div>
    </div>
</div>

<div class="location pb_40">
    <div class="container">
        <div class="row">
            <?php

            $statement = $pdo->prepare("SELECT * FROM locations ORDER BY name ASC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="item">
                        <div class="photo">
                            <a href="location.html"><img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo'] ?>" alt=""></a>
                        </div>
                        <div class="text">
                            <h2><a href=""><?php echo $row['name'] ?></a></h2>
                            <h4>(10 Properties)</h4>
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>

        </div>
    </div>
</div>
<?php include 'footer.php' ?>