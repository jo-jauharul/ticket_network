<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get the id from the URL parameter
    $id = $_GET['id'];

    // Query to retrieve the ticket data
    $query = "SELECT * FROM create_ticket WHERE id_tix = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Data found, display the form with pre-filled data
        $row = $result->fetch_assoc();
        // Output the form with pre-filled data
?>
        <div class="card">
            <form action="update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id_tix']; ?>">
                <label for="shift">Shift:</label>
                <input type="text" name="shift" value="<?php echo $row['shift']; ?>"><br>
                <label for="problem">Problem:</label>
                <input type="text" name="problem" value="<?php echo $row['problem']; ?>"><br>
                <label for="status_ticket">Status:</label>
                <select name="status_ticket">
                    <option value="Solved" <?php if ($row['status_ticket'] == 'Solved') echo 'selected'; ?>>Solved</option>
                    <option value="Pending" <?php if ($row['status_ticket'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Open" <?php if ($row['status_ticket'] == 'Open') echo 'selected'; ?>>Open</option>
                </select><br>
                <label for="priority">Priority:</label>
                <select name="priority">
                    <option value="high" <?php if ($row['priority'] == 'high') echo 'selected'; ?>>High</option>
                    <option value="medium" <?php if ($row['priority'] == 'medium') echo 'selected'; ?>>Medium</option>
                    <option value="low" <?php if ($row['priority'] == 'low') echo 'selected'; ?>>Low</option>
                </select>

                <label for="gambar_client">Bukti client :</label>
                <textarea name="gambar_client" id="gambarTextareaClient" rows="5" cols="50"><?php echo $row['gambar_client']; ?></textarea>
                <div id="gambarPreviewClient"></div>
                <br>

                <label for="gambar_vendor">Bukti vendor:</label>
                <textarea name="gambar_vendor" id="gambarTextareaVendor" rows="5" cols="50"><?php echo $row['gambar_vendor']; ?></textarea>
                <div id="gambarPreviewVendor"></div>
                <br>

                <label for="gambar_mikrotik">Bukti Mikrotik:</label>
                <textarea name="gambar_mikrotik" id="gambarTextareaMikrotik" rows="5" cols="50"><?php echo $row['gambar_mikrotik']; ?></textarea>
                <div id="gambarPreviewMikrotik"></div>
                <br>

                <input type="submit" value="Update">

                <script>
    function handlePaste(textareaId, previewId) {
        var textarea = document.getElementById(textareaId);
        var preview = document.getElementById(previewId);

        textarea.addEventListener('paste', function(event) {
            var items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (index in items) {
                var item = items[index];
                if (item.kind === 'file') {
                    var blob = item.getAsFile();
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var dataURL = event.target.result;
                        // Menambahkan data URL gambar ke dalam textarea
                        textarea.value += '\n' + dataURL;
                        // Menampilkan preview gambar di bawah textarea
                        var img = document.createElement('img');
                        img.src = dataURL;
                        preview.appendChild(img);
                        // Menghapus URL gambar dari textarea setelah ditampilkan
                        textarea.value = textarea.value.replace(dataURL, '');
                    };
                    reader.readAsDataURL(blob);
                }
            }
        });
    }

    // Panggil fungsi handlePaste untuk masing-masing textarea
    handlePaste('gambarTextareaClient', 'gambarPreviewClient');
    handlePaste('gambarTextareaVendor', 'gambarPreviewVendor');
    handlePaste('gambarTextareaMikrotik', 'gambarPreviewMikrotik');

    function preventDataURLPaste(textareaId) {
        var textarea = document.getElementById(textareaId);
        textarea.addEventListener('paste', function(event) {
            var items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (var index in items) {
                var item = items[index];
                if (item.kind === 'file') {
                    event.preventDefault(); // Mencegah data URL ditambahkan ke textarea
                    return false;
                }
            }
        });
    }

    // Panggil fungsi preventDataURLPaste untuk masing-masing textarea
    preventDataURLPaste('gambarTextareaClient');
    preventDataURLPaste('gambarTextareaVendor');
    preventDataURLPaste('gambarTextareaMikrotik');
</script>


            </form>
        </div>
<?php
    } else {
        // Data not found, display error message
        echo "Ticket not found.";
    }
}
?>

<style>
    .card {
        width: 50%;
        margin: 0 auto;
        background-color: #f9f9f9;
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
        background-color: #4CAF50;
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