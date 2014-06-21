<?php
	if(isset($_GET['share']))	{
		$share=str_replace('<', '', $_GET['share']);
		$share=str_replace('>', '', $share);
		file_put_contents("shared.txt", "\n<p>".$share."</p>",FILE_APPEND | LOCK_EX);
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/default.css?v=44" />
	<style>p{margin:0}</style>
</head>
<body>
<h1>Shared links:</h1>
<?php 
	$allshared = file_get_contents('shared.txt');
	echo $allshared;
?>