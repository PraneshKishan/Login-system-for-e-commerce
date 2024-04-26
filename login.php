<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset($_POST['uname']) && isset($_POST['upswd']) &&
        !empty($_POST['uname']) && !empty($_POST['upswd'])) {
        
        // Form data is valid, proceed with processing

        // Retrieve form data
        $uname = $_POST['uname'];
        $upswd = $_POST['upswd'];

        // Database configuration from register.php
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "wdproject";

        // Connect to the database
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        // Check for connection errors
        if ($conn->connect_error) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        // Prepare and execute SQL statement to check if the username and password exist in the database
        $stmt = $conn->prepare("SELECT * FROM register WHERE uname1 = ? AND upswd1 = ?");
        $stmt->bind_param("ss", $uname, $upswd);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there's a matching user
        if ($result->num_rows == 1) {
            // Authentication successful, redirect to store.html
            header("Location: store.html");
            exit(); // Make sure nothing else is executed after redirection
        } else {
            // Authentication failed, redirect back to login.html
            header("Location: login.html");
            exit(); // Make sure nothing else is executed after redirection
        }

        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();

    } else {
        // All fields are required, redirect back to login.html
        header("Location: login.html");
        exit(); // Make sure nothing else is executed after redirection
    }
} else {
    // Form not submitted, redirect back to login.html
    header("Location: login.html");
    exit(); // Make sure nothing else is executed after redirection
}
?>
