<?php
$firstname = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

//Datebase connection
$conn = new mysqli('localhost', 'root', '', 'login');
if ($conn->connect_error) {
    die('Connection Failed :' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO  registration(email,firstname,password)
    Values (?,?,?)");
    $stmt->bind_param("sss", $firstname, $email, $password);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
echo "bien joue";
