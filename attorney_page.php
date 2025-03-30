<?php
@include 'config.php';
session_start();

// Check if the user is logged in as an attorney
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'attorney') {
    header('location:login_form.php');
    exit();
}

$attorney_name = $_SESSION['attorney_name']; // Attorney specific content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attorney Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">  
</head>

<body>
    <button class="toggle-btn" id="openSidebar" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div>
            <button class="close-btn" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>

            <div class="sidebar-header">
                <img src="logo.jpg" alt="Logo">
                <h3>OPIÑA LAW OFFICE</h3>
            </div>

            <a href="attorney_page.php"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-folder"></i> Case Files</a>
            <a href="#"><i class="fas fa-calendar"></i> Court Schedules</a>
            <a href="#"><i class="fas fa-user-tie"></i> Clients</a>
            <a href="#"><i class="fas fa-comments"></i> Messages</a>
        </div>

        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
    </div>

    <div class="content-area">
        <div class="topbar">
            <h2 class="admin-welcome">Welcome, <?php echo htmlspecialchars($attorney_name); ?>!</h2>
            <div class="topbar-right">
                <input type="text" class="search-bar" placeholder="Search...">
                <i class="fas fa-bell"></i>
                <i class="fas fa-envelope"></i>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
        <div class="container">
            <div class="welcome-box">
                <p>This is your attorney dashboard. Manage your cases, clients, and schedules from here.</p>
            </div>

            <div class="document-container">
                <div class="document-box"><a href="example.php"><button>Generate Affidavit of Loss</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Deed of Sale</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Sworn Affidavit of Solo Parent</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Affidavit of Mother</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Affidavit of Father</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Statement of Mother</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Sworn Statement of Father</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Joint Affidavit of Two Disinterested Persons</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Agreement</button></a></div>
            </div>
            
        </div>
    </div>

    <script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("closed");

        let openBtn = document.getElementById("openSidebar");
        openBtn.style.display = sidebar.classList.contains("closed") ? "block" : "none";
    }
    </script>

</body>
</html>
