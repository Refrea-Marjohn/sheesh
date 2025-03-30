<?php
@include 'config.php';
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
    exit();
}

$admin_name = $_SESSION['admin_name']; // Admin specific content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">  
</head>

<body>

    <!-- Sidebar Toggle Button (☰) -->
    <button class="toggle-btn" id="openSidebar" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div>
            <!-- Close Button (X) -->
            <button class="close-btn" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>

            <div class="sidebar-header">
                <img src="logo.jpg" alt="Logo">
                <h3>OPIÑA LAW OFFICE</h3>
            </div>

            <a href="admin_page.php"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-file-alt"></i> Legal Documents</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Office Calendar</a>
            <a href="#"><i class="fas fa-folder-open"></i> Files Storage</a>
            <a href="#"><i class="fas fa-balance-scale"></i> Manage Cases</a>
            <a href="#"><i class="fas fa-coins"></i> Finance</a>
            <a href="#"><i class="fas fa-user-tie"></i> Employees</a>
            <a href="#"><i class="fas fa-credit-card"></i> Payment</a>
         
        </div>

        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i><span>Logout</span> </a>
    </div>

    <div class="content-area">
        <div class="topbar">
            <h2 class="admin-welcome">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
            <div class="topbar-right">
                <input type="text" class="search-bar" placeholder="Search...">
                <i class="fas fa-bell"></i>
                <i class="fas fa-envelope"></i>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
        <div class="container">
            <div class="welcome-box">
                <p>This is your admin dashboard. You can manage users, files, and cases from here.</p>
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

    <div class="sidebar-widgets">
    <div class="weather-widget">
        <h3>🌤️ Weather Updates</h3>
        <div class="weather-search">
            <input type="text" id="cityInput" placeholder="Enter city..." />
            <button onclick="fetchWeather()"><i class="fas fa-search"></i></button>
        </div>
        <div id="weather">
            <p>Loading weather...</p>
        </div>
    </div>

    <div class="news-widget">
        <h3>📰 Latest News</h3>
        <div id="news">
            <p>Fetching news...</p>
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

<script>
    async function fetchWeather() {
        const apiKey = 'd003e00fa1875766c93f10700487869e'; // Your OpenWeather API Key
        let city = document.getElementById('cityInput').value.trim() || 'San Pablo';
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${city},PH&appid=${apiKey}&units=metric&lang=fil`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('weather').innerHTML = `
                    <p><strong>${data.weather[0].description}</strong></p>
                    <p>🌡️ Temperature: ${data.main.temp}°C</p>
                    <p>💨 Wind: ${data.wind.speed} km/h</p>
                    <p>📍 Location: ${data.name}</p>
                `;
            } else {
                document.getElementById('weather').innerHTML = `<p>❌ ${data.message}</p>`;
            }
        } catch (error) {
            console.error('Error fetching weather:', error);
            document.getElementById('weather').innerHTML = '<p>❌ Hindi makuha ang ulat ng panahon.</p>';
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchWeather();
    });
</script>

<script>
    async function fetchNews() {
        const apiKey = '511654a8612b40eeb14c4ff33126260d';  // Replace with your NewsAPI key
        const url = `https://newsapi.org/v2/everything?q=tesla&from=2025-02-18&sortBy=publishedAt&apiKey=511654a8612b40eeb14c4ff33126260d`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (response.ok && data.articles.length > 0) {
                let newsHTML = '<ul>';
                data.articles.slice(0, 5).forEach(article => {
                    newsHTML += `<li><a href="${article.url}" target="_blank">${article.title}</a></li>`;
                });
                newsHTML += '</ul>';

                document.getElementById('news').innerHTML = newsHTML;
            } else {
                document.getElementById('news').innerHTML = `<p>❌ No news available.</p>`;
            }
        } catch (error) {
            console.error('Error fetching news:', error);
            document.getElementById('news').innerHTML = '<p>❌ Unable to fetch news.</p>';
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchNews();
    });
</script>
</body>
</html>
