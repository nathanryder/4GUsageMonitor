<?php

$con = mysqli_connect("localhost", "root", "user", "4GUsage");

if ($con == false) {
  die("Failed to connect to database " . mysqli_connect_error());
}

$createMain = "CREATE TABLE IF NOT EXISTS mainData(
    upload VARCHAR(128),
    download VARCHAR(128),
    total VARCHAR(128)
  )";
$createFaults = "CREATE TABLE IF NOT EXISTS faults(
    ID INT(128) AUTO_INCREMENT KEY,
    startDate VARCHAR(50),
    startTime VARCHAR(50),
    endDate VARCHAR(50),
    endTime VARCHAR(50),
    description VARCHAR(512),
    ongoing TINYINT(1)
  )";

if (mysqli_query($con, $createMain) === FALSE) {
  echo "Error code: 1";
}
if (mysqli_query($con, $createFaults) === FALSE) {
    echo "Error code: 2<br>" . mysqli_error($con);
}
?>
