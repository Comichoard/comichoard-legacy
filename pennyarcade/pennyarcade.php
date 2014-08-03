<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.penny-arcade.com/comic';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h5><a href="/" title="Penny Arcade">Penny Arcade</a></h5>', $result);
        $first2 =  explode('<a href=\'', $first1[1]);
        $first3 =  explode('\'', $first2[1]);
        $url = $first3[0];
    }

    function getcomic($url)   {
        global $all,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first = explode('<img src="http://art.penny-arcade.com', $result);
        $second = explode('</a>', $first[1]);
        $alt=explode('penny-arcade.com/comic/',$url);
        $alt[1]=str_replace('/','-',substr($alt[1],0,10));
        array_push($all, '<div class="card">'.'<img src="http://art.penny-arcade.com'.$second[0].'<div class="details"><span>'.$alt[1].'</span>'.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'">Share</span></div></div>');

        $urlfirst = explode('<a class="btn btnPrev" href="', $result);
        $urlsecond = explode('"', $urlfirst[1]);
        return $urlsecond[0];
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $all[0];
    }
    else    {
        getfirst();
        $url = getcomic($url);
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Penny Arcade <a href="http://www.penny-arcade.com/" type="button" class="btn btn-default" target="_blank">www.penny-arcade.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Get official Penny Arcade merchandise at <a href="http://store.penny-arcade.com/" class="btn btn-default" target="_blank">www.store.penny-arcade.com</a></p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>