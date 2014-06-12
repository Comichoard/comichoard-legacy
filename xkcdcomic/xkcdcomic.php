<?php
    $mysql_hostname = "localhost";
    $mysql_user = "root";
    $mysql_password = "";
    $mysql_database = "comichoard";
    $count = 0;
    $html_present = "";
    $next_id = "";
    $all = array();

    $con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

    function makeWell($html,$id,$next)
    {
        global $all;
        array_push($all, '<div class="well">'.$html.'
                <div class="details">
                    <span>#'.$id.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($id).'">Share</span>
                </div>
            </div>');
    }

    if (mysqli_connect_errno()) {
        echo base64_encode('1').'!znavfu';
        if(!isset($_GET['comic']))  {
            echo mysqli_connect_errno();
            echo '<div class="jumbotron cdesc"><h1>XKCD <a href="http://xkcd.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>XKCD, is a webcomic created by Randall Munroe.<br>The comic\'s tagline describes it as "a webcomic of romance, sarcasm, math, and language."</p></div>';
            echo '<div class="jumbotron">There was an error while connecting to the library.<br>Here\'s something else to read <a href="http://comichoard.com/garfield" type="button" class="btn btn-default">Garfield</a></div>';
        }
    }
    else
    {
        $result = mysqli_query($con,"SELECT MAX(id) as 'max' FROM xkcd;");
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
            else {
                $result = mysqli_query($con,"SELECT * FROM xkcd where id = '".$pres_id."'");
                while (!isset($result)) {
                    if($sort=='desc')
                        $pres_id-=1;
                    else
                        $pres_id+=1;       
                    $result = mysqli_query($con,"SELECT * FROM xkcd where id = '".$pres_id."'");
                }
                while($row = mysqli_fetch_array($result))
                    $html_present = $row['html'];
                if($sort=='desc')
                    $next_id = $pres_id-1;       
                else
                    $next_id = $pres_id+1;   
                makeWell($html_present,$pres_id,$next_id);
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
                $result = mysqli_query($con,"SELECT * FROM xkcd where id = '".$pres_id."'");
                while($row = mysqli_fetch_array($result))
                    $html_present = $row['html'];
                $next_id = $pres_id-1;       
                makeWell($html_present,$pres_id,$next_id);
                array_push($all,'<div class="jumbotron">More comics from XKCD...</div>');
            }
            else
            {
                $sort = 'desc';
                if(isset($_GET['sort'])) {
                    if($_GET['sort'] == 'asc')  {
                        $sort='asc';
                    }
                }
                $result = mysqli_query($con,"SELECT * FROM xkcd order by id ".$sort.";");
                while($row = mysqli_fetch_array($result)) {
                    if($count==0)   {
                        $html_present = $row['html'];
                        $present_id = $row['id'];
                    }
                    if($count==1){
                        $next_id = $row['id'];
                        break;
                    }
                    $count += 1;
                }
                makeWell($html_present,$present_id,$next_id);
            }
            echo base64_encode($next_id).'!znavfu';
            echo '<div class="jumbotron cdesc"><h1>XKCD <a href="http://xkcd.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>XKCD, is a webcomic created by Randall Munroe.<br>The comic\'s tagline describes it as "a webcomic of romance, sarcasm, math, and language."</p>
              <p>
              <span>Sort in order
              <a href="http://comichoard.com/xkcdcomic/?sort=asc" type="button" class="btn btn-default">From the start</a>
              <a href="http://comichoard.com/xkcdcomic/?sort=desc" type="button" class="btn btn-default">Most recent first</a></span>
              <span>Skip to comic # <input id="comicnumselect" type="text" class="form-control" placeholder="1-'.$last.'"></span>
              </p>
              </div>';
            foreach($all as $item) echo $item;
        }
        mysqli_close($con);
    }   
?>