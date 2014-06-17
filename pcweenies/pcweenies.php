<?php
    $all = array();
    $url = 'http://pcweenies.com/';

    function getcomic($url)   {
        global $all;
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
        $first = explode('<img src="http://pcweenies.com/wp-content/uploads/', $result);
        $second = explode('</div>', $first[2]);
        $altbig = explode('pcw.jpg',$first[2]); 
        $alt = substr($altbig[0],8,10); 
        $image = '<div class="well">'.'<img src="http://pcweenies.com/wp-content/uploads/'.$second[0].'<div class="details"><span>'.$alt.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('src=','alt="PC Weenies '.$alt.'" src=', $image);
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
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>PC Weenies <a href="http://pcweenies.com/" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>The PC Weenies is a webcomic with a focus on technology humor and geek culture, as experienced through the lives of the Weiner family.
              <br>The PC Weenies was created and launched on the web in October 1998 by Krishna M. Sadasivam</p></div>';
        foreach($all as $item) echo $item;
    }
?>