<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item <?php if ($cur_page == 'customer-dashboard.php') {
                                        echo 'active';
                                    } ?>">
            <a href="<?php echo BASE_URL ?>customer-dashboard">Dashboard</a>
        </li>
        <li class="list-group-item">
            <a href="user-wishlist.html">Wishlist</a>
        </li>
        <li class="list-group-item <?php if ($cur_page == 'customer-edit-profile.php') {
                                        echo 'active';
                                    } ?>">
            <a href="<?php echo BASE_URL ?>customer-edit-profile">Edit Profile</a>
        </li>
        <li class="list-group-item">
            <a href="<?php echo BASE_URL; ?>customer-logout">Logout</a>
        </li>
    </ul>
</div>