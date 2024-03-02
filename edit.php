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
                <form action="update.php" method="post">
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
                        <label for="gambar">Gambar:</label>
                        <input type="file" name="gambar" id="gambarInput" accept="image/*">
                        <img id="gambarPreview" src="path_to_your_image_folder/<?php echo $row['gambar']; ?>" style="display: none; max-width: 200px; max-height: 200px;">
                     

                    </select><br>
                    <input type="submit" value="Update">
                    <script>
                        function previewImage() {
                            var input = document.getElementById('gambarInput');
                            var preview = document.getElementById('gambarPreview');

                            input.addEventListener('change', function() {
                                var file = this.files[0];
                                var reader = new FileReader();

                                reader.onload = function(event) {
                                    preview.src = event.target.result;
                                    preview.style.display = 'block';
                                };

                                reader.readAsDataURL(file);
                            });
                        }

                        previewImage();
                    </script>

                </form>
            </div>
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