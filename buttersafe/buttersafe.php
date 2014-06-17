<?php
    $all = array();
    $url = 'http://www.buttersafe.com/';

    function getcomic($url)   {
        global $all;
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
        $first = explode('<div id="comic">', $result);
        $second = explode('</div>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $image = '<div class="well">'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('alt="','alt="Buttersafe: ', $image);
        array_push($all, $image);

        $urlfirst = explode('<div id="headernav">', $result);
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
            array_push($all,'<div class="jumbotron">More comics from Buttersafe...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Buttersafe <a href="http://www.buttersafe.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>"A comic that contains pictures and sometimes words. Nothing else is guaranteed.<br>It is authored by Raynato Castro and Alex Culang."</p></div>';
        foreach($all as $item) echo $item;
    }
?>