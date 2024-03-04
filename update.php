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

    // Get gambar data from textarea
    $gambar_client = $_POST['gambar_client'];
    $gambar_vendor = $_POST['gambar_vendor'];
    $gambar_mikrotik = $_POST['gambar_mikrotik'];

    // Update query
    $query = "UPDATE create_ticket SET shift = '$shift', problem = '$problem', status_ticket = '$status_ticket', solved_at = '$solved_at', priority = '$priority', gambar_client = '$gambar_client', gambar_vendor = '$gambar_vendor', gambar_mikrotik = '$gambar_mikrotik' WHERE id_tix = '$id'";

    if ($conn->query($query)) {
        // Redirect back to dashboard if update successful
        header("location: index.php");
    } else {
        // Echo error message if update fails
        echo "Error updating record: " . $conn->error;
    }
}
?>
