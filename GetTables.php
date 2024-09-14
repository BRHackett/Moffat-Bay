<?php
// <YourFirstName>ShowTablesAndRecords.php
// This script connects to the moffatbay database, retrieves the list of tables, and shows all records from each table

// Database connection parameters
$servername = "localhost";
$username = "admin";  // Default username for MySQL in XAMPP
$password = "pass";      // Default password for MySQL root user is empty in XAMPP
$dbname = "moffatbay";  // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the list of tables in the database
$tablesResult = $conn->query("SHOW TABLES");
if ($tablesResult->num_rows > 0) {
    echo "<h2>List of Tables in the '$dbname' Database:</h2>";
    
    // Loop through each table
    while ($row = $tablesResult->fetch_array()) {
        $tableName = $row[0];
        echo "<h3>Table: $tableName</h3>";

        // Get all records from the current table
        $tableDataResult = $conn->query("SELECT * FROM $tableName");

        if ($tableDataResult->num_rows > 0) {
            // Display table headers dynamically based on column names
            echo "<table border='1'><tr>";
            $fieldInfo = $tableDataResult->fetch_fields();
            foreach ($fieldInfo as $val) {
                echo "<th>" . $val->name . "</th>";
            }
            echo "</tr>";

            // Output data from each row
            while ($tableRow = $tableDataResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($tableRow as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        } else {
            echo "<p>No records found in table '$tableName'.</p>";
        }
    }
} else {
    echo "<h2>No tables found in the '$dbname' database.</h2>";
}

// Close the connection
$conn->close();
?>
