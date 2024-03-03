<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_client = $_POST['nama_client'];
    $shift = $_POST['shift'];
    $status_ticket = $_POST['status_ticket'];
    $problem = $_POST['problem'];
    $priority = $_POST['priority'];
    $id_client = $_POST['id_client'];
    $id_site = $_POST['id_site'];
    $token = $_POST['token'];

    // Periksa apakah ada id_tix yang tersedia dalam tabel unused_ids
    $sql_get_unused_id = "SELECT id_tix FROM unused_ids LIMIT 1";
    $result_get_unused_id = $conn->query($sql_get_unused_id);

    if ($result_get_unused_id->num_rows > 0) {
        // Jika ada id_tix yang tersedia, gunakan id_tix tersebut
        $row_unused_id = $result_get_unused_id->fetch_assoc();
        $id_tix = $row_unused_id['id_tix'];

        // Hapus id_tix tersebut dari tabel unused_ids
        $sql_delete_unused_id = "DELETE FROM unused_ids WHERE id_tix = $id_tix";
        $conn->query($sql_delete_unused_id);
    } else {
        // Jika tidak ada id_tix yang tersedia, buat id_tix baru
        $sql_get_highest_id = "SELECT MAX(id_tix) AS highest_id FROM create_ticket";
        $result_get_highest_id = $conn->query($sql_get_highest_id);
        $row_highest_id = $result_get_highest_id->fetch_assoc();
        $highest_id = $row_highest_id['highest_id'];
        $id_tix = $highest_id + 1;
    }

    // Masukkan data tiket baru ke dalam tabel create_ticket
    $sql_insert_ticket = "INSERT INTO create_ticket (id_tix, shift, problem, status_ticket, priority, id_client, id_site, token)
    VALUES ('$id_tix', '$shift', '$problem', '$status_ticket','$priority', '$id_client', '$id_site', '$token')";

    
    if ($conn->query($sql_insert_ticket) === TRUE) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql_insert_ticket . "<br>" . $conn->error;
    }
}
?>
