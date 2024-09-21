<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "admin";
$password = "pass";
$dbname = "moffatbay";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$room_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $room_id = $_POST['room_id'];
    $notes = $_POST['notes'];
    
    $_SESSION['reservation_data'] = array(
        'start_date' => $start_date,
        'end_date' => $end_date,
        'room_id' => $room_id,
        'notes' => $notes
    );
    
    header("Location: reservation_summary.php");
    exit;
}

// Fetch available rooms
$sql = "SELECT room_id, room_category, room_type, available_rooms, description FROM Rooms WHERE available_rooms > 0";
$result = mysqli_query($conn, $sql);

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
                <li><a href="attractions.php">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li class="active"><a href="room_reservation.php">Lodging</a></li>
                <li><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="logout.php" class="login">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Banner with Booking Form -->
    <section class="hero">
        <div class="hero-text">
            <h1>Book Your Stay</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>! Please fill out the form to book your stay.</p>

            <form method="post" action="room_reservation.php">
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

    <!-- Room Types Section -->
    <section>
    <?php
    // Define an associative array to map room types to specific images
    $room_images = array(
        'Standard - Single King' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/reservation-2.jpg?raw=true',
        'Standard - Single Queen' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/single-queen.jpg?raw=true',
        'Standard - Double Queen' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/double-queen.jpg?raw=true',
        'Deluxe - Single King' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/reservation-1.jpg?raw=true',
        'Deluxe - Single Queen' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/single-deluxe-queen.jpg?raw=true',
        'Deluxe - Double Queen' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/deluxe-2-Queen.jpg?raw=true',
        'Suite - 1 Room' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/suite.jpg?raw=true',
        'Suite - 2 Room' => 'https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/2-suite.jpg?raw=true',
    );

    // Re-fetch available room types for the display
    $sql = "SELECT room_category, room_type, available_rooms, description FROM Rooms WHERE available_rooms > 0";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0): ?>
        <h2>Available Room Types</h2>
        <?php while ($room = mysqli_fetch_assoc($result)): 
            // Create a key to map to the image in the associative array
            $room_key = $room['room_category'] . ' - ' . $room['room_type'];
            // Check if the room type exists in the image array, else use a default image
            $room_image = isset($room_images[$room_key]) ? $room_images[$room_key] : 'https://example.com/images/default_room.jpg';
        ?>
            <div class="room-type">
                <div class="image-container">
                    <!-- Use the image URL from the associative array -->
                    <img src="<?= htmlspecialchars($room_image); ?>" alt="<?= htmlspecialchars($room_key); ?>">
                </div>
                <div class="description">
                    <h3><?= htmlspecialchars($room_key); ?></h3>
                    <p>Available rooms: <?= htmlspecialchars($room['available_rooms']); ?></p>
                    <p><?= htmlspecialchars($room['description']); ?></p> <!-- Display description from the database -->
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No rooms available at the moment.</p>
    <?php endif; ?>
</section>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
