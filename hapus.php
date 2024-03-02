<?php
include('connection.php');

// Get id
$id = $_GET['id'];

// Get the id_tix to be deleted
$sql_get_id_tix = "SELECT id_tix FROM create_ticket WHERE id_tix = '$id'";
$result_get_id_tix = $conn->query($sql_get_id_tix);
$row_get_id_tix = $result_get_id_tix->fetch_assoc();
$id_tix_to_delete = $row_get_id_tix['id_tix'];

// Move the id_tix to unused_ids table
$sql_insert_unused_id = "INSERT INTO unused_ids (id_tix) VALUES ('$id_tix_to_delete')";
if ($conn->query($sql_insert_unused_id) === TRUE) {
    // Delete query
    $query = "DELETE FROM create_ticket WHERE id_tix = '$id'";

    // Execute query
    if ($conn->query($query)) {
        // Redirect to dashboard if deletion successful
        header("location: index.php");
    } else {
        // Echo error message if deletion fails
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Error inserting unused id: " . $conn->error;
}
?>
