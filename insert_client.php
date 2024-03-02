<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_client = $_POST['nama_client'];
    $address_client = $_POST['address_client'];
    $telp_client = $_POST['telp_client'];


$sql = "INSERT INTO client (nama_client, address_client, telp_client)
VALUES ('$nama_client', '$address_client', '$telp_client')";

if ($conn->query($sql) === TRUE) {
  header('Location: index.php');
  exit;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

?>