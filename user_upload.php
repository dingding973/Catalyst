<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$filename = "users.csv";
$fieldseparator = ","; 
$lineseparator = "\n";

//STDOUT
$STDOUT = fopen('php://stdout', 'w');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE users (
name VARCHAR(30) NOT NULL,
surname VARCHAR(30) NOT NULL,
email VARCHAR(50),
unique key(email)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully \n";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>