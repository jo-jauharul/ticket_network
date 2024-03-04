<?php
// Pastikan hanya file dengan tipe gambar yang diizinkan yang diunggah
if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmpName = $_FILES['image']['tmp_name'];

    // Baca konten gambar
    $imageContents = file_get_contents($imageTmpName);

    // Simpan gambar ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ticketing";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Perbarui nilai kolom gambar_client/gambar_vendor/gambar_mikrotik sesuai kebutuhan
        $stmt = $conn->prepare('UPDATE create_ticket SET gambar_client = :gambar WHERE id_tix = :id');
        // Ganti 'gambar_client' dengan kolom yang sesuai
        $stmt->bindParam(':gambar', $imageContents, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $_POST['id']); // Pastikan ada input dengan nama 'id' dari form

        // Eksekusi statement SQL
        $stmt->execute();

        // Memberikan respons dengan URL gambar yang baru diunggah (jika perlu)
        echo 'path/ke/gambar/baru.jpg';
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    echo "Upload failed with error code " . $_FILES['image']['error'];
}
?>
