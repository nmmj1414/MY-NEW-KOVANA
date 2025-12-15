<?php
// db.php
// Simple SQLSRV connection template. Edit the server, database, uid, pwd to match your environment.

// NOTE: change these values to your database server settings.
$serverName = "LAPTOP-722CRD8D\SQLEXPRESS";        // or "localhost", or your server host
$connectionOptions = array(
    "Database" => "Website", // set to your database name used by Website 2 (example: Website)
    "Uid" => "",            // if using SQL auth, put username here; otherwise keep empty for Windows auth
    "PWD" => ""             // password if using SQL auth
);

// Attempt connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Basic check (very simple, beginner style)
if ($conn == null) {
    // In development show a small message so you can debug. In production replace with a user-friendly page.
    echo "<script>alert('Database connection failed. Please check db.php settings.');</script>";
}
?>


