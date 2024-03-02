<?php
include('connection.php');

// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

// Halaman Dashboard
// echo "Selamat datang, " . $_SESSION['username'] . "!<br>";
$sql_pending = "SELECT COUNT(*) AS total_pending FROM create_ticket WHERE status_ticket = 'pending'";
$sql_open = "SELECT COUNT(*) AS total_open FROM create_ticket WHERE status_ticket = 'open'";
$sql_solved = "SELECT COUNT(*) AS total_solved FROM create_ticket WHERE status_ticket = 'solved'";

// Eksekusi query untuk masing-masing status
$result_pending = $conn->query($sql_pending);
$result_open = $conn->query($sql_open);
$result_solved = $conn->query($sql_solved);

// Ambil nilai total untuk masing-masing status
$total_pending = $result_pending->fetch_assoc()['total_pending'];
$total_open = $result_open->fetch_assoc()['total_open'];
$total_solved = $result_solved->fetch_assoc()['total_solved'];



$sql_status = "SELECT 
                    SUM(CASE WHEN status_ticket = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
                    SUM(CASE WHEN status_ticket = 'Open' THEN 1 ELSE 0 END) AS open_count
                FROM create_ticket";

$result_status = $conn->query($sql_status);
$status_data = $result_status->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ticketing Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <img src="img/mile.png" width="70" height="50"></i>

                <div class="sidebar-brand-text mx-3">Mile <sup>Net</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Ticket</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Ticket:</h6>
                        <a class="collapse-item" href="open.php">Open Ticket</a>
                        <a class="collapse-item" href="pending.php">Pending Ticket</a>
                        <a class="collapse-item" href="solved.php">Solved Ticket</a>

                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tambahan.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Tambah </span>
                </a>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Create Account</a>
                        <a class="collapse-item" href="utilities-border.html">Logout</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" id="searchInput" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchInput" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" id="searchInput" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="createticket.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Create Ticket</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pending </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_pending; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Open Tiket</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" ><?php echo $total_open; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Solved tiket
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_solved; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Priority</th>
                                            <th>Client</th>
                                            <th>Shift</th>
                                            <th>Problem</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Durations</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data tiket
                                        $sql_tickets = "SELECT 
                            ct.*, 
                            c.nama_client, 
                            TIMESTAMPDIFF(MINUTE, ct.created_at, NOW()) AS duration_minutes 
                        FROM 
                            create_ticket ct 
                        JOIN 
                            client c ON ct.id_client = c.id_client 
                        WHERE 
                            ct.status_ticket != 'Solved'";
                                        $result_tickets = $conn->query($sql_tickets);

                                        if ($result_tickets->num_rows > 0) {
                                            // Output data of each row
                                            while ($row = $result_tickets->fetch_assoc()) {
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
                                                echo "<td class='duration'>" . $row["duration_minutes"] . " minutes</td>";
                                                echo "<td class='action'>
                                    <button style='background-color: #007bff; color: #fff; border: none; padding: 5px; border-radius: 5px;'>
                                        <i class='fas fa-edit'><a href='edittiket.php?id=" . $row["id_tix"] . "' style='color: #ffff'> Edit </i>
                                    </a></button>
                                    <button style='background-color: #dc3545; color: #fff; border: none; padding: 5px; border-radius: 5px;'>
                                        <i class='fas fa-trash-alt'><a href='hapus.php? id=" . $row["id_tix"] . "' style='color: #ffff'> Delete </i>
                                    </button>
                                  </td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer style="position: fixed; bottom: 0; width: 100%; background-color: #fff; text-align: center; padding: 10px 0;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>


<script>
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }

</script>
<script>
    var durationFilter = document.getElementById('duration-filter');
    var tableRows = document.querySelectorAll('#ticket-table tbody tr');

    durationFilter.addEventListener('change', function() {
        var selectedValue = durationFilter.value;

        if (selectedValue === 'oldest') {
            sortTableByDuration(true);
        } else if (selectedValue === 'newest') {
            sortTableByDuration(false);
        }
    });

    function sortTableByDuration(ascending) {
        var rowsArray = Array.from(tableRows);
        var sortedRows = rowsArray.sort(function(rowA, rowB) {
            var durationA = parseInt(rowA.querySelector('.duration').textContent);
            var durationB = parseInt(rowB.querySelector('.duration').textContent);

            if (ascending) {
                return durationB - durationA;
            } else {
                return durationA - durationB;
            }
        });

        // Empty the table body
        var tbody = document.querySelector('#ticket-table tbody');
        tbody.innerHTML = '';

        // Append sorted rows to table body
        sortedRows.forEach(function(row) {
            tbody.appendChild(row);
        });
    }
</script>

<script>
    // Function untuk menghitung dan memperbarui durasi setiap detik
    function updateDurations() {
        var rows = document.querySelectorAll('#ticket-table tbody tr'); // Mendapatkan semua baris tabel

        // Melakukan iterasi pada setiap baris tabel
        rows.forEach(function(row) {
            var createdAtCell = row.querySelector('td:nth-child(6)'); // Sel yang berisi tanggal pembuatan
            var durationCell = row.querySelector('td:nth-child(7)'); // Sel yang akan menampilkan durasi

            // Mendapatkan waktu pembuatan dan waktu sekarang
            var createdAt = new Date(createdAtCell.textContent);
            var currentTime = new Date();

            // Menghitung durasi dalam milidetik
            var duration = currentTime - createdAt;

            // Mengonversi durasi ke jam
            var durationInHours = Math.floor(duration / (1000 * 60 * 60));

            // Memperbarui nilai durasi pada sel yang sesuai
            durationCell.textContent = durationInHours + " hours";
        });
    }

    // Memperbarui durasi setiap detik (1000 milidetik)
    setInterval(updateDurations, 1000);
</script>

<script>
    // Function untuk mengonversi data menjadi format CSV
    function convertToCSV(data) {
        var csv = '';
        // Header
        csv += 'Priority,Client,Team,Problem,Status,Created At\n';
        // Data
        data.forEach(function(row) {
            csv += row.join(',') + '\n';
        });
        return csv;
    }

    // Function untuk mengekspor data ke CSV
    function exportToCSV(data) {
        var csv = convertToCSV(data);
        var filename = 'dashboard_data.csv';

        var csvFile;
        var downloadLink;

        // Membuat objek Blob untuk menyimpan data CSV
        csvFile = new Blob([csv], {
            type: 'text/csv'
        });

        // Membuat link download
        downloadLink = document.createElement('a');

        // Menyimpan file CSV ke link download
        downloadLink.download = filename;

        // Mengatur link download ke objek Blob
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Mendapatkan elemen body
        document.body.appendChild(downloadLink);

        // Klik otomatis pada link download untuk memulai proses unduhan
        downloadLink.click();
    }

    // Event listener untuk tombol Export to CSV
    // Event listener untuk tombol Export to CSV
    var exportBtn = document.getElementById('export-btn');
    exportBtn.addEventListener('click', function() {
        var rows = document.querySelectorAll('#ticket-table tbody tr');
        var data = [];

        // Mengambil data dari setiap baris tabel, kecuali kolom terakhir (action)
        rows.forEach(function(row) {
            var rowData = [];
            row.querySelectorAll('td:not(.action)').forEach(function(cell) {
                rowData.push(cell.textContent);
            });
            data.push(rowData);
        });

        // Mengekspor data ke format CSV
        exportToCSV(data);
    });
</script>
<script>
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


    document.querySelectorAll('button').forEach(function(button) {
    button.addEventListener('click', function() {
        var id = this.getAttribute('id');
        var confirmation = confirm('Are you sure you want to delete this item?');
        if (confirmation) {
            // Kirim permintaan AJAX untuk menghapus item
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Hapus item dari tampilan jika penghapusan berhasil
                        // Misalnya, Anda dapat menggunakan JavaScript untuk menghapus elemen HTML dari DOM
                        console.log('Item deleted successfully');
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                }
            };
            xhr.open('DELETE', 'hapus.php?id=' + id, true);
            xhr.send();
        }
    });
});

</script>