<?php
include 'phpqrcode.php';   
$url = urldecode($_GET['url']);
QRcode::png($url);  