<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// Database connection
$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "moffatbay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available room types from the Rooms table
$sql = "SELECT room_id, room_category, room_type, available_rooms FROM Rooms WHERE available_rooms > 0";
$result = mysqli_query($conn, $sql);

// Handle reservation submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $room_id = $_POST['room_id'];
    $notes = $_POST['notes'];
    
    // Set the current date as the reservation date
    $reservation_date = date("Y-m-d");

    // Default values for status and payment_status
    $status = 'Pending';
    $payment_status = 'Unpaid';

    // Insert the reservation into the Reservations table
    $sql = "INSERT INTO Reservations (user_id, reservation_date, start_date, end_date, status, payment_status, room_id, notes)
            VALUES ('$user_id', '$reservation_date', '$start_date', '$end_date', '$status', '$payment_status', '$room_id', '$notes')";
    
    if (mysqli_query($conn, $sql)) {
        // If the reservation is successful, redirect to my_reservations.php
        header("Location: my_reservations.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lodging - Moffat Bay Lodge</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="AboutUs.php">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
                <li class="logo"><a href="#"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li class="active"><a href="lodging.php">Lodging</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
                <li><a href="login.php">My Reservations</a></li>
                <li><a href="login.php" class="login">Login / Register</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Banner with Booking Form -->
    <section class="hero">
        <div class="hero-text">
            <h1>Book Your Stay</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Please fill out the form to book your stay.</p>
            <form method="post" action="lodging.php">
                <label for="start_date">Check-in Date:</label>
                <input type="date" name="start_date" required><br>

                <label for="end_date">Check-out Date:</label>
                <input type="date" name="end_date" required><br>

                <label for="room_id">Room Type:</label>
                <select name="room_id" required>
                    <?php
                    // Loop through available rooms and populate the select options
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['room_id'] . '">' . $row['room_category'] . ' - ' . $row['room_type'] . ' (' . $row['available_rooms'] . ' available)</option>';
                        }
                    } else {
                        echo '<option value="">No rooms available</option>';
                    }
                    ?>
                </select><br>

                <label for="notes">Special Requests/Notes:</label>
                <textarea name="notes" rows="4" cols="50"></textarea><br>

                <input type="submit" value="Book Now">
            </form>
        </div>
    </section>
</body>
</html>
