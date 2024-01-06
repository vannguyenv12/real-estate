<?php include 'header.php'; ?>

<div class="page-top" style="background-image: url('uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>User Selection</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="main-part-user">
                    <div class="left-part-user">
                        <h3>
                            <a href="<?php echo BASE_URL; ?>customer-registration">
                                Customer Registration
                            </a>
                        </h3>
                        <h3>
                            <a href="<?php echo BASE_URL; ?>customer-login">
                                Customer Login
                            </a>
                        </h3>
                    </div>
                    <div class="right-part-user">
                        <h3><a href="<?php echo BASE_URL; ?>agent-registration">Agent Registration</a></h3>
                        <h3><a href="<?php echo BASE_URL; ?>agent-login">Agent Login</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>