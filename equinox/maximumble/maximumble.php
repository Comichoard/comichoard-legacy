<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://maximumble.thebookofbiff.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h2 class="post-title">', $result);
        $first2 =  explode('<a href="', $first1[1]);
        $first3 =  explode('"', $first2[1]);
        $url = $first3[0];
    }

    function getcomic($url)   {
        global $all,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<img src="http://maximumble.thebookofbiff.com/comics', $result);
        $second = explode('</a>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $image = '<div class="card">'.'<img src="http://maximumble.thebookofbiff.com/comics'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('alt="','alt="Maximumble ', $image);
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
            array_push($all,'<div class="jumbotron">More comics from Maximumble...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                getfirst();
        $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Maximumble <a href="http://maximumble.thebookofbiff.com" type="button" class="btn btn-default" target="_blank">www.maximumble.thebookofbiff.com</a>
        <a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              </div>';
        foreach($all as $item) echo $item;
    }
?>