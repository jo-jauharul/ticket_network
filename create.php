
    <div class="card">
        <form action="insert_data.php" method="post">
            <label for="priority">Priority:</label>
            <select id="priority" name="priority">
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>

            <label for="client">Client:</label>
            <select id="client" name="id_client"> <!-- Ubah name menjadi id_client -->
                <?php
                // Koneksi ke database
                include('connection.php');

                // Query untuk mengambil data nama client dari tabel client
                $sql = "SELECT id_client, nama_client FROM client";
                $result = $conn->query($sql);

                // Periksa apakah query berhasil dieksekusi
                if ($result && $result->num_rows > 0) {
                    // Loop melalui setiap baris hasil query
                    while ($row = $result->fetch_assoc()) {
                        // Tampilkan opsi untuk setiap nama client
                        echo "<option value='" . $row['id_client'] . "'>" . $row['nama_client'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="team">Shift:</label>
            <select name="shift" id="shift">
                <option value="faizal">faizal</option>
                <option value="jauhar">jauhar</option>
                <option value="ihsan">ihsan</option>
            </select>
            <!-- <input type="text" id="team" name="team" placeholder="Enter team name"> -->

            <label for="status_ticket">Status:</label>
            <select id="status_ticket" name="status_ticket">
                <option value="Open">Open</option>
                <option value="Pending">Pending</option>
            </select>

            <label for="problem">Problem:</label>
            <textarea id="problem" name="problem" placeholder="Describe the problem"></textarea>

            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>

<style>
    .card {
        width: 50%;
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card label {
        display: block;
        margin-bottom: 5px;
    }

    .card input[type="text"],
    .card select,
    .card textarea {
        width: calc(100% - 20px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .card input[type="submit"] {
        background-color: #345BCB;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        /* cursor: pointer; */
        float: right;
    }

</style>

<?php
if (isset($_POST['submit'])) {
    $shift = $_POST['shift'];
    $status_ticket = $_POST['status_ticket'];
    $problem = $_POST['problem'];
    $priority = $_POST['priority'];
    $id_client = $_POST['id_client'];

    $sql = "INSERT INTO create_ticket (shift, status_ticket, problem, priority, id_client) 
            VALUES ('$shift', '$status_ticket', '$problem', '$priority', '$id_client')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>