<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.toonhole.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h2>', $result);
        $first2 =  explode('<a href="', $first1[1]);
        $first3 =  explode('"', $first2[1]);
        $url = $first3[0];
    }

    function getcomic($url)   {
        global $all,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first = explode('<div id="comic">', $result);
        $second = explode('</div>', $first[1]);
        $second[0] = str_replace('href', 'target="_blank" href', $second[0]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $second[0]=strip_tags($second[0],'<img>');
        $image = '<div class="card">'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('alt="','alt="Toonhole: ', $image);
        array_push($all, $image);

        $urlfirst = explode('<div id="mini_nav">', $result);
        $urlsecond = explode('<a href="', $urlfirst[1]);
        $urlthird = explode('"', $urlsecond[1]);

        return $urlthird[0];
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($all,'<div class="jumbotron">More comics from Toonhole...</div>');
        }
        else    {
            getfirst();
            $url = getcomic($url);
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Toonhole <a href="http://www.toonhole.com" type="button" class="btn btn-default" target="_blank">www.toonhole.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              </div>';
        foreach($all as $item) echo $item;
    }
?>