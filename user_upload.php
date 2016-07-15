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

if (is_file($csv_file)) {
	$csvfile = fopen($csv_file, 'r');
	
	fgetcsv($csvfile);
	while(($row = fgetcsv($csvfile,"500",",")) != FALSE){
		
		$sqlEmailCheck = $pdo->prepare("SELECT * FROM `users` WHERE email= :email");
		$sqlEmailCheck->bindValue(':email', $email, PDO::PARAM_STR);
		$sqlEmailCheck->execute();
		
		if (!$sqlEmailCheck){
			echo $email.$name;
			die(mysql_error());
		}elseif (filter_var($email, FILTER_VALIDATE_EMAIL)){
			$sqlInsert = 'INSERT INTO users(name, surname, email) VALUES(:name, :surname, :email) ON DUPLICATE KEY UPDATE name = :name';
			$query = $pdo->prepare($sqlInsert);
			$query->bindParam(':name', $name, PDO::PARAM_STR);
			$query->bindParam(':surname', $surname, PDO::PARAM_STR);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->execute();
			//printf ("Updated records: %d\n", mysql_affected_rows());
		}else{
			fwrite($STDOUT,"Invalid Email Address: \n".$email."\n");
		}
	}
	
}
fclose( $csvfile );

$conn->close();
?>