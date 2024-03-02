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
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;

    move_uploaded_file($gambar_tmp, $gambar_path);

    // Update query
    $query = "UPDATE create_ticket SET  shift = '$shift', problem = '$problem', status_ticket = '$status_ticket', solved_at = '$solved_at', priority = '$priority', gambar = '$gambar_path' WHERE id_tix = '$id'";

    if ($conn->query($query)) {
        // Redirect back to dashboard if update successful
        header("location: index.php");
    } else {
        // Echo error message if update fails
        echo "Error updating record: " . $conn->error;
    }
}
