<?php
$conn = new mysqli("localhost", "root", "", "robot_arm");
$id = intval($_GET['id']);
$conn->query("DELETE FROM poses WHERE id = $id");
include 'get_run_pose.php';
?>
