<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$showAdminButton = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');

require_once __DIR__ . '/M/SiteContentMapper.php';
$content = new SiteContentMapper();
$h = function($k, $d) use ($content) { return $content->get('hotels', $k, $d); };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($h('page_title', 'London Hotels')); ?></title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="hotels.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .admin-button {
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            background-color: #2ab3d5 !important;
            color: white !important;
            padding: 12px 20px !important;
            border-radius: 50px !important;
            text-decoration: none !important;
            font-weight: bold !important;
            z-index: 999999 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            font-family: sans-serif;
        }
        .admin-button:hover {
            background-color: #085a98 !important;
        }
    </style>
</head>

<body>

    <?php if ($showAdminButton): ?>
        <a href="admin_dashboard.php" class="admin-button">
            <i class="fa-solid fa-user-shield"></i> Admin Panel
        </a>
    <?php endif; ?>

   <nav class="navbar">
    <div class="logo">✈ Prishtina Airlines</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="flights.php">Flights</a></li>
        <li><a href="hotels.php">Hotels</a></li>
        <li><a href="contactform.php">Contact</a></li>
        <li><a class="signin-btn" href="signin.php">Sign In</a></li>
    </ul>
</nav>

    <section class="hero">
        <div class="flight-box">
            <div class="trip-options">
                <label>
                    <input type="radio" name="trip" value="round" checked onclick="toggleReturn()">
                    Round Trip
                </label>
                <label>
                    <input type="radio" name="trip" value="oneway" onclick="toggleReturn()">
                    One Way
                </label>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label>From</label>
                    <input type="text" placeholder="Prishtina" value="Prishtina">
                </div>

                <div class="input-group">
                    <label>To</label>
                    <input type="text" placeholder="London" value="London">
                </div>

                <div class="input-group">
                    <label>Depart</label>
                    <input type="date">
                </div>

                <div class="input-group" id="returnBox">
                    <label>Return</label>
                    <input type="date">
                </div>

                <a href="flights.html" class="search-btn">Search ✈</a>
            </div>
        </div>
    </section>

    <main class="container" id="hotels" role="main">

        <section class="property-types">
            <h2 class="title"><?php echo htmlspecialchars($h('section_property', 'Browse by property type')); ?></h2>
            <div class="property-grid">
                <div class="property-card">
                    <img src="images/hotels.jpg" alt="Hotels">
                    <h3>Hotels</h3>
                </div>
                <div class="property-card">
                    <img src="images/apartments.jpg" alt="Apartments">
                    <h3>Apartments</h3>
                </div>
                <div class="property-card">
                    <img src="images/resorts.jpg" alt="Resorts">
                    <h3>Resorts</h3>
                </div>
                <div class="property-card">
                    <img src="images/villas.jpg" alt="Villas">
                    <h3>Villas</h3>
                </div>
            </div>
        </section>

        <h2 class="title"><?php echo htmlspecialchars($h('section_trending', 'Top 5 Trending Hotels in Central London')); ?></h2>

        <section class="carousel" aria-label="Trending hotels carousel">
            <div class="carousel-track">
                
                <article class="hotel-card">
                    <div class="image-box">
                        <img alt="<?php echo htmlspecialchars($h('hotel1_name', 'Rest Up London – Hostel')); ?>" src="<?php echo htmlspecialchars($h('hotel1_img', 'images/hotel1.jpg')); ?>">
                    </div>
                    <div class="info-box">
                        <h3><?php echo htmlspecialchars($h('hotel1_name', 'Rest Up London – Hostel')); ?></h3>
                        <div class="rating">
                            <span class="stars"><?php echo htmlspecialchars($h('hotel1_stars', '★★★☆☆')); ?></span>
                            <span class="reviews"><?php echo htmlspecialchars($h('hotel1_reviews', 'Very Good · 8.4')); ?></span>
                        </div>
                        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($h('hotel1_location', '2.9 km from City Centre')); ?></p>
                        <div class="tags">
                            <?php foreach (array_map('trim', explode(',', $h('hotel1_tags', 'Free WiFi, Prime Discount'))) as $tag): ?><?php if ($tag): ?><span><?php echo htmlspecialchars($tag); ?></span><?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span class="old-price">€<?php echo htmlspecialchars($h('hotel1_old_price', '436.17')); ?></span>
                        <span class="new-price">€<?php echo htmlspecialchars($h('hotel1_new_price', '342.04')); ?></span>
                        <button>Select</button>
                    </div>
                </article>

                <article class="hotel-card">
                    <div class="image-box">
                        <img alt="<?php echo htmlspecialchars($h('hotel2_name', 'Central London Urban Hotel')); ?>" src="<?php echo htmlspecialchars($h('hotel2_img', 'images/hotel2.jpg')); ?>">
                    </div>
                    <div class="info-box">
                        <h3><?php echo htmlspecialchars($h('hotel2_name', 'Central London Urban Hotel')); ?></h3>
                        <div class="rating">
                            <span class="stars"><?php echo htmlspecialchars($h('hotel2_stars', '★★★★☆')); ?></span>
                            <span class="reviews"><?php echo htmlspecialchars($h('hotel2_reviews', 'Excellent · 9.1')); ?></span>
                        </div>
                        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($h('hotel2_location', '1.2 km from City Centre')); ?></p>
                        <div class="tags">
                            <?php foreach (array_map('trim', explode(',', $h('hotel2_tags', 'Free Breakfast, City View'))) as $tag): ?><?php if ($tag): ?><span><?php echo htmlspecialchars($tag); ?></span><?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span class="old-price">€<?php echo htmlspecialchars($h('hotel2_old_price', '289.00')); ?></span>
                        <span class="new-price">€<?php echo htmlspecialchars($h('hotel2_new_price', '219.00')); ?></span>
                        <button>Select</button>
                    </div>
                </article>

                <article class="hotel-card">
                    <div class="image-box">
                        <img alt="<?php echo htmlspecialchars($h('hotel3_name', 'Oxford Street Luxury Rooms')); ?>" src="<?php echo htmlspecialchars($h('hotel3_img', 'images/hotel3.jpg')); ?>">
                    </div>
                    <div class="info-box">
                        <h3><?php echo htmlspecialchars($h('hotel3_name', 'Oxford Street Luxury Rooms')); ?></h3>
                        <div class="rating">
                            <span class="stars"><?php echo htmlspecialchars($h('hotel3_stars', '★★★★☆')); ?></span>
                            <span class="reviews"><?php echo htmlspecialchars($h('hotel3_reviews', 'Fantastic · 9.0')); ?></span>
                        </div>
                        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($h('hotel3_location', '300m from Oxford Street')); ?></p>
                        <div class="tags">
                            <?php foreach (array_map('trim', explode(',', $h('hotel3_tags', 'Shopping Area, Free WiFi'))) as $tag): ?><?php if ($tag): ?><span><?php echo htmlspecialchars($tag); ?></span><?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span class="old-price">€<?php echo htmlspecialchars($h('hotel3_old_price', '350.00')); ?></span>
                        <span class="new-price">€<?php echo htmlspecialchars($h('hotel3_new_price', '279.00')); ?></span>
                        <button>Select</button>
                    </div>
                </article>

                <article class="hotel-card">
                    <div class="image-box">
                        <img alt="<?php echo htmlspecialchars($h('hotel4_name', 'Kensington Palace Hotel')); ?>" src="<?php echo htmlspecialchars($h('hotel4_img', 'images/hotel4.jpg')); ?>">
                    </div>
                    <div class="info-box">
                        <h3><?php echo htmlspecialchars($h('hotel4_name', 'Kensington Palace Hotel')); ?></h3>
                        <div class="rating">
                            <span class="stars"><?php echo htmlspecialchars($h('hotel4_stars', '★★★★★')); ?></span>
                            <span class="reviews"><?php echo htmlspecialchars($h('hotel4_reviews', 'Exceptional · 9.5')); ?></span>
                        </div>
                        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($h('hotel4_location', '5 min from Hyde Park')); ?></p>
                        <div class="tags">
                            <?php foreach (array_map('trim', explode(',', $h('hotel4_tags', 'Premium, Spa & Wellness'))) as $tag): ?><?php if ($tag): ?><span><?php echo htmlspecialchars($tag); ?></span><?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span class="old-price">€<?php echo htmlspecialchars($h('hotel4_old_price', '410.00')); ?></span>
                        <span class="new-price">€<?php echo htmlspecialchars($h('hotel4_new_price', '329.00')); ?></span>
                        <button>Select</button>
                    </div>
                </article>

                <article class="hotel-card">
                    <div class="image-box">
                        <img alt="<?php echo htmlspecialchars($h('hotel5_name', 'Soho Boutique Hotel')); ?>" src="<?php echo htmlspecialchars($h('hotel5_img', 'images/hotel5.jpg')); ?>">
                    </div>
                    <div class="info-box">
                        <h3><?php echo htmlspecialchars($h('hotel5_name', 'Soho Boutique Hotel')); ?></h3>
                        <div class="rating">
                            <span class="stars"><?php echo htmlspecialchars($h('hotel5_stars', '★★★★☆')); ?></span>
                            <span class="reviews"><?php echo htmlspecialchars($h('hotel5_reviews', 'Excellent · 8.9')); ?></span>
                        </div>
                        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($h('hotel5_location', 'Located in the heart of Soho')); ?></p>
                        <div class="tags">
                            <?php foreach (array_map('trim', explode(',', $h('hotel5_tags', 'Nightlife, Modern Design'))) as $tag): ?><?php if ($tag): ?><span><?php echo htmlspecialchars($tag); ?></span><?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span class="old-price">€<?php echo htmlspecialchars($h('hotel5_old_price', '299.00')); ?></span>
                        <span class="new-price">€<?php echo htmlspecialchars($h('hotel5_new_price', '239.00')); ?></span>
                        <button>Select</button>
                    </div>
                </article>
            </div>

            <button class="carousel-arrow prev" aria-label="Previous">&lsaquo;</button>
            <button class="carousel-arrow next" aria-label="Next">&rsaquo;</button>

        </section>

        <section class="explore-london">
            <h2 class="explore-title">Explore more</h2>
            <div class="explore-grid">
                <div class="explore-card">
                    <img src="images/explore1.jpg" alt="How to get cheaper hotels: five hacks to save big">
                    <div class="explore-card-content">
                        <h3>The Hotel Savings Guide</h3>
                        <div class="explore-meta">5 July 2026</div>
                    </div>
                </div>
                <div class="explore-card">
                    <img src="images/explore2.jpg" alt="7 of the world's best foodie hotels">
                    <div class="explore-card-content">
                        <h3>Culinary Hotel Havens</h3>
                        <div class="explore-meta">7 December 2026</div>
                    </div>
                </div>
                <div class="explore-card">
                    <img src="images/explore3.jpg" alt="What to do if your hotel booking is cancelled">
                    <div class="explore-card-content">
                        <h3>Hotel Bailout Guide</h3>
                        <div class="explore-meta">8 April 2026</div>
                    </div>
                </div>
                <div class="explore-card">
                    <img src="images/explore4.jpg" alt="Sleeping with the fishes: The world's best underwater hotels">
                    <div class="explore-card-content">
                        <h3>Hotels Beneath the Waves</h3>
                        <div class="explore-meta">1 April 2026</div>
                    </div>
                </div>
            </div>

            <div class="explore-options">
                <h3>More travel options</h3>
                <div class="explore-filters">
                    <button class="explore-pill active">Leading tourist nations</button>
                    <button class="explore-pill">Most-visited countries</button>
                    <button class="explore-pill">Top destinations by country</button>
                    <button class="explore-pill">Premier national getaways</button>
                    <button class="explore-pill">Global travel hotspots</button>
                </div>
                <div class="explore-links">
                    <div>
                        <a href="#">Looking for cheap hotels in Manchester?</a><br>
                        <a href="#">Need hotel deals in Milan?</a><br>
                        <a href="#">Finding affordable hotels in New Delhi?</a>
                    </div>
                    <div>
                        <a href="#">Seeking budget hotels in Dublin?</a><br>
                        <a href="#">Want cheap accommodation in Marrakech?</a><br>
                        <a href="#">Searching for Barcelona hotel discounts?</a>
                    </div>
                    <div>
                        <a href="#">Looking for Faro budget stays?</a><br>
                        <a href="#">Need affordable New York hotels?</a><br>
                        <a href="#">Finding Valletta cheap lodging?</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="feature">
                <div class="feature-icon">%</div>
                <h4><?php echo htmlspecialchars($h('feat1_title', 'Great hotel deals')); ?></h4>
                <p><?php echo htmlspecialchars($h('feat1_text', 'We search our partners to find the best deal for you.')); ?></p>
            </div>
            <div class="feature">
                <div class="feature-icon">🪄</div>
                <h4><?php echo htmlspecialchars($h('feat2_title', 'Up-to-date pricing')); ?></h4>
                <p><?php echo htmlspecialchars($h('feat2_text', 'Real-time pricing so you know what you\'ll pay.')); ?></p>
            </div>
            <div class="feature">
                <div class="feature-icon">⚖️</div>
                <h4><?php echo htmlspecialchars($h('feat3_title', 'Precise searching')); ?></h4>
                <p><?php echo htmlspecialchars($h('feat3_text', 'Filters for reviews, location and cancellation policy.')); ?></p>
            </div>
        </section>

    </main>

    <section id="about" class="about-airline">
        <div class="about-container">
            <h2>About Prishtina Airlines</h2>
            <br>
            <p class="about-desc">
                Prishtina Airlines is a modern airline focused on providing safe,
                affordable and comfortable flights across Europe and beyond.
                Our mission is to connect people with world-class service and
                reliable travel experiences.
            </p>
            <div class="about-info">
                <div class="about-box">
                    <h4>Locations</h4>
                    <p>Prishtina International Airport, Kosovo</p>
                    <p>Prishtina Mall, Prishtina</p>
                    <p>Dukagjini Center, Prishtina</p>
                </div>
                <div class="about-box">
                    <h4>Call Center</h4>
                    <p>+383 44 123 456</p>
                    <p>+383 45 234 567</p>
                    <p>+383 49 345 678</p>
                    <span>Working hours: 08:00 – 00:00</span>
                </div>
                <div class="about-box">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <p>Facebook: Prishtina Airlines</p>
                        <p>Instagram: prishtinaairlines</p>
                        <p>Twitter: prishtinaairlines</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function() {
            const nav = document.querySelector('.navbar');
            const navHeight = nav.offsetHeight;
            
            document.documentElement.style.setProperty('--nav-height-js', navHeight + 'px');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) nav.classList.add('scrolled');
                else nav.classList.remove('scrolled');
            });

            const track = document.querySelector('.carousel-track');
            const prev = document.querySelector('.carousel-arrow.prev');
            const next = document.querySelector('.carousel-arrow.next');
            if (track && prev && next) {
                const scrollAmount = 520;
                prev.addEventListener('click', () => track.scrollBy({left: -scrollAmount, behavior: 'smooth'}));
                next.addEventListener('click', () => track.scrollBy({left: scrollAmount, behavior: 'smooth'}));
            }
        })();
    </script>

<footer class="airline-footer">
    © 2026 Prishtina Airlines. All rights reserved.
</footer>

</body>
</html>