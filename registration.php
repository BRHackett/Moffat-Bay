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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate phone number (must be 10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        $error_message = "Phone number must be exactly 10 digits.";
    }
    // Validate username and password on the server side
    elseif (strlen($username) < 6) {
        $error_message = "Username must be at least 6 characters long.";
    } elseif (!preg_match('/^(?=.*[0-9]).{8,}$/', $password)) {
        $error_message = "Password must be at least 8 characters long and include at least 1 number.";
    } else {
        // Hash the password
        $password_hash = hash("sha256", $password);

        // Insert into User table
        $stmt = $conn->prepare("INSERT INTO User (first_name, last_name, email, phone, address, city, state, zip_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $address, $city, $state, $zip_code, $country);

        if ($stmt->execute()) {
            // Get the last inserted user_id
            $user_id = $conn->insert_id;

            // Insert into Login table
            $login_stmt = $conn->prepare("INSERT INTO Login (user_id, username, password_hash) VALUES (?, ?, ?)");
            $login_stmt->bind_param("iss", $user_id, $username, $password_hash);

            if ($login_stmt->execute()) {
                // Registration successful, redirect to login page
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error inserting into Login table.";
            }
            $login_stmt->close();
        } else {
            $error_message = "Error inserting into User table.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Moffat Bay Lodge</title>
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
                <li><a href="room_reservation.php">Lodging</a></li>
                <li><a href="my_reservations.php">My Reservations</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li class="active"><a href="login.php" class="login">Login/Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="register-section">
        <div class="register-container">
            <h1>Register</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="registration.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="phone" required pattern="\d{10}" title="Phone number must be exactly 10 digits">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="">Select a state</option>
                        <option value="AL">AL</option>
                        <option value="AK">AK</option>
                        <option value="AZ">AZ</option>
                        <option value="AR">AR</option>
                        <option value="CA">CA</option>
                        <option value="CO">CO</option>
                        <option value="CT">CT</option>
                        <option value="DE">DE</option>
                        <option value="FL">FL</option>
                        <option value="GA">GA</option>
                        <option value="HI">HI</option>
                        <option value="ID">ID</option>
                        <option value="IL">IL</option>
                        <option value="IN">IN</option>
                        <option value="IA">IA</option>
                        <option value="KS">KS</option>
                        <option value="KY">KY</option>
                        <option value="LA">LA</option>
                        <option value="ME">ME</option>
                        <option value="MD">MD</option>
                        <option value="MA">MA</option>
                        <option value="MI">MI</option>
                        <option value="MN">MN</option>
                        <option value="MS">MS</option>
                        <option value="MO">MO</option>
                        <option value="MT">MT</option>
                        <option value="NE">NE</option>
                        <option value="NV">NV</option>
                        <option value="NH">NH</option>
                        <option value="NJ">NJ</option>
                        <option value="NM">NM</option>
                        <option value="NY">NY</option>
                        <option value="NC">NC</option>
                        <option value="ND">ND</option>
                        <option value="OH">OH</option>
                        <option value="OK">OK</option>
                        <option value="OR">OR</option>
                        <option value="PA">PA</option>
                        <option value="RI">RI</option>
                        <option value="SC">SC</option>
                        <option value="SD">SD</option>
                        <option value="TN">TN</option>
                        <option value="TX">TX</option>
                        <option value="UT">UT</option>
                        <option value="VT">VT</option>
                        <option value="VA">VA</option>
                        <option value="WA">WA</option>
                        <option value="WV">WV</option>
                        <option value="WI">WI</option>
                        <option value="WY">WY</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="zip_code">Zip Code:</label>
                    <input type="text" id="zip_code" name="zip_code" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="username">Create a Username:</label>
                    <input type="text" id="username" name="username" required pattern=".{6,}" title="Username must be at least 6 characters long">
                </div>
                <div class="form-group">
                    <label for="password">Create a Password:</label>
                    <input type="password" id="password" name="password" required title="Password must be at least 8 characters long and include at least 1 number">
                </div>
		<div class="form-group">
                    <label for="cpassword">Confirm Password:</label>
                    <input type="password" id="cpassword" name="cpassword" required title="Please confirm your password">
                </div>
                <button type="submit" class="button">Register Now!</button>
            </form>
        </div>
    </section>

    <script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("cpassword").value;
        
        // Check if the password is at least 8 characters long and contains at least one number
        var passwordPattern = /^(?=.*[0-9]).{8,}$/;
        
        if (!passwordPattern.test(password)) {
            alert("Password must be at least 8 characters long and include at least 1 number.");
            return false;
        }
        
        // Check if passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match. Please confirm your password.");
            return false;
        }

        return true;
    }
    </script>
</body>
</html>
