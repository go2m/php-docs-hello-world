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
/*
echo "\n";
echo "MAC : $mac\n";
echo "HW  : $machine\n";
echo "app : $app_name\n";
echo "ip  : $ip\n";
*/
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
    $datei="./data/$app_name.txt";

    # Test verzeichnisse
    #$fp=fopen('../../data/test.txt','r');
    #$txt=fread($fp,1000);
    #fclose($fp);
    #echo "TXT : $txt\n";

    // Anzahl der fÃ¼hrenden Nullen
    $stellen = 10;
    if(file_exists($datei))
    {
      $fp=fopen($datei,"r+");
      $zahl=fgets($fp,$stellen);
      #echo "zahl : $zahl \n";
      $zahl++;
      rewind($fp);
      flock($fp,2);
      fputs($fp,$zahl,$stellen);
      flock($fp,3);
      fclose($fp);
    }
    else
    {
      // Die Datei existiert nicht, sie wird
      // neu angelegt und mit dem Wert 1 gefÃ¼llt.
      $fp=fopen($datei,"w");
      $zahl="1";
      #$zahl="100000000";
      fputs($fp,$zahl,$stellen);
      fclose($fp);
    }
  # CSV log datei
  $datei="./data/".date("Y-m")."-$app_name.csv";    
  $list = array($zahl,$agent,date("Y-m-d-H:i:s"), $ip, $mac, $machine,$sysname,$version,$compute_time);
 
  $fp = fopen($datei, 'a+');
  fputcsv($fp, $list);
  fclose($fp);  
  }
else    # keine Abfrage mit go2m.eu agent
  {
  
    $request_method=$_SERVER['REQUEST_METHOD'];
    $request_time=$_SERVER['REQUEST_TIME'];
    $request_query=$_SERVER['QUERY_STRING'];
    #$http_referer=$_SERVER['HTTP_REFERER'];
    

    /*
    echo "request_method  : $request_method\n";
    echo "request_time  : $request_time\n";
    echo "request_query  : $request_query\n";
    */

    $datei="./data/".date("Y-m")."-unknown.csv";
    $fp = fopen($datei, 'a+');
    $list = array($agent,date("Y-m-d-H:i:s"), $ip, $request_method, $request_query);
    fputcsv($fp, $list);
    /*
    $header = apache_request_headers();
    foreach ($header as $headers => $value)
      {
        echo "$headers: $value \n";
        #echo fwrite($fp,"$headers: $value \n");
        
      }
    #echo fwrite($fp,$header);
    echo "type of herder : ", gettype($header), "\n";
    fputcsv($fp,$header);
    #foreach (getallheaders() as $name => $value)
    #  {
    #    echo "$name: $value \n";
    #  }
    */
    fclose($fp);
  }

// Diese Funktion sorgt fÃ¼r die Formatierung
// in diesem Fall fÃ¼r die fÃ¼hrenden Nullen
$zahl=sprintf("%0".$stellen."d",$zahl);
#echo "zahl : $zahl \n";
echo "Thank you";
?>

