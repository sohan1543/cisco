<?php
$df = disk_free_space("D:");
$dt = disk_total_space("D:");
$du = $dt - $df;
$dp = sprintf('%.2f',($du / $dt) * 100);

$df = formatSize($df);
$du = formatSize($du);
$dt = formatSize($dt);

function formatSize( $bytes )
{
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $i < ( count( $types ) -1 ); $i++ ) {
            if($bytes >= 1024) {
                $bytes /= 1024;
            } else {
            break;
            }
        };
                return( round( $bytes, 2 ) . " " . $types[$i] );
}

print_r(["free_space" => $df, "used_space" => $du, "total_space" => $dt]);
?>