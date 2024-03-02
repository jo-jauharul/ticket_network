<?php
include('header.php');
include('connection.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit;
}

$sql = "SELECT t.*, c.nama_client 
        FROM create_ticket AS t
        INNER JOIN client AS c ON t.id_client = c.id_client
        WHERE t.status_ticket = 'solved'";
$result = $conn->query($sql);
?>

<div class="content">
    <h2>Solved Ticket</h2>

    <!-- Dropdown filter untuk Priority -->
    <label for="priority-filter">Filter Priority:</label>
    <select id="priority-filter">
        <option value="all">All</option>
        <option value="high">High</option>
        <option value="medium">Medium</option>
        <option value="low">Low</option>
    </select>

    <table id="ticket-table">
        <thead>
            <tr>
                <th>Priority</th>
                <th>Client</th>
                <th>Shift</th>
                <th>Problem</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $priorityClass = '';
                    switch ($row['priority']) {
                        case 'high':
                            $priorityClass = 'priority-high';
                            break;
                        case 'medium':
                            $priorityClass = 'priority-medium';
                            break;
                        case 'low':
                            $priorityClass = 'priority-low';
                            break;
                        default:
                            $priorityClass = '';
                            break;
                    }

                    echo "<tr data-id='" . $row["id_tix"] . "'>";
                    echo "<td class='$priorityClass'>" . $row["priority"] . "</td>";
                    echo "<td>" . $row["nama_client"] . "</td>";
                    echo "<td>" . $row["shift"] . "</td>";
                    echo "<td class='problem'>" . $row["problem"] . "</td>";
                    echo "<td>" . $row["status_ticket"] . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td> <button class='delete'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }
    // Mendapatkan elemen dropdown filter
    var priorityFilter = document.getElementById('priority-filter');

    // Menambahkan event listener untuk mengubah tampilan tabel saat nilai dropdown berubah
    priorityFilter.addEventListener('change', function() {
        var selectedValue = priorityFilter.value;
        var rows = document.querySelectorAll('#ticket-table tbody tr');

        // Menampilkan semua baris jika nilai filter adalah "all"
        if (selectedValue === 'all') {
            rows.forEach(function(row) {
                row.style.display = '';
            });
            return;
        }

        // Menampilkan hanya baris yang memiliki nilai priority sesuai dengan yang dipilih dalam dropdown filter
        rows.forEach(function(row) {
            var priorityCell = row.querySelector('td:nth-child(1)');
            if (priorityCell.textContent.toLowerCase() === selectedValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    var deleteButtons = document.querySelectorAll('.delete');

    // Menambahkan event listener untuk setiap tombol "Delete"
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Mendapatkan baris yang terkait dengan tombol "Delete"
            var row = button.closest('tr');
            // Mendapatkan ID data yang akan dihapus
            var id = row.dataset.id;

            // Konfirmasi sebelum menghapus data
            var isConfirmed = confirm("Are you sure you want to delete this data?");

            if (isConfirmed) {
                // Kirim permintaan AJAX untuk menghapus data jika konfirmasi diterima
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Hapus baris dari tabel setelah penghapusan berhasil
                            row.remove();
                        } else {
                            // Tampilkan pesan kesalahan jika terjadi kesalahan
                            console.error('Error:', xhr.statusText);
                        }
                    }
                };
                xhr.open('GET', 'hapus.php?id=' + id, true);
                xhr.send();
            }
        });
    });
</script>