<?php
// Den gesamten Request-Body lesen
$request_body = file_get_contents('php://input');

// Den Request-Body ausgeben
echo $request_body;
?>
