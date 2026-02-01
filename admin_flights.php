<?php
session_start();
require_once __DIR__ . '/M/FlightMapper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$flightMapper = new FlightMapper();
$current_admin_id = $_SESSION['user_id']; 

if (isset($_POST['add_flight'])) {
    if(!empty($_POST['airline']) && !empty($_POST['route']) && !empty($_POST['price'])) {
        $airline = $_POST['airline'];
        $route = $_POST['route'];
        $time = $_POST['time'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $stops = isset($_POST['stops']) ? (int)$_POST['stops'] : 0;

        $flightMapper->addFlight($airline, $route, $time, $duration, $price, $stops, $current_admin_id);
        header("Location: admin_flights.php?success=1");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $flightMapper->deleteFlight($_GET['delete']);
    header("Location: admin_flights.php?deleted=1");
    exit();
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
    <style>
        .admin-table tbody tr:hover { background-color: #fcfcfc; }
        .btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
        .stat-card { position: relative; overflow: hidden; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .icon-bg { opacity: 0.1; position: absolute; right: 10px; bottom: 10px; font-size: 40px; color: #003366; }
        .admin-name-tag { color: #003366; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 5px; }
        .badge.admin { background: #003366; color: white; padding: 8px 15px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>

<div class="admin-container" style="display: flex; min-height: 100vh;">
    <aside class="sidebar" style="width: 250px; background: #003366; color: white; padding: 20px;">
        <div class="logo" style="font-size: 20px; font-weight: bold; margin-bottom: 30px;">✈ Admin Panel</div>
        <nav class="side-nav" style="display: flex; flex-direction: column; gap: 15px;">
             <a href="admin_dashboard.php" style="color: white; text-decoration: none;"><i class="fa-solid fa-users"></i> Registered Users</a>
             <a href="admin_messages.php" style="color: white; text-decoration: none;"><i class="fa-solid fa-envelope"></i> Messages</a>
             <a href="admin_flights.php" class="active" style="color: #ffcc00; text-decoration: none;"><i class="fa-solid fa-plane"></i> Flight Data</a>
             <a href="admin_homepage.php" style="color: white; text-decoration: none;"><i class="fa-solid fa-house"></i> Home Page</a>
             <a href="homepage.php" class="back-site" style="margin-top: 20px; color: #ccc; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
        </nav>
    </aside>

    <main class="main-content" style="flex-grow: 1; padding: 30px; background: #f4f7f6;">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="color: #003366; margin: 0;">Flight Management</h1>
                <p style="color: #666;">Logged in as: <strong><?php echo $_SESSION['user_name'] ?? 'Admin'; ?></strong></p>
            </div>
            <span class="badge admin">
                <i class="fa-solid fa-shield-halved"></i> Verified Admin
            </span>
        </header>
        
        <section class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
            <div class="stat-card">
                <i class="fa-solid fa-plane-departure icon-bg"></i>
                <h3>Total Flights</h3>
                <p style="font-size: 24px; font-weight: bold;"><?php echo count($flights); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-route icon-bg"></i>
                <h3>Active Routes</h3>
                <p style="font-size: 24px; font-weight: bold;"><?php echo count(array_unique(array_column($flights, 'route'))); ?></p>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-euro-sign icon-bg"></i>
                <h3>Average Price</h3>
                <p style="font-size: 24px; font-weight: bold;">€<?php echo (count($flights) > 0) ? round(array_sum(array_column($flights, 'price')) / count($flights)) : 0; ?></p>
            </div>
        </section>

        <section class="table-section" style="background: #fff; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-top: 4px solid #003366;">
            <h2><i class="fa-solid fa-plus-circle"></i> Add New Flight</h2>
            <form action="admin_flights.php" method="POST" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 20px;">
                <input type="text" name="airline" placeholder="Airline Name" required style="padding: 10px; border: 1px solid #ddd;">
                <input type="text" name="route" placeholder="Route (e.g. PRN-IST)" required style="padding: 10px; border: 1px solid #ddd;">
                <input type="time" name="time" required style="padding: 10px; border: 1px solid #ddd;">
                <input type="text" name="duration" placeholder="Duration" required style="padding: 10px; border: 1px solid #ddd;">
                <input type="number" step="0.01" name="price" placeholder="Price €" required style="padding: 10px; border: 1px solid #ddd;">
                <select name="stops" style="padding: 10px; border: 1px solid #ddd;">
                    <option value="0">Direct</option>
                    <option value="1">1 Stop</option>
                    <option value="2">2+ Stops</option>
                </select>
                <button type="submit" name="add_flight" class="btn-save" style="grid-column: span 3; background: #003366; color: white; border: none; padding: 12px; cursor: pointer; font-weight: bold;">
                    SAVE FLIGHT
                </button>
            </form>
        </section>

        <section style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">Airline</th>
                        <th style="padding: 15px; text-align: left;">Route</th>
                        <th style="padding: 15px; text-align: left;">Price</th>
                        <th style="padding: 15px; text-align: left;">Added By</th> <th style="padding: 15px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($flights as $f): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;"><strong><?php echo htmlspecialchars($f['airline']); ?></strong></td>
                        <td style="padding: 15px;"><?php echo htmlspecialchars($f['route']); ?></td>
                        <td style="padding: 15px; color: #28a745; font-weight: bold;">€<?php echo $f['price']; ?></td>
                        <td style="padding: 15px;">
                            <span class="admin-name-tag">
                                <i class="fa-solid fa-user-check"></i> 
                                <?php echo htmlspecialchars($f['admin_name'] ?? 'System'); ?>
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="admin_flights.php?delete=<?php echo $f['id']; ?>" style="color: #dc3545;" onclick="return confirm('Delete this flight?')">
                                <i class="fa-solid fa-trash"></i>
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