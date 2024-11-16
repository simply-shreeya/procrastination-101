<?php
// Define database credentials
$server_name = "localhost";
$user_name = "root";
$sqlpsw = ""; // Use an empty password if 'root' has no password set
$database = "forum_db";

// Create a connection
$connection = new mysqli($server_name, $user_name, $sqlpsw);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Create the database if it does not exist
$db_query = "CREATE DATABASE IF NOT EXISTS $database";
if ($connection->query($db_query) === TRUE) {
    echo "Database created or already exists.<br>";
} else {
    die("Error creating database: " . $connection->error);
}

// Select the database
$connection->select_db($database);

// Create the table if it does not exist
$table_query = "CREATE TABLE IF NOT EXISTS feedback (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($connection->query($table_query) === TRUE) {
    echo "Table created or already exists.<br>";
} else {
    die("Error creating table: " . $connection->error);
}

// Prepare and bind the statement to prevent SQL injection
$stmt = $connection->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Error preparing statement: " . $connection->error);
}
$stmt->bind_param("sss", $name, $email, $message);

// Get form data
$name = $_POST["name"] ?? '';
$email = $_POST["email"] ?? '';
$message = $_POST["message"] ?? '';

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Successfully inserted data.<br>";
} else {
    echo "Failed to insert data: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
