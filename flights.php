<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$showAdminButton = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');


require_once __DIR__ . '/M/FlightMapper.php';
$flightMapper = new FlightMapper();
$allFlights = $flightMapper->getAllFlights();
function getStopLabel($f) {
    $s = isset($f['stops']) ? (int)$f['stops'] : (isset($f['is_direct']) && $f['is_direct'] ? 0 : 1);
    return $s === 0 ? 'Direct' : ($s === 1 ? '1 stop' : '2+ stops');
}
function getStopValue($f) {
    return isset($f['stops']) ? (int)$f['stops'] : (isset($f['is_direct']) && $f['is_direct'] ? 0 : 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prishtina Airlines – Flights</title>
  <link rel="stylesheet" href="flights.css?v=3">
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
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .admin-button:hover { background-color: #085a98 !important; }
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
<div class="summary-bar-bg">
  <div class="summary-bar">
    <div class="summary-search"><i class="fa-solid fa-magnifying-glass"></i></div>
    <div class="summary-route-wide" onclick="editRoute()">
      <span id="route-text">Pristina (PRN) – Munich (MUC)</span> · <span id="passenger-text">1 adult, 0 children</span>
    </div>
    <div class="summary-dates">
      <button class="date-btn" onclick="changeDate(-1, 'depart')"><i class="fa-solid fa-chevron-left"></i></button>
      <span id="depart-date">Sat, 20 Dec</span>
      <button class="date-btn" onclick="changeDate(1, 'depart')"><i class="fa-solid fa-chevron-right"></i></button>
      <span class="dot">•</span>
      <button class="date-btn" onclick="changeDate(-1, 'return')"><i class="fa-solid fa-chevron-left"></i></button>
      <span id="return-date">Wed, 28 Jan</span>
      <button class="date-btn" onclick="changeDate(1, 'return')"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</div>
<div class="flights-container">
<aside class="sidebar-filters">
  <div class="filter-section">
    <h4>Stops</h4>
    <?php
    $directFlights = array_filter($allFlights, function($f) { return getStopValue($f) === 0; });
    $oneStopFlights = array_filter($allFlights, function($f) { return getStopValue($f) === 1; });
    $twoPlusFlights = array_filter($allFlights, function($f) { return getStopValue($f) >= 2; });
    ?>
    <div class="stop-option"><label><input type="checkbox" name="stop_filter" value="0" checked> Direct</label><span class="stop-price"><?php echo count($directFlights) ? 'from €' . min(array_map(function($f) { return (float)($f['price'] ?? 999); }, $directFlights)) : '-'; ?></span></div>
    <div class="stop-option"><label><input type="checkbox" name="stop_filter" value="1"> 1 stop</label><span class="stop-price"><?php echo count($oneStopFlights) ? 'from €' . min(array_map(function($f) { return (float)($f['price'] ?? 999); }, $oneStopFlights)) : '-'; ?></span></div>
    <div class="stop-option"><label><input type="checkbox" name="stop_filter" value="2"> 2+ stops</label><span class="stop-price"><?php echo count($twoPlusFlights) ? 'from €' . min(array_map(function($f) { return (float)($f['price'] ?? 999); }, $twoPlusFlights)) : '-'; ?></span></div>
  </div>
  <div class="filter-section">
    <div class="baggage-header"><h4>Baggage</h4><button class="select-all">Select all</button></div>
    <div class="baggage-option"><label><input type="checkbox"> Cabin bag</label></div>
    <div class="baggage-option"><label><input type="checkbox"> Checked bag</label></div>
  </div>
  <div class="filter-section">
    <h4>Departure times</h4>
    <div class="departure-times">
      <div class="time-range"><h5>Outbound</h5><span>00:00 - 12:00</span><input type="range" min="0" max="23" value="6"></div>
      <div class="time-range"><h5>Return</h5><span>00:00 - 23:59</span><input type="range" min="0" max="23" value="12"></div>
    </div>
  </div>
  <div class="filter-section">
    <h4>Journey duration</h4>
    <div class="duration-range">
      <div class="duration-labels"><span>2.0 hours</span><span>32.0 hours</span></div>
      <input type="range" min="2" max="32" value="8" step="0.1">
      <div class="duration-value">8.0 hours</div>
    </div>
  </div>
  <div class="filter-section hotel-box">
    <h3>Found flights?</h3>
    <p>Now find a hotel for your stay.</p>
    <a href="hotels.php" class="hotel-btn">Explore hotels</a>
  </div>
</aside>
<main class="flights-main">
  <h2>Available Flights</h2>
  <?php if (empty($allFlights)): ?>
    <div class="flight-card flight-card--empty">
      <p>No flights available for this route currently.</p>
    </div>
  <?php else: ?>
    <?php foreach ($allFlights as $flight):
      $stopVal = getStopValue($flight);
      $stopLabel = getStopLabel($flight);
    ?>
    <div class="flight-card" data-stops="<?php echo $stopVal; ?>">
      <div class="flight-left">
        <div class="airline"><?php echo htmlspecialchars($flight['airline']); ?></div>
        <div class="time"><?php echo htmlspecialchars($flight['flight_time']); ?></div>
      </div>
      <div class="flight-center">
        <div class="route"><?php echo htmlspecialchars($flight['route']); ?></div>
        <div class="duration-container">
          <span class="duration"><?php echo htmlspecialchars($flight['duration']); ?></span>
          <span class="direct"><?php echo htmlspecialchars($stopLabel); ?></span>
        </div>
      </div>
      <div class="flight-right">
        <div class="price-container">
          <span class="price">€<?php echo htmlspecialchars($flight['price']); ?></span>
          <span class="price-label">per person</span>
        </div>
        <button type="button" class="select-btn">Select →</button>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>
</div>
<section id="about" class="about-airline">
    <div class="about-container">
        <h2>About Prishtina Airlines</h2>
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
<footer class="airline-footer">
    © 2026 Prishtina Airlines. All rights reserved.
</footer>
<script src="flights.js"></script>
</body>
</html>