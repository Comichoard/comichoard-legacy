<?php
    $mysql_hostname = "mysql9.000webhost.com";
    $mysql_database = "a5920228_comicho";
    $mysql_user = "a5920228_comict";
    $mysql_password = "znavfu13";
    $count = 0;
    $url_present = "";
    $next_id = "";
    $all = array();

    $con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

    function makeWell($src,$id,$next)
    {
        global $all;
        array_push($all, '<div class="well">
                <img alt="JL8 #'.$id.'" src="'.$src.'">
                <div class="details">
                    <span>#'.$id.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($id).'">Share</span>
                </div>
            </div>');
    }

    function dump50(){
		global $con;
	    $result = mysqli_query($con,"SELECT * FROM jl8 where id > 50.0 and id < 51.0");
        while($row = mysqli_fetch_array($result))   {
            $url_present = $row['url'];
            $cur_id = $row['id'];
            makeWell($url_present,$cur_id,49);
        }
    }
    if (mysqli_connect_errno()) {

        echo base64_encode('1').'!znavfu';
        if(!isset($_GET['comic']))  {
            echo mysqli_connect_errno();
            echo '<div class="jumbotron cdesc"><h1>JL8 <a href="http://jl8comic.tumblr.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>JL8 is a comic strip created by Yale Stewart. It tells tales based on younger versions of DC superheroes.</p></div>';
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
                makeWell($url_present,$pres_id,$next_id);
                if($pres_id == 1 || $pres_id == $last)
                    array_push($all,'<div class="jumbotron">Looks like you read all the comics we had.<br>Here\'s something else to read <a href="http://comichoard.com/garfield" type="button" class="btn btn-default">Garfield</a></div>');    
            }
            echo base64_encode($next_id).'!znavfu';
            foreach($all as $item) echo $item;
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
                    makeWell($url_present,$pres_id,$next_id);
                }
                array_push($all,'<div class="jumbotron">More comics from JL8...</div>');
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
                makeWell($url_present,$present_id,$next_id);
            }
            echo base64_encode($next_id).'!znavfu';
            echo '<div class="jumbotron cdesc"><h1>JL8 <a href="http://jl8comic.tumblr.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>JL8 is a comic strip created by Yale Stewart. It tells tales based on younger versions of DC superheroes.</p>
              <p>
              <span>Sort in order
              <a href="http://comichoard.com/jl8/?sort=asc" type="button" class="btn btn-default">From the start</a>
              <a href="http://comichoard.com/jl8/?sort=desc" type="button" class="btn btn-default">Most recent first</a></span>
              <span>Skip to comic # <input id="comicnumselect" type="text" class="form-control" placeholder="1-'.$last.'"></span>
              </p>
              </div>';
            foreach($all as $item) echo $item;
        }
        mysqli_close($con);
    }   
?>