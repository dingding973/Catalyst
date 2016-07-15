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
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    die("database connection failed: ".$e->getMessage());
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

define('CSV_PATH','C:/wamp/www/catalyst/');

$csv_file = CSV_PATH . $filename;

if(!file_exists($csv_file)) {
    die("File not found. Make sure you specified the correct path.");
}

$conn->close();
?>