<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $source = 'xkcd';

    function getfirst() {
        $url = 'http://www.xkcd.com';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('http://xkcd.com/', $result);
        $first2 =  explode('/', $first1[1]);

        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $all,$comic;
        $url = 'http://www.xkcd.com/'.$i.'/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $namebig = explode('<div id="ctitle">',$result);
        $name = explode('</div>',$namebig[1]);
        $first = explode('"comic">', $result);
        $second = explode('</div>', $first[1]);
        preg_match('/alt="(.*?)"/',$second[0], $alttoreplace);
        $second[0] = str_replace($alttoreplace[0], 'alt="XKCD #'.$i.'"', $second[0]);
        array_push($all, '<div class="well">'.$second[0].'<br><div class="details"><span>#'.$i.'</span><span>'.$name[0].'</span><span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.$i.'">Share</span></div></div>');
        return $i-1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$all[0];
    }
    else    {
        $count = 1;
        if(isset($_GET['strip']))   {
            getcomic($_GET['strip']);
            array_push($all,'<div class="jumbotron">More comics from XKCD...</div>');
            $count--;
        }
        $begin = getfirst();
        $i = getcomic($begin);
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>XKCD <a href="http://xkcd.com" type="button" class="btn btn-default" target="_blank">Go to site</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              <p>XKCD, is a webcomic created by Randall Munroe.<br>The comic\'s tagline describes it as "a webcomic of romance, sarcasm, math, and language."</p>
              <p>Skip to comic # <input id="comicnumselect" type="text" class="form-control" placeholder="1-'.$begin.'")"></p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>