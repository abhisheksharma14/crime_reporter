<?php
$servername = "localhost";
$username = "urbanwand";
$password = "urbanwand";
$database = "notes";

$conn = new mysqli($servername, $username, $password);
$db_create = "CREATE DATABASE $database";
if ($conn->query($db_create) === TRUE) {
    echo "Database created successfully\n \n ";
}
$conn->close();

$conn = new mysqli($servername, $username, $password, $database);
$db_notes_table = "CREATE TABLE notes (
						id INT(11) AUTO_INCREMENT PRIMARY KEY,
						subject VARCHAR(256) NOT NULL,
						chapter VARCHAR(1024) NOT NULL,
						description TEXT DEFAULT NULL,
						file_path VARCHAR(1024) NOT NULL,
						download_url VARCHAR(1024) NOT NULL,
						uploaded_by INT(11) DEFAULT NULL,
						uploaded_on DATETIME DEFAULT CURRENT_TIMESTAMP,
						modified_on DATETIME DEFAULT '0000-00-00 00:00:00'
					)";

if ($conn->query($db_notes_table) === TRUE) {
    echo "Notes table created successfully\n \n";
}
$conn->close();
?>
