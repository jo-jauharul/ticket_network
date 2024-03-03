<div class="card">
    <form action="insert_data.php" method="post">
        <label for="priority">Priority:</label>
        <select id="priority" name="priority">
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>
        <label for="site">Site:</label>
        <select id="site" name="id_site"> <!-- Ubah name menjadi id_client -->
            <?php
            // Koneksi ke database
            include('connection.php');

            // Query untuk mengambil data nama client dari tabel client
            $sql = "SELECT id_site, nama_site FROM pop_site";
            $result = $conn->query($sql);

            // Periksa apakah query berhasil dieksekusi
            if ($result && $result->num_rows > 0) {
                // Loop melalui setiap baris hasil query
                while ($row = $result->fetch_assoc()) {
                    // Tampilkan opsi untuk setiap nama client
                    echo "<option value='" . $row['id_site'] . "'>" . $row['nama_site'] . "</option>";
                }
            }
            ?>
        </select>


        <label for="token">Token:</label>
        <input type="text" id="token" name="token">

        <label for="client">Client:</label>
        <select id="client" name="id_client">
            <?php
            include('connection.php');
            $sql = "SELECT id_client, nama_client FROM client";
            $result = $conn->query($sql);
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
document.getElementById("site").addEventListener("change", function() {
    var site = this.options[this.selectedIndex].text; // Mengambil teks dari opsi yang dipilih
    var tokenInput = document.getElementById("token"); // Mengambil elemen input token

    // Mengambil 3 huruf pertama dari nama_site
    var token = site.substring(0, 3).toUpperCase();

    // Menambahkan 7 nomor acak ke token
    for (var i = 0; i < 7; i++) {
        token += Math.floor(Math.random() * 10); // Menambahkan angka acak dari 0 hingga 9 ke token
    }

    // Mengatur nilai input token
    tokenInput.value = token;
});

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
    $id_site = $_POST['id_site']; // Ambil nilai id_site dari dropdown "Site"
    $token = $_POST['token'];

    // Buat query SQL untuk menyisipkan data baru ke dalam tabel create_ticket
    $sql = "INSERT INTO create_ticket (shift, status_ticket, problem, priority, id_client, id_site, token) 
    VALUES ('$shift', '$status_ticket', '$problem', '$priority', '$id_client', '$id_site', '$token')";
// Jalankan query SQL
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>