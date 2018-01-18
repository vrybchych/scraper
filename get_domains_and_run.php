<?php

$host = "localhost";
$user = "root";
$password = "qwerty";
$db = "sites";

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_errno) {
    echo "Can't connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

while(1) {
  $res = $mysqli->query("SELECT * FROM domains WHERE status=0 LIMIT 1");
  $res = $res->fetch_assoc();
  if (!$res)
    break;
  $sql = "UPDATE domains SET status=1 WHERE id=".$res['id'];
  $mysqli->query($sql);
  shell_exec('sh run.sh'.$res['domain']);
}
$mysqli->close();
