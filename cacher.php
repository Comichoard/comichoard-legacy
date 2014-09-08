<?php
	$mysql_hostname = "localhost";
    $mysql_user = "comict";
    $mysql_password = "comichoard";
    $mysql_database = "comichoard";
    $cached=0;

    $con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

    function isCached($link)	{
    	global $cached,$con;

    	$link = mysqli_real_escape_string($con,$link);
		$sql="SELECT COUNT(link) as cnt FROM cacher WHERE link='".$link."';";
    	$result=mysqli_query($con, $sql);
    	$row=mysqli_fetch_assoc($result);
    	$cached=$row['cnt'];

    	if($cached==0)	{
    		$sql="INSERT INTO cacher VALUES('".$link."','');";
    		mysqli_query($con, $sql);
    		
    		$ch = curl_init($link);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$data = curl_exec($ch);
        	return $data;
    	}
    	else    {
    		$sql="SELECT * FROM cacher WHERE link='".$link."';";
    		$result=mysqli_query($con, $sql);
    		$row=mysqli_fetch_assoc($result);
    		return $row['data'];
    	}
    }

    function cacheLink($link,$data)	{
    	global $con;
    	$link = mysqli_real_escape_string($con,$link);
    	$data = mysqli_real_escape_string($con,$data);
    	$sql="UPDATE cacher SET data='".$data."' WHERE link='".$link."';";
    	mysqli_query($con, $sql);
    }
?>