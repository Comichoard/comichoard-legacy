<?php
    $mysql_hostname = "localhost";
    $mysql_user = "comict";
    $mysql_password = "comichoard";
    $mysql_database = "comichoard";
    $count = 0;
    $html_present = "";
    $next_id = "";
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));

    $con=mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database);

    function getfirst() {
        $ch = curl_init('http://xkcd.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('http://xkcd.com/', $result);
        $first2 =  explode('/', $first1[1]);
        return intval($first2[0]);
    }

    function makecard($html,$id,$next)
    {
        global $sendback,$comic;
        $srcbig = explode("src='",$html); 
        $src = explode("'",$srcbig[1]);
        $sendback = '{"comic":"XKCD","image":"'.$src[0].'","desc":"# '.$id.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($id).'","next":"'.base64_encode($next).'"}';
    }

    if (mysqli_connect_errno()) {
        if(!isset($_GET['next']))  {
            echo mysqli_connect_errno();
            echo '<div class="jumbotron cdesc"><h1>XKCD <a href="http://xkcd.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1></div>';
            echo '<br><br><div class="jumbotron">There was an error while connecting to the library.<br>Here\'s something else to read <a href="http://comichoard.com/garfield" type="button" class="btn btn-default">Garfield</a></div>';
        }
    }
    else
    {
        $result = mysqli_query($con,"SELECT MAX(id) as 'max' FROM xkcd;");
        $row = mysqli_fetch_array($result);
        $last = $row['max'];
        if(isset($_GET['next']))   {
            $sort = 'desc';
            if(isset($_GET['sort'])) {
                if($_GET['sort'] == 'asc')  {
                    $sort='asc';
                }
            }
            $pres_id = base64_decode(($_GET['next']));
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
                makecard($html_present,$pres_id,$next_id);
            }
            echo $sendback;
        }
        else {
            if(isset($_GET['strip']))   
            {
                $pres_id = base64_decode($_GET['strip']);
                $result = mysqli_query($con,"SELECT * FROM xkcd where id = '".$pres_id."'");
                while($row = mysqli_fetch_array($result))
                    $html_present = $row['html'];
                $next_id = $pres_id-1;       
                makecard($html_present,$pres_id,$next_id);
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
                        $begin = getfirst();
                        if($sort == 'desc' && $present_id<$begin)    {
                            $ch = curl_init('http://comichoard.com/scrapers/xkcd.php?comic='.$begin);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_exec($ch);
                        }
                    }
                    if($count==1){
                        $next_id = $row['id'];
                        break;
                    }
                    $count += 1;
                }
                makecard($html_present,$present_id,$next_id);
            }
            echo $sendback;
        }
        mysqli_close($con);
    }   
?>