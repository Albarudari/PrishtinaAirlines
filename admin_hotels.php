<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: signin.php");
    exit;
}

require_once __DIR__ . '/M/SiteContentMapper.php';
$mapper = new SiteContentMapper();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_hotels'])) {
    $data = [];
    foreach ($_POST as $k => $v) {
        if ($k !== 'save_hotels' && is_string($v)) $data[$k] = $v;
    }
    $mapper->saveBatch('hotels', $data);
    $success = true;
}

$c = $mapper->getAllByPage('hotels');
$get = function($k, $d) use ($c) { return $c[$k] ?? $d; };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Hotels | Admin</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="admin-container">
    <aside class="sidebar">
        <div class="logo">✈ Admin Panel</div>
        <nav class="side-nav">
            <a href="admin_dashboard.php"><i class="fa-solid fa-users"></i> Registered Users</a>
            <a href="admin_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a>
            <a href="admin_flights.php"><i class="fa-solid fa-plane"></i> Flight Data</a>
            <a href="admin_homepage.php"><i class="fa-solid fa-house"></i> Home Page</a>
            <a href="admin_hotels.php" class="active"><i class="fa-solid fa-hotel"></i> Hotels</a>
            <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>
    <main class="main-content">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
            <div class="header-left">
                <h1 style="color: #003366;">Edit Hotels Page Content</h1>
                <p style="color: #666;">Changes appear on <a href="hotels.php" target="_blank">hotels.php</a></p>
            </div>
            <div class="header-right">
                <a href="hotels.php" target="_blank" class="badge admin" style="background: #003366; color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none;">
                    <i class="fa-solid fa-external-link-alt"></i> View Hotels
                </a>
            </div>
        </header>
        <?php if (isset($success) && $success): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-check-circle"></i> Content saved successfully.
        </div>
        <?php endif; ?>
        <form method="POST" action="admin_hotels.php">
            <input type="hidden" name="save_hotels" value="1">
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-heading"></i> Page Header</h2>
                <div style="padding: 20px;">
                    <div style="max-width: 400px;"><label>Page Title</label><input type="text" name="page_title" value="<?php echo htmlspecialchars($get('page_title', 'London Hotels')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-hotel"></i> Trending Hotels (5 cards)</h2>
                <div style="padding: 20px;">
                    <?php
                    $hotels = [
                        1 => ['name' => 'Rest Up London – Hostel', 'stars' => '★★★☆☆', 'reviews' => 'Very Good · 8.4', 'location' => '2.9 km from City Centre', 'tags' => 'Free WiFi, Prime Discount', 'old' => '436.17', 'new' => '342.04', 'img' => 'images/hotel1.jpg'],
                        2 => ['name' => 'Central London Urban Hotel', 'stars' => '★★★★☆', 'reviews' => 'Excellent · 9.1', 'location' => '1.2 km from City Centre', 'tags' => 'Free Breakfast, City View', 'old' => '289.00', 'new' => '219.00', 'img' => 'images/hotel2.jpg'],
                        3 => ['name' => 'Oxford Street Luxury Rooms', 'stars' => '★★★★☆', 'reviews' => 'Fantastic · 9.0', 'location' => '300m from Oxford Street', 'tags' => 'Shopping Area, Free WiFi', 'old' => '350.00', 'new' => '279.00', 'img' => 'images/hotel3.jpg'],
                        4 => ['name' => 'Kensington Palace Hotel', 'stars' => '★★★★★', 'reviews' => 'Exceptional · 9.5', 'location' => '5 min from Hyde Park', 'tags' => 'Premium, Spa & Wellness', 'old' => '410.00', 'new' => '329.00', 'img' => 'images/hotel4.jpg'],
                        5 => ['name' => 'Soho Boutique Hotel', 'stars' => '★★★★☆', 'reviews' => 'Excellent · 8.9', 'location' => 'Located in the heart of Soho', 'tags' => 'Nightlife, Modern Design', 'old' => '299.00', 'new' => '239.00', 'img' => 'images/hotel5.jpg'],
                    ];
                    foreach ($hotels as $i => $h): ?>
                    <div style="padding: 20px; background: #f9f9f9; border-radius: 8px; margin-bottom: 16px;">
                        <h4>Hotel <?php echo $i; ?></h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 12px;">
                            <div><label>Name</label><input type="text" name="hotel<?php echo $i; ?>_name" value="<?php echo htmlspecialchars($get('hotel'.$i.'_name', $h['name'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Image</label><input type="text" name="hotel<?php echo $i; ?>_img" value="<?php echo htmlspecialchars($get('hotel'.$i.'_img', $h['img'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Stars (e.g. ★★★★☆)</label><input type="text" name="hotel<?php echo $i; ?>_stars" value="<?php echo htmlspecialchars($get('hotel'.$i.'_stars', $h['stars'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Reviews</label><input type="text" name="hotel<?php echo $i; ?>_reviews" value="<?php echo htmlspecialchars($get('hotel'.$i.'_reviews', $h['reviews'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div style="grid-column: span 2;"><label>Location</label><input type="text" name="hotel<?php echo $i; ?>_location" value="<?php echo htmlspecialchars($get('hotel'.$i.'_location', $h['location'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Tags (comma-separated)</label><input type="text" name="hotel<?php echo $i; ?>_tags" value="<?php echo htmlspecialchars($get('hotel'.$i.'_tags', $h['tags'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Old Price (€)</label><input type="text" name="hotel<?php echo $i; ?>_old_price" value="<?php echo htmlspecialchars($get('hotel'.$i.'_old_price', $h['old'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>New Price (€)</label><input type="text" name="hotel<?php echo $i; ?>_new_price" value="<?php echo htmlspecialchars($get('hotel'.$i.'_new_price', $h['new'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-list"></i> Section Titles</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 20px;">
                    <div><label>Browse by property type</label><input type="text" name="section_property" value="<?php echo htmlspecialchars($get('section_property', 'Browse by property type')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                    <div><label>Trending hotels title</label><input type="text" name="section_trending" value="<?php echo htmlspecialchars($get('section_trending', 'Top 5 Trending Hotels in Central London')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-magic"></i> Features (3 boxes)</h2>
                <div style="display: grid; gap: 16px; padding: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;"><div><label>Feature 1 Title</label><input type="text" name="feat1_title" value="<?php echo htmlspecialchars($get('feat1_title', 'Great hotel deals')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div><div><label>Feature 1 Text</label><input type="text" name="feat1_text" value="<?php echo htmlspecialchars($get('feat1_text', 'We search our partners to find the best deal for you.')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div></div>
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;"><div><label>Feature 2 Title</label><input type="text" name="feat2_title" value="<?php echo htmlspecialchars($get('feat2_title', 'Up-to-date pricing')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div><div><label>Feature 2 Text</label><input type="text" name="feat2_text" value="<?php echo htmlspecialchars($get('feat2_text', 'Real-time pricing so you know what you\'ll pay.')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div></div>
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;"><div><label>Feature 3 Title</label><input type="text" name="feat3_title" value="<?php echo htmlspecialchars($get('feat3_title', 'Precise searching')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div><div><label>Feature 3 Text</label><input type="text" name="feat3_text" value="<?php echo htmlspecialchars($get('feat3_text', 'Filters for reviews, location and cancellation policy.')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div></div>
                </div>
            </section>
            <div style="padding: 20px;">
                <button type="submit" class="badge admin" style="border: none; cursor: pointer; padding: 14px 32px; background: #003366; color: #fff; font-size: 16px; border-radius: 8px;">
                    <i class="fa-solid fa-save"></i> Save All Hotels Content
                </button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
