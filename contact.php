<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rcontact";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $message = $_POST['message'];

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        echo '<script>alert("The Email address you entered is not valid.");</script>';
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO `contact` (`name`, `email`, `contactno`, `message`) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contactno, $message);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("New contact added successfully");</script>';
        } else {
            echo '<script>alert("Error: Unable to execute the query. Please try again later.");</script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<script>alert("Error: Unable to prepare the statement. Please try again later.");</script>';
    }

    mysqli_close($conn);
}
?>