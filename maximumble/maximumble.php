<?php
    $all = array();
    $url = 'http://maximumble.thebookofbiff.com/';

    function getcomic($url)   {
        global $all;
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
        $first = explode('<img src="http://maximumble.thebookofbiff.com/comics', $result);
        $second = explode('</a>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $image = '<div class="well">'.'<img src="http://maximumble.thebookofbiff.com/comics'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($url).'">Share</span></div></div>';
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
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Maximumble <a href="http://maximumble.thebookofbiff.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Maximumble is a brilliantly drawn webcomic by Chris Hallbeck.<br>It portrays the author\'s hilarious view on day to day life.</p></div>';
        foreach($all as $item) echo $item;
    }
?>