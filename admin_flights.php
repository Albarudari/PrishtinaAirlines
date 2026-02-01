<?php
require_once __DIR__ . '/M/FlightMapper.php';
$flightMapper = new FlightMapper();

if (isset($_POST['add_flight'])) {
    $airline = $_POST['airline'];
    $route = $_POST['route'];
    $time = $_POST['time'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $stops = isset($_POST['stops']) ? (int)$_POST['stops'] : 0;

    $flightMapper->addFlight($airline, $route, $time, $duration, $price, $stops);
    header("Location: admin_flights.php");
}

if (isset($_GET['delete'])) {
    $flightMapper->deleteFlight($_GET['delete']);
    header("Location: admin_flights.php");
}

$flights = $flightMapper->getAllFlights();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Administration | Prishtina Airlines</title>
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
             <a href="admin_flights.php" class="active"><i class="fa-solid fa-plane"></i> Flight Data</a>
             <a href="admin_homepage.php"><i class="fa-solid fa-house"></i> Home Page</a>
             <a href="admin_hotels.php"><i class="fa-solid fa-hotel"></i> Hotels</a>
             <a href="homepage.php" class="back-site"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
            <div class="header-left">
                <h1 style="color: #003366; font-size: 24px;">Flight Management System</h1>
                <p style="color: #666;">Control your airline schedule, pricing, and route details in real-time.</p>
            </div>
            <div class="header-right">
                <span class="badge admin" style="background: #003366; color: white; padding: 8px 15px; border-radius: 20px; font-size: 12px;">
                    <i class="fa-solid fa-shield-halved"></i> Verified Admin
                </span>
            </div>
        </header>
        
        <section class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
            <div class="stat-card">
                <i class="fa-solid fa-plane-departure icon-bg"></i>
                <h3>Total Flights</h3>
                <p><?php echo count($flights); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-route icon-bg"></i>
                <h3>Active Routes</h3>
                <p><?php echo count(array_unique(array_column($flights, 'route'))); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-euro-sign icon-bg"></i>
                <h3>Average Fare</h3>
                <p>€<?php echo (count($flights) > 0) ? round(array_sum(array_column($flights, 'price')) / count($flights)) : 0; ?></p>
            </div>
        </section>

        <section class="table-section" style="margin-bottom: 40px; border-top: 3px solid #003366;">
            <h2 style="padding: 20px 20px 0 20px;"><i class="fa-solid fa-plus-circle"></i> Add New Route</h2>
            <form action="admin_flights.php" method="POST" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; padding: 25px;">
                <input type="text" name="airline" placeholder="Airline Name" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="text" name="route" placeholder="Route (e.g. PRN - LHR)" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="time" name="time" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="text" name="duration" placeholder="Duration (e.g. 2h 30m)" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="number" step="0.01" name="price" placeholder="Price in EUR" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                <div style="display: flex; align-items: center; gap: 10px; background: #f9f9f9; padding: 10px; border-radius: 4px;">
                    <label for="stops" style="font-weight: 600; color: #444;">Stops:</label>
                    <select name="stops" id="stops" style="padding: 10px 14px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        <option value="0">Direct</option>
                        <option value="1">1 stop</option>
                        <option value="2">2+ stops</option>
                    </select>
                </div>

                <button type="submit" name="add_flight" class="badge admin" style="grid-column: span 3; border: none; cursor: pointer; height: 45px; background: #003366; color: #fff; font-size: 16px; transition: 0.3s;">
                    Save Flight to Database
                </button>
            </form>
        </section>

        <section class="table-section">
            <div class="table-header" style="padding: 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0;">Live Flight Records</h2>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Airline</th>
                        <th>Route</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($flights as $f): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($f['airline']); ?></strong></td>
                        <td><?php echo htmlspecialchars($f['route']); ?></td>
                        <td>
                            <?php
                            $s = isset($f['stops']) ? (int)$f['stops'] : (isset($f['is_direct']) && $f['is_direct'] ? 0 : 1);
                            $label = $s === 0 ? 'Direct' : ($s === 1 ? '1 stop' : '2+ stops');
                            $bg = $s === 0 ? '#e1f5fe' : ($s === 1 ? '#fff3e0' : '#ffebee');
                            $clr = $s === 0 ? '#01579b' : ($s === 1 ? '#ef6c00' : '#c62828');
                            ?>
                            <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; background: <?php echo $bg; ?>; color: <?php echo $clr; ?>;">
                                <?php echo htmlspecialchars($label); ?>
                            </span>
                        </td>
                        <td>€<?php echo htmlspecialchars($f['price']); ?></td>
                        <td>
                            <a href="admin_flights.php?delete=<?php echo $f['id']; ?>" class="btn-delete" style="color: #ff5252;" onclick="return confirm('Archive this flight?')">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>