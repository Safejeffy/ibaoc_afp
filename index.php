<?php
// index.php — minimal database connection only
// Session is started in case other scripts rely on session data.
session_start();

// Database credentials — adjust if your environment uses different values.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aircon_inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure UTF-8
$conn->set_charset("utf8mb4");

// Export $conn for included scripts
// (Other pages can include/require 'index.php' to reuse this connection.)
?>

<?php
// Redirect logic: if user is logged in -> dashboard (by role), else -> login
// We check for the presence of 'user_id' in the session which is set on login.
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'] ?? '';
    if ($role === 'admin') {
        header('Location: aircon_inventory/dashboard.php');
        exit;
    } elseif ($role === 'staff') {
        header('Location: aircon_inventory/staff_dashboard.php');
        exit;
    } else {
        // Unknown role — send to login to be safe
        header('Location: aircon_inventory/login.php');
        exit;
    }
} else {
    // Not logged in — redirect to login page
    header('Location: aircon_inventory/login.php');
    exit;
}
