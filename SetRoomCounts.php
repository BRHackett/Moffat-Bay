<?php
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
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $room_id = $_POST['room_id'];
    $total_rooms = $_POST['total_rooms'];
    $available_rooms = $_POST['available_rooms'];

    // Update the Rooms table with the new values
    $sql = "UPDATE Rooms
            SET total_rooms = ?, available_rooms = ?
            WHERE room_id = ?";

    // Prepare and bind
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iii", $total_rooms, $available_rooms, $room_id);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Room updated successfully!";
        } else {
            echo "Error updating room: " . mysqli_error($conn);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
</head>
<body>
    <h1>Update Room Information</h1>
    
    <form method="POST" action="">
        <label for="room_id">Room Type:</label>
        <select name="room_id" required>
            <?php
            // Fetch available room types from the Rooms table
            $sql = "SELECT room_id, room_category, room_type FROM Rooms";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['room_id'] . '">' . $row['room_category'] . ' - ' . $row['room_type'] . '</option>';
                }
            } else {
                echo '<option value="">No rooms available</option>';
            }
            ?>
        </select><br><br>

        <label for="total_rooms">Total Rooms:</label>
        <input type="number" name="total_rooms" min="0" required><br><br>

        <label for="available_rooms">Available Rooms:</label>
        <input type="number" name="available_rooms" min="0" required><br><br>

        <input type="submit" value="Update Room">
    </form>
</body>
</html>
