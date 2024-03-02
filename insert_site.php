<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_site = $_POST['nama_site'];
    $token = $_POST['token'];
    $image_client = $_POST['image_client'];
    $image_vendor = $_POST['image_vendor'];
    $image_mikrotik = $_POST['image_mikrotik'];


$sql = "INSERT INTO pop_site (nama_site, token, image_client, image_vendor, image_mikrotik)
VALUES ('$nama_site', '$token', '$image_client', '$image_vendor', '$image_mikrotik')";

if ($conn->query($sql) === TRUE) {
  header('Location: dashboard.php');
  exit;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

?>