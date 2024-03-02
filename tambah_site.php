<?php
include('connection.php')
?>
    <div class="card">

        <form action="insert_site.php" method="post">

            <label for="client">Site:</label>
            <input type="text" id="site" name="nama_site" placeholder="Enter site">

            <!-- <label for="address">Address</label>
            <input type="text" id="address" name="address_client" placeholder="Enter team name">

            <label for="telp">Telpon</label>
            <input type="text" id="telp" name="telp_client" placeholder="Enter team name"> -->


            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
</div>

<style>
    .card {
        width: 50%;
        margin: 0 auto;
        background-color: #ffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card label {
        display: block;
        margin-bottom: 5px;
    }

    .card input[type="text"],
    .card select {
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
        cursor: pointer;
        float: right;
    }

    .card input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<?php

if (isset($_POST['submit'])) {
    mysqli_query($koneksi, "insert into ticketing set
    id = '$_POST[id]',
    nama_site = '$_POST[nama_site]',
    ")
        or die(mysqli_error($koneksi));
}

?>