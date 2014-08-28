<?php
	$ch = curl_init('http://tt14online.techtatva.in/api/?username=atish&password=sharma&event=civilian');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    echo $result;
?>