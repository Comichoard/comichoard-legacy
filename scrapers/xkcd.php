<?php
	$mysql_hostname = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_database = "comichoard";

	$con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

	if(isset($_GET['comic']))	{
		$i=$_GET['comic'];
		$ch = curl_init('http://xkcd.com/'.$i.'/');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    $namebig = explode('<div id="ctitle">',$result);
	    $name = explode('</div>',$namebig[1]);
	    $first = explode('"comic">', $result);
	    $second = explode('</div>', $first[1]);
	    preg_match('/alt="(.*?)"/',$second[0], $alttoreplace);
	    $second[0] = str_replace($alttoreplace[0], 'alt="XKCD #'.$i.'"', $second[0]);
	    $second[0] = str_replace('"',"'",$second[0]);
	    echo 'added '.$i.'<br>';
	    $sql='INSERT INTO xkcd VALUES("'.$i.'","'.$second[0].'");';
	    mysqli_query($con,$sql);

	}
	else  {
		echo '<html>
			<head><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script></head>
			<body>
			<script>
				var i=1350;
				while(i<=1350)	{
					$.post("xkcd.php?comic="+i,function(data) {
						$("body").append(data);
					});
					i++;
				}
			</script>
			</body>
		</html>';
	}
?>