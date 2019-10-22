<?php 
include_once "../app/bootstrap.php";

session_start();

if (isset($_SESSION['loggedIn'])) {
    $user = $_SESSION['userData'];
    $userFullName = $user['first_name'] . " " . $user['last_name'];
    echo "Welcome, $userFullName!";
    
    echo "<br><a href='logout.php'>Log Out</a>";
} else {
    http_response_code(403);
    echo "You are not authorized to view this page.";
}
