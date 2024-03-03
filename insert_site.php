<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nama_site = $_POST['nama_site'];
    $token = $_POST['token'];


$sql = "INSERT INTO pop_site (nama_site)
VALUES ('$nama_site')";

if ($conn->query($sql) === TRUE) {
  header('Location: index.php');
  exit;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

?>