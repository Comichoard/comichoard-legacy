<?php
    $mysql_hostname = "localhost";
    $mysql_user = "comict";
    $mysql_password = "comichoard";
    $mysql_database = "comichoard";
    $count = 0;
    $url_present = "";
    $next_id = "";
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));

    $con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

    function makecard($src,$id,$next)
    {
        global $sendback,$comic;
        $sendback = '{"comic":"JL8","image":"'.$src.'","desc":"# '.$id.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($id).'","next":"'.base64_encode($next).'"}';
    }

    function dump50(){
		global $con;
	    $result = mysqli_query($con,"SELECT * FROM jl8 where id > 50.0 and id < 51.0");
        while($row = mysqli_fetch_array($result))   {
            $url_present = $row['url'];
            $cur_id = $row['id'];
            makecard($url_present,$cur_id,49);
        }
    }
    if (mysqli_connect_errno()) {
        if(!isset($_GET['comic']))  {
            echo mysqli_connect_errno();
            echo '<div class="jumbotron cdesc"><h1>JL8 <a href="http://jl8comic.tumblr.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p class="cdesc-desc">JL8 is a comic strip created by Yale Stewart. It tells tales based on younger versions of DC superheroes.</p></div>';
            echo '<div class="jumbotron">There was an error while connecting to the library.<br>Here\'s something else to read <a href="http://comichoard.com/garfield" type="button" class="btn btn-default">Garfield</a></div>';
        }
    }
    else
    {
        $result = mysqli_query($con,"SELECT MAX(id) as 'max' FROM jl8;");
        $row = mysqli_fetch_array($result);
        $last = $row['max'];
        if(isset($_GET['comic']))   {
            $sort = 'desc';
            if(isset($_GET['sort'])) {
                if($_GET['sort'] == 'asc')  {
                    $sort='asc';
                }
            }
            $pres_id = base64_decode(($_GET['comic']));
            if($pres_id == 0 || $pres_id == $last+1)
                exit();
            if($pres_id == 50)  {
                dump50();
                if($sort=='desc')
                    $next_id = 49;
                else
                    $next_id = 51;
            }
            else {
                $result = mysqli_query($con,"SELECT * FROM jl8 where id = '".$pres_id."'");
                while($row = mysqli_fetch_array($result))
                    $url_present = $row['url'];
                if($sort=='desc')
                    $next_id = $pres_id-1;       
                else
                    $next_id = $pres_id+1;   
                makecard($url_present,$pres_id,$next_id);
                if($pres_id == 1 || $pres_id == $last)
                    array_push($sendback,'<div class="jumbotron">Looks like you read all the comics we had.<br>Here\'s something else to read <a href="http://comichoard.com/garfield" type="button" class="btn btn-default">Garfield</a></div>');    
            }
            echo base64_encode($next_id).'!znavfu';
            echo $sendback;
        }
        else {
            if(isset($_GET['strip']))   
            {
                $pres_id = base64_decode($_GET['strip']);
                if($pres_id == 50)  {
                    dump50();
                    $next_id = 49;
                }
                else {
                    $result = mysqli_query($con,"SELECT * FROM jl8 where id = '".$pres_id."'");
                    while($row = mysqli_fetch_array($result))
                        $url_present = $row['url'];
                    $next_id = $pres_id-1;       
                    makecard($url_present,$pres_id,$next_id);
                }
            }
            else
            {
                $sort = 'desc';
                if(isset($_GET['sort'])) {
                    if($_GET['sort'] == 'asc')  {
                        $sort='asc';
                    }
                }
                $result = mysqli_query($con,"SELECT * FROM jl8 order by id ".$sort.";");
                while($row = mysqli_fetch_array($result)) {
                    if($count==0)   {
                        $url_present = $row['url'];
                        $present_id = $row['id'];
                    }
                    if($count==1){
                        $next_id = $row['id'];
                        break;
                    }
                    $count += 1;
                }
                makecard($url_present,$present_id,$next_id);
            }
            echo $sendback;
        }
        mysqli_close($con);
    }   
?>