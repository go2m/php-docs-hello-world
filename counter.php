<?php

// Simple Counter v1.0
// FÃ¼r die korrekte Funktionsweise des Counters ist darauf zu
// achten, dass die entsprechenden Schreibrechte auf dem
// Webserver gesetzt sind.
# Version 1.1 2024-01-03
$body = $_POST;
$mac = $_POST["mac"];
$machine = $_POST["machine"];
$app_name = $_POST["app"];
$sysname = $_POST["sysname"];
$version = $_POST["version"];
$compute_time = $_POST["compute-time"];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}
#
#/*
echo "\n";
echo "MAC : $mac\n";
echo "HW  : $machine\n";
echo "app : $app_name\n";
echo "ip  : $ip\n";
#*/
#
// Counterdateiname
$agent = $_SERVER["HTTP_USER_AGENT"];
echo "user-Agent : $agent\n";
#if ($agent == "go2m.eu/1.1")
if (fnmatch("go2m.eu/*",($agent)))
  {
    echo "agent ok\n";
		# Counterdateiname
		$datei="$app_name.txt";
    $datei="data/$app_name.txt";
  }

?>