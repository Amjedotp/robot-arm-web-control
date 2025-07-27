<?php
$conn = new mysqli("localhost", "root", "", "robot_arm");

$values = [];
for ($i = 1; $i <= 6; $i++) {
  $values[] = intval($_POST["motor$i"]);
}
$sql = "INSERT INTO poses (motor1, motor2, motor3, motor4, motor5, motor6, status) 
        VALUES ($values[0], $values[1], $values[2], $values[3], $values[4], $values[5], 1)";
$conn->query($sql);

include 'get_run_pose.php';
?>
