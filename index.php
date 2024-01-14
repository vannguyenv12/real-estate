<?php include 'header.php'; ?>

<?php
$allowed_agents = [];
$q = $pdo->prepare("SELECT agent_id FROM orders WHERE expire_date >= CURDATE() AND currently_active=?");
$q->execute([1]);
$result = $q->fetchAll();
foreach ($result as $row) {
    $allowed_agents[] = $row['agent_id'];
}
$agent_list = implode(',', $allowed_agents);
?>


<div class="slider" style="background-image: url(<?php echo BASE_URL; ?>uploads/banner-home.jpg)">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item">
                    <div class="text">
                        <h2>Discover Your New Home</h2>
                        <p>
                            You can get your desired awesome properties, homes, condos etc. here by name, category or location.
                        </p>
                    </div>
                    <div class="search-section">
                        <form action="<?php echo BASE_URL; ?>properties.php" method="get">
                            <div class="inner">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Property Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="location_id" class="form-select select2">
                                                <option value="">All Locations</option>

                                                <?php

                                                $statement = $pdo->prepare("SELECT * FROM locations ORDER BY name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                <?php
                                                }

                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="type_id" class="form-select select2">
                                                <option value="">All Types</option>
                                                <?php

                                                $statement = $pdo->prepare("SELECT * FROM types ORDER BY name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                <?php
                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="amenity_id" value="">
                                        <input type="hidden" name="purpose" value="">
                                        <input type="hidden" name="bedrooms" value="">
                                        <input type="hidden" name="bathrooms" value="">
                                        <input type="hidden" name="price" value="">
                                        <input type="hidden" name="p" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="property">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Featured Properties</h2>
                    <p>Find out the awesome properties that you must love</p>
                </div>
            </div>
        </div>
        <div class="row">

            <?php
            $statement = $pdo->prepare("SELECT p.*, l.name as location_name, t.name as type_name, a.full_name, a.photo
                                        FROM properties p
                                        JOIN locations l
                                        ON p.location_id = l.id
                                        JOIN types t
                                        ON p.type_id = t.id
                                        JOIN agents a
                                        ON p.agent_id = a.id
                                        WHERE p.is_featured=? AND p.agent_id NOT IN (
                                            SELECT a.id
                                            FROM agents a
                                            JOIN orders o
                                            ON a.id = o.agent_id
                                            WHERE o.expire_date < ? AND o.currently_active = ?
                                        )
                                        LIMIT 6
                                        ");
            $statement->execute(['Yes', date('Y-m-d'), 1]);

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $total = $statement->rowCount();

            if (!$total) {
            ?>
                <div class="col-md-12">No property found</div>
                <?php
            } else {
                foreach ($result as $row) {
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="item">
                            <div class="photo">
                                <img class="main" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo'] ?>" alt="">
                                <div class="top">
                                    <div class="status-<?php if ($row['purpose'] == 'Rent') {
                                                            echo 'rent';
                                                        } else {
                                                            echo 'sale';
                                                        } ?>">
                                        For <?php echo $row['purpose'] ?>
                                    </div>
                                    <div class="featured">
                                        Featured
                                    </div>
                                </div>
                                <div class="price">$<?php echo $row['price'] ?></div>
                                <div class="wishlist">
                                    <a href="<?php echo BASE_URL ?>customer-wishlist-add/<?php echo $row['id']; ?>">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="text">
                                <h3><a href="<?php echo BASE_URL; ?>property/<?php echo $row['id'] ?>/<?php echo $row['slug']; ?>"><?php echo $row['name'] ?></a></h3>
                                <div class="detail">
                                    <div class="stat">
                                        <div class="i1"><?php echo $row['size'] ?> sqft</div>
                                        <div class="i2"><?php echo $row['bedrooms'] ?> Bed</div>
                                        <div class="i3"><?php echo $row['bathrooms'] ?> Bath</div>
                                    </div>
                                    <div class="address">
                                        <i class="fas fa-map-marker-alt"></i> <?php echo $row['address'] ?>
                                    </div>
                                    <div class="type-location">
                                        <div class="i1">
                                            <i class="fas fa-edit"></i> <?php echo $row['type_name'] ?>
                                        </div>
                                        <div class="i2">
                                            <i class="fas fa-location-arrow"></i> <?php echo $row['location_name'] ?>
                                        </div>
                                    </div>
                                    <div class="agent-section">
                                        <?php if ($row['photo'] == '') : ?>
                                            <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/default.png" alt="">

                                        <?php else : ?>
                                            <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="">

                                        <?php endif; ?>
                                        <a href=""><?php echo $row['full_name'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }

            ?>

        </div>
    </div>
</div>


<div class="why-choose" style="background-image: url(<?php echo BASE_URL; ?>uploads/why-choose.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Why Choose Us</h2>
                    <p>
                        Describing why we are best in the property business
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $statement = $pdo->prepare("SELECT * FROM why_choose_items ORDER BY id ASC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $total = $statement->rowCount();
            foreach ($result as $row) {
            ?>
                <div class="col-md-4">
                    <div class="inner">
                        <div class="icon">
                            <i class="<?php echo $row['icon']; ?>"></i>
                        </div>
                        <div class="text">
                            <h2><?php echo $row['heading']; ?></h2>
                            <p>
                                <?php echo $row['text']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>

        </div>
    </div>
</div>


<div class="agent">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Agents</h2>
                    <p>
                        Meet our expert property agents from the following list
                    </p>
                </div>
            </div>
        </div>

        <!-- Agent -->
        <div class="row">
            <?php
            $statement = $pdo->prepare("SELECT *
                                        FROM agents 
                                        WHERE status = ? AND id in ($agent_list) LIMIT 8");
            $statement->execute([1]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
                <div class="col-lg-3 col-md-3">
                    <div class="item">
                        <div class="photo">
                            <a href="<?php echo BASE_URL; ?>agent/<?php echo $row['id']; ?>">
                                <?php if ($row['photo'] == '') : ?>
                                    <img src="<?php BASE_URL; ?>uploads/default.png" alt="">
                                <?php else : ?>
                                    <img src="<?php BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="<?php echo BASE_URL ?>agent/<?php echo $row['id'] ?>"><?php echo $row['full_name']; ?></a>
                            </h2>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>



<div class="location pb_40">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Locations</h2>
                    <p>
                        Check out all the properties of important locations
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php

            $statement = $pdo->prepare("SELECT l.id,l.name as location_name, l.photo as location_photo, l.slug as location_slug, COUNT(*) as location_count
            FROM properties p
            JOIN locations l
            ON p.location_id = l.id
            WHERE p.agent_id IN ($agent_list)
            GROUP BY l.id,l.name, l.photo, l.slug
            ORDER BY location_count DESC");

            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="item">
                        <div class="photo">
                            <a href="<?php echo BASE_URL; ?>location/<?php echo $row['location_slug'] ?>">
                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['location_photo'] ?>" alt="">
                            </a>
                        </div>

                        <div class="text">
                            <h2><a href="<?php echo BASE_URL; ?>location/<?php echo $row['location_slug'] ?>"><?php echo $row['location_name'] ?></a></h2>
                            <h4>(<?php echo $row['location_count'] ?> Properties)</h4>
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>


        </div>
    </div>
</div>



<div class="testimonial" style="background-image: url(uploads/testimonial-bg.jpg)">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Our Happy Clients</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="testimonial-carousel owl-carousel">
                    <div class="item">
                        <div class="photo">
                            <img src="uploads/t1.jpg" alt="" />
                        </div>
                        <div class="text">
                            <h4>Robert Krol</h4>
                            <p>CEO, ABC Company</p>
                        </div>
                        <div class="description">
                            <p>
                                I recently worked with Patrick Johnson on purchasing my dream home and I couldn't have asked for a better experience. Patrick Johnson was knowledgeable, professional, and truly cared about finding me the perfect property. They were always available to answer my questions and made the entire process stress-free. I highly recommend Patrick Johnson to anyone looking to buy or sell a property!
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="photo">
                            <img src="uploads/t2.jpg" alt="" />
                        </div>
                        <div class="text">
                            <h4>Sal Harvey</h4>
                            <p>Director, DEF Company</p>
                        </div>
                        <div class="description">
                            <p>
                                I had the pleasure of working with Smith Brent during my recent home search and I can't speak highly enough of their services. Smith Brent listened to my needs and helped me find the perfect home that met all of my requirements. They were always there for me, from the initial search to closing, and made the process seamless and enjoyable. I would recommend Smith Brent to anyone looking for an experienced and dedicated real estate agent.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Latest News</h2>
                    <p>
                        Check our latest news from the following section
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo">
                        <img src="uploads/blog1.jpg" alt="" />
                    </div>
                    <div class="text">
                        <h2>
                            <a href="post.html">5 Tips for Finding Your Dream Home</a>
                        </h2>
                        <div class="short-des">
                            <p>
                                Lorem ipsum dolor sit amet, nibh saperet
                                te pri, at nam diceret disputationi. Quo
                                an consul impedit, usu possim evertitur
                                dissentiet ei.
                            </p>
                        </div>
                        <div class="button">
                            <a href="post.html" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo">
                        <img src="uploads/blog2.jpg" alt="" />
                    </div>
                    <div class="text">
                        <h2>
                            <a href="post.html">Pros & Cons of Renting vs. Buying</a>
                        </h2>
                        <div class="short-des">
                            <p>
                                Nec in rebum primis causae. Affert
                                iisque ex pri, vis utinam vivendo
                                definitionem ad, nostrum omnes que per
                                et. Omnium antiopam.
                            </p>
                        </div>
                        <div class="button">
                            <a href="post.html" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo">
                        <img src="uploads/blog3.jpg" alt="" />
                    </div>
                    <div class="text">
                        <h2>
                            <a href="post.html">Maximizing Your Investment in 2023</a>
                        </h2>
                        <div class="short-des">
                            <p>
                                Id pri placerat voluptatum, vero dicunt
                                dissentiunt eum et, adhuc iisque vis no.
                                Eu suavitate conten tiones definitionem
                                mel, ex vide.
                            </p>
                        </div>
                        <div class="button">
                            <a href="post.html" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>