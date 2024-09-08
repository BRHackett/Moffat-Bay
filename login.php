<?php
// Start session
session_start();

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];
    
    // Prepare and bind SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, password_hash FROM Login WHERE username = ?");
    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash);
        $stmt->fetch();

        // Verify the password
        if (hash("sha256", $password_input) === $password_hash) {
            // Successful login, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username_input;
            
            // Update last login timestamp
            $update_stmt = $conn->prepare("UPDATE Login SET last_login = NOW() WHERE user_id = ?");
            $update_stmt->bind_param("i", $user_id);
            $update_stmt->execute();

            // Redirect to a different page (e.g., My Reservations)
            header("Location: my_reservations.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="Construction.html">About Us</a></li>
                <li><a href="Construction.html">Attractions</a></li>
                <li class="logo"><a href="index.html"><img src="https://github.com/BRHackett/Moffat-Bay/blob/main/src/images/Moffat-Bay_Logo.png?raw=true" alt="Moffat Bay Lodge Logo"></a></li>
                <li><a href="Construction.html">Lodging</a></li>
                <li><a href="Construction.html">Contact Us</a></li>
                <li><a href="Construction.html">My Reservations</a></li>
                <li class="active"><a href="#" class="login">Login / Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h1>Login</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="button">Login</button>
                <p>Don't have an account? <a href="registration.php">Register here</a></p>
            </form>
        </div>
    </section>
</body>
</html>
