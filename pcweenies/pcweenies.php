<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://pcweenies.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<span class="widget-title">The Story</span>', $result);
        $first2 =  explode('<a href="', $first1[1]);
        $first3 =  explode('"', $first2[1]);
        $url = $first3[0];
    }
    
    function getcomic($url)   {
        global $all,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<img src="http://pcweenies.com/wp-content/uploads/', $result);
        $second = explode('</div>', $first[2]);
        $altbig = explode('pcw.jpg',$first[2]); 
        $alt = substr($altbig[0],8,10); 
        $image = '<div class="card">'.'<img src="http://pcweenies.com/wp-content/uploads/'.$second[0].'<div class="details"><span>'.$alt.'</span>'.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('src=','alt="PC Weenies: '.$alt.'" src=', $image);
        array_push($all, $image);

        $urlfirst = explode('<td class="comic-nav">', $result);
        $urlsecond = explode('href="', $urlfirst[2]);
        $urlthird = explode('"',$urlsecond[1]);

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
            array_push($all,'<div class="jumbotron">More comics from PC Weenies...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                getfirst();
        $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>PC Weenies 
                <a href="http://pcweenies.com/" type="button" class="btn btn-default" target="_blank">www.pcweenies.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Get official PCWeenies merchandise at <a href="http://pcweenies.bigcartel.com/" class="btn btn-default" target="_blank">www.pcweenies.bigcartel.com</a></p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>