<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $id = $_POST['id'];
    $shift = $_POST['shift'];
    $problem = $_POST['problem'];
    $status_ticket = $_POST['status_ticket'];
    $priority = $_POST['priority'];

    // Jika status ticket yang diperbarui menjadi 'Solved', set waktu penyelesaian
    $solved_at = ($status_ticket == 'Solved') ? date('Y-m-d H:i:s') : NULL;

    // Handle image upload
    $gambar_client = $_FILES['gambar_client']['name'];
    $gambar_vendor = $_FILES['gambar_vendor']['name'];
    $gambar_mikrotik = $_FILES['gambar_mikrotik']['name'];

    $gambar_client_tmp = $_FILES['gambar_client']['tmp_name'];
    $gambar_vendor_tmp = $_FILES['gambar_vendor']['tmp_name'];
    $gambar_mikrotik_tmp = $_FILES['gambar_mikrotik']['tmp_name'];

    $gambar_client_path = 'uploads/' . $gambar_client;
    $gambar_vendor_path = 'uploads/' . $gambar_vendor;
    $gambar_mikrotik_path = 'uploads/' . $gambar_mikrotik;

    // Pindahkan file gambar ke direktori yang ditentukan
    move_uploaded_file($gambar_client_tmp, $gambar_client_path);
    move_uploaded_file($gambar_vendor_tmp, $gambar_vendor_path);
    move_uploaded_file($gambar_mikrotik_tmp, $gambar_mikrotik_path);

    // Update query
    $query = "UPDATE create_ticket SET  shift = '$shift', problem = '$problem', status_ticket = '$status_ticket', solved_at = '$solved_at', priority = '$priority', gambar_client = '$gambar_client', gambar_vendor = '$gambar_vendor', gambar_mikrotik = '$gambar_mikrotik' WHERE id_tix = '$id'";

    if ($conn->query($query)) {
        // Redirect back to dashboard if update successful
        header("location: index.php");
    } else {
        // Echo error message if update fails
        echo "Error updating record: " . $conn->error;
    }
}
?>
