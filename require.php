<?php
require('../connect_db.php');

if(mysqli_ping($conn))
{
    echo 'MySQL Server'.mysqli_get_server_info($conn).'on'.mysqli_get_host_info($conn);
}