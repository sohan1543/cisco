<?php

/********* FTP ***********/
/* Remote File Name and Path */
$remote_file = 'myFiles.zip';

/* FTP Account (Remote Server) */
$ftp_host = 'host';
$ftp_user_name = 'username'; /* username */
$ftp_user_pass = 'password'; /* password */

/* File and path to send to remote FTP server */
$local_file = 'myFiles.zip';

/* Connect using basic FTP */
$connect_it = ftp_connect( $ftp_host );

/* Login to FTP */
$login_result = ftp_login( $connect_it, $ftp_user_name, $ftp_user_pass );

/* Send $local_file to FTP */
if ( ftp_put( $connect_it, $remote_file, $local_file, FTP_BINARY ) ) {
    echo "WOOT! Successfully transfer $local_file\n";
}
else {
    echo "Doh! There was a problem\n";
}

/* Close the connection */
ftp_close( $connect_it );

/********* SFTP ***********/
$localFile='myFiles.zip';
$remoteFile='myFiles.zip';
$host = "hostname";
$port = 22;
$user = "user";
$pass = "pass";

$connection = ssh2_connect($host, $port);
ssh2_auth_password($connection, $user, $pass);
$sftp = ssh2_sftp($connection);

$stream = fopen("ssh2.sftp://$sftp$remoteFile", 'w');
$file = file_get_contents($localFile);
fwrite($stream, $file);
fclose($stream);

/********* SCP ***********/
$loc_file = "myFiles.zip";
$rem_file = "myFiles.zip";
$connection = ssh2_connect('hostname', 22);
ssh2_auth_password($connection, 'user', 'pass');

ssh2_scp_send($connection, $loc_file, $rem_file, 0644);
?>