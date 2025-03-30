<?php
@include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
    exit();
}
$user_name = $_SESSION['user_name']; // User-specific content

require_once __DIR__ . '/vendor/autoload.php'; // Ensure TCPDF is installed via Composer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $item_lost = $_POST['item_lost'] ?? '';
    $date_lost = $_POST['date_lost'] ?? '';
    $place_lost = $_POST['place_lost'] ?? '';

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Affidavit Generator');
    $pdf->SetTitle('Affidavit of Loss');
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Times', '', 12);

    // Content formatting
    $content = "
    <style>
        .header { text-align: center; font-weight: bold; }
        .bold { font-weight: bold; }
        .indent { margin-left: 20px; }
    </style>

    <p class='header'>REPUBLIC OF THE PHILIPPINES</p>
    <p class='header'>QUEZON CITY</p>
    <p class='header'>) S.S.</p>
    <p class='header bold'>AFFIDAVIT OF LOSS</p>

    <p>I, <span class='bold'>$name</span>, of legal age, Filipino, with residence at <span class='bold'>$address</span>, after having been duly sworn to in accordance with law, hereby depose and state that:</p>

    <p class='indent'>1. I am the true and lawful owner of a <span class='bold'>$item_lost</span>.</p>
    <p class='indent'>2. On <span class='bold'>$date_lost</span>, while I was at <span class='bold'>$place_lost</span>, the said item was lost.</p>
    <p class='indent'>3. I took pains to look for the lost item but to no avail, hence, the same was declared lost.</p>
    <p class='indent'>4. I execute this affidavit to attest to the truth of the foregoing and for whatever legal purpose it may serve.</p>

    <p class='bold' style='text-align: center;'>IN WITNESS WHEREOF</p>
    <p>I have hereunto set my hand this ___ day of ____________, 20__, at Quezon City, Philippines.</p>

    <br><br><br>
    <p class='bold' style='text-align: center;'>$name</p>
    <p style='text-align: center;'>Affiant</p>

    <br><br>

    <p class='bold'>SUBSCRIBED AND SWORN</p>
    <p>before me this ____ day of ____________, 20__, in Quezon City, Philippines. Affiant exhibited to me his/her competent evidence of identity as ____________________.</p>

    <br><br><br>
    <p class='bold'>Notary Public</p>

    <br><br>

    <p>Doc. No. ____</p>
    <p>Page No. ____</p>
    <p>Book No. ____</p>
    <p>Series of 20__.</p>
    ";

    // Write content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output PDF for download
    $pdf->Output('Affidavit_of_Loss.pdf', 'D'); // 'D' forces download
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
        }

        .header h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .form-container input[type="text"],
        .form-container input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-container button {
            padding: 12px 20px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 10px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container button[type="submit"] {
            background-color: #28a745;
        }

        .form-container button[type="submit"]:hover {
            background-color: #218838;
        }

        .form-container .button-group {
            display: flex;
            justify-content: space-between;
        }
</style>

<body>

    <!-- Sidebar Toggle Button (Hidden by Default) -->
    <button class="toggle-btn" id="openSidebar" onclick="toggleSidebar()" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar (Default Open) -->
    <div class="sidebar" id="sidebar">
        <!-- Close Button -->
        <button class="close-btn" onclick="toggleSidebar()">
            <i class="fas fa-times"></i> 
        </button>

        <div class="sidebar-header">
            <img src="logo.jpg" alt="Logo">
            <h3>OPIÑA LAW OFFICE</h3>
        </div>

        <a href="user_page.php"><i class="fas fa-home"></i> Home</a>
        <a href="calendar.php"><i class="fas fa-calendar-alt"></i> Calendar</a>
        <a href="history.php"><i class="fas fa-history"></i> History</a>
        <a href="cases.php"><i class="fas fa-briefcase"></i> Cases</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="location.php"><i class="fas fa-map-marker-alt"></i> Location</a>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        
    </div>

    <div class="container">
         <!-- Header -->
        <div class="header">
           <h2>Affidavit of Loss Generator</h2>
           </div>
            <!-- Form Container -->
            <div class="form-container">
                <form id="affidavitForm" method="post">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required><br>
                    
                    <label for="item_lost">Item Lost:</label>
                    <input type="text" id="item_lost" name="item_lost" required><br>
                    
                    <label for="date_lost">Date Lost:</label>
                    <input type="date" id="date_lost" name="date_lost" required><br>
                    
                    <label for="place_lost">Place Lost:</label>
                    <input type="text" id="place_lost" name="place_lost" required><br>
                    
                    <button type="button" onclick="showPreview()">View Preview</button>
                    <button type="submit">Generate PDF</button>
                </form>
            </div>
    </div>


    <script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let openBtn = document.getElementById("openSidebar");

        sidebar.classList.toggle("open");

        if (sidebar.classList.contains("open")) {
            openBtn.style.display = "none";
        } else {
            openBtn.style.display = "block";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("openSidebar").style.display = "none";
    });
    </script>

    <script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let openBtn = document.getElementById("openSidebar");

        sidebar.classList.toggle("closed");

        if (sidebar.classList.contains("closed")) {
            openBtn.style.display = "block";
        } else {
            openBtn.style.display = "none";
        }
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
