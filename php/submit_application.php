<?php
$servername = "localhost";
$username = "u707137586_EV_Reg_T1_24";
$password = "DMKL0IYoP&4";
$dbname = "u707137586_EV_Reg_2024_T1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableCreationQuery = "CREATE TABLE IF NOT EXISTS applications (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    college VARCHAR(100) NOT NULL,
    degree VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    graduation_year VARCHAR(4) NOT NULL,
    resume LONGBLOB NOT NULL,
    resume_filename VARCHAR(255) NOT NULL,
    goals TEXT NOT NULL,
    confirmationEmailSent ENUM('true', 'false') NOT NULL DEFAULT 'false',
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($tableCreationQuery) === FALSE) {
    die("Error creating table: " . $conn->error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$college = $_POST['college'];
$degree = $_POST['degree'];
$specialization = $_POST['specialization'];
$graduation_year = $_POST['graduation'];
$goals = $_POST['goals'];

$resume = file_get_contents($_FILES['resume']['tmp_name']);
$resume_filename = $_FILES['resume']['name'];

$stmt = $conn->prepare("INSERT INTO applications (name, email, phone, college, degree, specialization, graduation_year, resume, resume_filename, goals, confirmationEmailSent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'false')");
$stmt->bind_param("ssssssssss", $name, $email, $phone, $college, $degree, $specialization, $graduation_year, $resume, $resume_filename, $goals);

if ($stmt->execute()) {
    echo "Application submitted successfully!";
} else {
    error_log("Error: " . $stmt->error);
    echo "Error: Something went wrong!";
}

$stmt->close();
$conn->close();
?>
