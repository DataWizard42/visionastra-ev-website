<?php
$servername = "localhost"; // Replace with your Hostinger database server
$username = "u707137586_EV_contact"; // Replace with your database username
$password = "B2&KY$&+gj"; // Replace with your database password
$dbname = "u707137586_EV_Contact_US"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$tableCreationQuery = "CREATE TABLE IF NOT EXISTS contact_form (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    subject VARCHAR(100),
    message TEXT,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($tableCreationQuery) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
