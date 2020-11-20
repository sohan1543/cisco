<?php
$conn = ssh2_connect('127.0.0.1', 22);
ssh2_auth_password($conn, 'user', 'pass');
?>