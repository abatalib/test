<!DOCTYPE html>
<html lang="en">
<head>
<title>Show databases in MySQL server</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h1>Show databases in MySQL server</h1>
<?php

getenv('MYSQL_DBHOST') ? $db_host=getenv('MYSQL_DBHOST') : $db_host="localhost";
getenv('MYSQL_DBPORT') ? $db_port=getenv('MYSQL_DBPORT') : $db_port="3306";
getenv('MYSQL_DBUSER') ? $db_user=getenv('MYSQL_DBUSER') : $db_user="root";
getenv('MYSQL_DBPASS') ? $db_pass=getenv('MYSQL_DBPASS') : $db_pass="";
getenv('MYSQL_DBNAME') ? $db_name=getenv('MYSQL_DBNAME') : $db_name="";

// Check connection
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

if (strlen( $db_name ) === 0)
  $conn = new mysqli("$db_host:$db_port", $db_user, $db_pass);
else
  $conn = new mysqli("$db_host:$db_port", $db_user, $db_pass, $db_name);

$sql = "CREATE DATABASE IF NOT EXISTS test";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

mysqli_select_db($conn, "test");

$sql = "CREATE TABLE IF NOT EXISTS tutorials_tbl(
           tutorial_id INT NOT NULL AUTO_INCREMENT,
           tutorial_title VARCHAR(100) NOT NULL,
           tutorial_author VARCHAR(40) NOT NULL,
           submission_date DATE,
           PRIMARY KEY ( tutorial_id )
        );";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO tutorials_tbl(tutorial_title, tutorial_author)
        VALUES ('Titre1','Nom1');";

if ($conn->query($sql) === TRUE) {
  echo "Data inserted successfully";
} else {
  echo "Error insert data: " . $conn->error;
}

// if (!($result=mysqli_query($conn,'SHOW DATABASES')))
//     printf("Error: %s\n", mysqli_error($conn));

if (!($result=mysqli_query($conn,'SELECT * FROM tutorials_tbl')))
    printf("Error: %s\n", mysqli_error($conn));

echo "<h3>Databases</h3>";

while($row = mysqli_fetch_row( $result ))
    echo "Titre : ".$row[0]." - Auteur : ".$row[1]."<br />";

$result -> free_result();
$conn->close();
?>
</div>
</body>
</html>
