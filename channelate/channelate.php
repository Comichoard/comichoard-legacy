<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.channelate.com/';

    function getcomic($url)   {
        global $all,$comic;
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
        $first = explode('<img src="http://www.channelate.com/comics/', $result);
        $second = explode('</div>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $image = '<div class="well">'.'<img src="http://www.channelate.com/comics/'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('alt="','alt="Channelate: ', $image);
        array_push($all, $image);

        $urlfirst = explode('<td class="comic_navi_left">', $result);
        $urlsecond = explode('<a href="', $urlfirst[1]);
        $urlthird = explode('"', $urlsecond[2]);

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
            array_push($all,'<div class="jumbotron">More comics from Channelate...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Channelate <a href="http://www.channelate.com" type="button" class="btn btn-default" target="_blank">Go to site</a><a class="fb-like btn btn-default" data-href="http://comichoard.com/'.$comic.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              <p>A gag-per-day strip by Ryan Hudson (and sometimes his wife, Vee).<br>This comic makes heavy use of dark humor and is not recommended for the easily offended.</p></div>';
        foreach($all as $item) echo $item;
    }
?>