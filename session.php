<?php
// Set session expiration time to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);

ob_start();

// Start the session
session_start();

require_once('db-connection.php');
require_once('token-management.php');
// If the session variable is not set, redirect to the login page
if (
    !($clientKey = $_SESSION['client_key'] ?? null) ||
    !validateClientKey($clientKey)
) {
    echo "<script>
        const homeBtn = document.getElementById('homeBtn');
        const loginBtn = document.getElementById('loginBtn');

        homeBtn.addEventListener('click', () => {
            window.location.href = 'index.php'; // Replace with your home page URL
        });

        loginBtn.addEventListener('click', () => {
            window.location.href = 'login.php';
        });
    </script>";
    echo "<div id='customAlert' style='    
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 9999;
    '>
            <p style='text-align:center'>Please log in again</p>
            <button id='homeBtn' style='
                background-color: white;
                color: black;
                border: 1px solid #404040;
                border-radius: 10px;
                padding: 10px 15px;
                margin: 5px;
                cursor: pointer;
            '>
            Home
            </button>
            <button id='loginBtn' style='    
                background-color: #404040;
                color: white;
                border: none;
                border-radius: 10px;
                padding: 10px 15px;
                margin: 5px;
                cursor: pointer;
            '>
            Log in
            </button>
          </div>";
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
    exit;
}

ob_end_flush();
