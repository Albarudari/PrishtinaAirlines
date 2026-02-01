<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: signin.php");
    exit;
}

require_once __DIR__ . '/M/SiteContentMapper.php';
$mapper = new SiteContentMapper();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_homepage'])) {
    $mapper->saveBatch('homepage', [
        'hero_title' => $_POST['hero_title'] ?? '',
        'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
        'hero_btn_text' => $_POST['hero_btn_text'] ?? '',
        'search_from' => $_POST['search_from'] ?? '',
        'search_to' => $_POST['search_to'] ?? '',
        'offer1_title' => $_POST['offer1_title'] ?? '',
        'offer1_desc' => $_POST['offer1_desc'] ?? '',
        'offer1_badge' => $_POST['offer1_badge'] ?? '',
        'offer1_img' => $_POST['offer1_img'] ?? '',
        'offer2_title' => $_POST['offer2_title'] ?? '',
        'offer2_desc' => $_POST['offer2_desc'] ?? '',
        'offer2_img' => $_POST['offer2_img'] ?? '',
        'offer3_title' => $_POST['offer3_title'] ?? '',
        'offer3_desc' => $_POST['offer3_desc'] ?? '',
        'offer3_img' => $_POST['offer3_img'] ?? '',
        'offer4_title' => $_POST['offer4_title'] ?? '',
        'offer4_desc' => $_POST['offer4_desc'] ?? '',
        'offer4_img' => $_POST['offer4_img'] ?? '',
        'trend1_route' => $_POST['trend1_route'] ?? '',
        'trend1_dates' => $_POST['trend1_dates'] ?? '',
        'trend1_price' => $_POST['trend1_price'] ?? '',
        'trend1_img' => $_POST['trend1_img'] ?? '',
        'trend2_route' => $_POST['trend2_route'] ?? '',
        'trend2_dates' => $_POST['trend2_dates'] ?? '',
        'trend2_price' => $_POST['trend2_price'] ?? '',
        'trend2_img' => $_POST['trend2_img'] ?? '',
        'trend3_route' => $_POST['trend3_route'] ?? '',
        'trend3_dates' => $_POST['trend3_dates'] ?? '',
        'trend3_price' => $_POST['trend3_price'] ?? '',
        'trend3_img' => $_POST['trend3_img'] ?? '',
        'trend4_route' => $_POST['trend4_route'] ?? '',
        'trend4_dates' => $_POST['trend4_dates'] ?? '',
        'trend4_price' => $_POST['trend4_price'] ?? '',
        'trend4_img' => $_POST['trend4_img'] ?? '',
    ]);
    $success = true;
}

$c = $mapper->getAllByPage('homepage');
$get = function($k, $d) use ($c) { return $c[$k] ?? $d; };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Homepage | Admin</title>
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
            <a href="admin_homepage.php" class="active"><i class="fa-solid fa-house"></i> Home Page</a>
            <a href="admin_hotels.php"><i class="fa-solid fa-hotel"></i> Hotels</a>
            <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>
    <main class="main-content">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
            <div class="header-left">
                <h1 style="color: #003366;">Edit Homepage Content</h1>
                <p style="color: #666;">Changes appear on <a href="homepage.php" target="_blank">homepage.php</a></p>
            </div>
            <div class="header-right">
                <a href="homepage.php" target="_blank" class="badge admin" style="background: #003366; color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none;">
                    <i class="fa-solid fa-external-link-alt"></i> View Homepage
                </a>
            </div>
        </header>
        <?php if (isset($success) && $success): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-check-circle"></i> Content saved successfully.
        </div>
        <?php endif; ?>
        <form method="POST" action="admin_homepage.php">
            <input type="hidden" name="save_homepage" value="1">
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-image"></i> Hero Section</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 20px;">
                    <div><label>Hero Title</label><input type="text" name="hero_title" value="<?php echo htmlspecialchars($get('hero_title', 'Fly the Future')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                    <div><label>Hero Subtitle</label><input type="text" name="hero_subtitle" value="<?php echo htmlspecialchars($get('hero_subtitle', 'Your journey begins with us.')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                    <div><label>Hero Button Text</label><input type="text" name="hero_btn_text" value="<?php echo htmlspecialchars($get('hero_btn_text', 'Book a Flight')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-search"></i> Search Box Defaults</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 20px;">
                    <div><label>From (placeholder)</label><input type="text" name="search_from" value="<?php echo htmlspecialchars($get('search_from', 'Prishtina')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                    <div><label>To (placeholder)</label><input type="text" name="search_to" value="<?php echo htmlspecialchars($get('search_to', 'London')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-tags"></i> Top Offers (4 cards)</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 20px;">
                    <?php for ($i = 1; $i <= 4; $i++): $img = $i === 1 ? 'christmas.jpg' : ($i === 2 ? 'businessclass.jpg' : ($i === 3 ? 'bali.jpg' : 'privatejet.jpg')); ?>
                    <div style="grid-column: span 2; padding: 16px; background: #f9f9f9; border-radius: 8px;">
                        <h4>Offer <?php echo $i; ?></h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px;">
                            <div><label>Title</label><input type="text" name="offer<?php echo $i; ?>_title" value="<?php echo htmlspecialchars($get('offer'.$i.'_title', $i === 1 ? 'Special Winter Sale' : ($i === 2 ? 'Business Class Upgrade' : ($i === 3 ? 'New Routes 2025' : 'Book a Private Jet')))); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Image (filename)</label><input type="text" name="offer<?php echo $i; ?>_img" value="<?php echo htmlspecialchars($get('offer'.$i.'_img', $img)); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div style="grid-column: span 2;"><label>Description</label><textarea name="offer<?php echo $i; ?>_desc" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($get('offer'.$i.'_desc', $i === 1 ? 'Save up to 30% on selected winter routes. Travel until 31 Jan 2025.' : ($i === 2 ? 'Enjoy premium seats, lounge access and priority boarding.' : ($i === 3 ? 'Discover new destinations launching in 2025: Bali, Dubai, Tokyo.' : 'Fly on your own schedule with full privacy and comfort.')))); ?></textarea></div>
                            <?php if ($i === 1): ?><div><label>Badge (e.g. -30%)</label><input type="text" name="offer1_badge" value="<?php echo htmlspecialchars($get('offer1_badge', '-30%')); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div><?php endif; ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </section>
            <section class="table-section" style="margin-bottom: 24px;">
                <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-map-location-dot"></i> Trending Destinations (4 cards)</h2>
                <div style="display: grid; gap: 16px; padding: 20px;">
                    <?php 
                    $trends = [
                        1 => ['route' => 'Prishtina (PRN) → New York (JFK)', 'dates' => 'Tue, December 10 – Tue, December 17', 'price' => 'From €699', 'img' => 'newyork.avif'],
                        2 => ['route' => 'Prishtina (PRN) → London (LHR)', 'dates' => 'Thu, December 12 – Thu, December 19', 'price' => 'From €129', 'img' => 'london.avif'],
                        3 => ['route' => 'Prishtina (PRN) → Barcelona (BCN)', 'dates' => 'Fri, December 20 – Fri, December 27', 'price' => 'From €159', 'img' => 'barcelona.webp'],
                        4 => ['route' => 'Prishtina (PRN) → Paris (CDG)', 'dates' => 'Mon, December 16 – Mon, December 23', 'price' => 'From €189', 'img' => 'paris.webp'],
                    ];
                    foreach ($trends as $i => $d): ?>
                    <div style="padding: 16px; background: #f9f9f9; border-radius: 8px;">
                        <h4>Destination <?php echo $i; ?></h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 12px; margin-top: 10px;">
                            <div><label>Route</label><input type="text" name="trend<?php echo $i; ?>_route" value="<?php echo htmlspecialchars($get('trend'.$i.'_route', $d['route'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Dates</label><input type="text" name="trend<?php echo $i; ?>_dates" value="<?php echo htmlspecialchars($get('trend'.$i.'_dates', $d['dates'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Price</label><input type="text" name="trend<?php echo $i; ?>_price" value="<?php echo htmlspecialchars($get('trend'.$i.'_price', $d['price'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                            <div><label>Image</label><input type="text" name="trend<?php echo $i; ?>_img" value="<?php echo htmlspecialchars($get('trend'.$i.'_img', $d['img'])); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <div style="padding: 20px;">
                <button type="submit" class="badge admin" style="border: none; cursor: pointer; padding: 14px 32px; background: #003366; color: #fff; font-size: 16px; border-radius: 8px;">
                    <i class="fa-solid fa-save"></i> Save All Homepage Content
                </button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
