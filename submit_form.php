<?php

$name = $email = $message = "";
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];
$server_name = "localhost";
$user_name = "root";
$sqlpsw = "test123";
$connection = mysqli_connect($server_name, $user_name, $sqlpsw, "forum_db");
if ($connection) {
    $db_query = "CREATE DATABASE IF NOT EXISTS forum_db";
    mysqli_query($connection, $db_query);
    mysqli_select_db($connection, "forum_db");
    $table_query = "CREATE TABLE IF NOT EXISTS feedback (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    mysqli_query($connection, $table_query);
    $query = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($connection, $query)) {
        echo "Successfully inserted data";
    } else {
        echo "No success";
    }
} else {
    echo "Problem with connection";
}
?>