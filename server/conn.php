<?php
define('SERVER', 'localhost');
define('DATABASE', 'bivr');
define('USER', 'root');
define('PASSWORD', '');

$conn = new mysqli(SERVER, USER, PASSWORD, DATABASE);
if (!$conn)
    die('Failed to connect to server' . $conn->connect_error);
