<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = 'ciscotest';

$conn = mysqli_connect($servername,$username,$password,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE VIEW RouterInfo AS SELECT * FROM routers");