<?php
	$mysql_hostname = "localhost";
	$mysql_user = "comict";
	$mysql_password = "comichoard";
	$mysql_database = "comichoard";
	$count = 0;
	$url_present = "";
	$next_date = "";
	$all = array();

	$con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

	function makeWell($src,$date,$next)
	{
		global $all;
		array_push($all, '<div class="well">
				<img alt="Calvin and Hobbes '.$date.'" src="'.$src.'" width="700">
				<div class="details">
					<span>'.$date.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($date).'">Share</span>
				</div>
			</div>');
	}

	if (mysqli_connect_errno()) {
	  	echo base64_encode('1').'!znavfu';
        if(!isset($_GET['comic']))	{
	        echo '<div class="jumbotron cdesc"><h1>Calvin and Hobbes <a href="http://www.gocomics.com/calvinandhobbes/" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
	              <p>Calvin and Hobbes is a daily comic strip that was written and illustrated by American cartoonist Bill Watterson.<br>
	              It follows the humorous antics of Calvin, a mischievous and adventurous six-year-old boy, and Hobbes, his sardonic stuffed tiger.</p></div><br><br><br>';
	        echo '<div class="jumbotron">There was an error while connecting to the library.<br>Here\'s something else to read <a href="http://comichoard.com/?comic=garfield" type="button" class="btn btn-default">Garfield</a></div>';
	    }
	}
	else
	{
		if(isset($_GET['comic'])){
			$pres_date = base64_decode(($_GET['comic']));
			$result = mysqli_query($con,"SELECT * FROM calvin where date = '".$pres_date."'");
			while($row = mysqli_fetch_array($result))
				$url_present = $row['url'];
			$date1 = str_replace('-', '/', $pres_date);
			$next_date = date('Y-m-d',strtotime($date1 . "-1 days"));		
			makeWell($url_present,$pres_date,$next_date);
			echo base64_encode($next_date).'!znavfu';
	        echo $all[0];
		}
		else {
			if(isset($_GET['strip']))   
			{
	            $pres_date = base64_decode(($_GET['strip']));
				$result = mysqli_query($con,"SELECT * FROM calvin where date = '".$pres_date."'");
				while($row = mysqli_fetch_array($result))
					$url_present = $row['url'];
				$date1 = str_replace('-', '/', $pres_date);
				$next_date = date('Y-m-d',strtotime($date1 . "-1 days"));		
				makeWell($url_present,$pres_date,$next_date);
	            array_push($all,'<div class="jumbotron">More comics from Calvin and Hobbes...</div>');
	        }
	        else
	        {
				$result = mysqli_query($con,"SELECT * FROM calvin order by date desc");
				while($row = mysqli_fetch_array($result)) {
					if($count==0)	{
						$url_present = $row['url'];
						$present_date = $row['date'];
					}
					if($count==1){
						$next_date = $row['date'];
						break;
					}
					$count += 1;
				}
				makeWell($url_present,$present_date,$next_date);
			}
			echo base64_encode($next_date).'!znavfu';
	        echo '<div class="jumbotron cdesc"><h1>Calvin and Hobbes <a href="http://www.gocomics.com/calvinandhobbes/" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
	              <p>Calvin and Hobbes is a daily comic strip that was written and illustrated by American cartoonist Bill Watterson.<br>
	              It follows the humorous antics of Calvin, a mischievous and adventurous six-year-old boy, and Hobbes, his sardonic stuffed tiger.</p></div>';
	        foreach($all as $item) echo $item;
		}
		mysqli_close($con);
	}	
?>