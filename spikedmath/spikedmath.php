<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));

    function getfirst() {
        $url = 'http://spikedmath.com';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h1 id="page-title" class="asset-name entry-title">', $result);
        $first2 =  explode('</h1>', $first1[1]);

        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $all,$comic;
        $url = 'http://spikedmath.com/'.$i.'.html';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<img src="http://spikedmath.com/comics', $result);
        $second = explode('</center>', $first[1]);
        $namebig = explode('alt="Spiked Math Comic - ',$second[0]);
        $name = explode('"',$namebig[1]);
        array_push($all, '<div class="card">'.'<img src="http://spikedmath.com/comics'.$second[0].'<div class="details"><span>#'.$i.'</span><span>'.$name[0].'</span><span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.$i.'">Share</span></div></div>');
        return $i-1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic($_GET['strip']);
            array_push($all,'<div class="jumbotron">More comics from Spiked Math...</div>');
            $count--;
        }
        getcomic(getfirst());
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Spiked Math <a href="http://spikedmath.com" type="button" class="btn btn-default" target="_blank">www.spikedmath.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              
              </div>';
        foreach($all as $item) echo $item;
    }
?>