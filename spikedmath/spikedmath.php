<?php
    $all = array();

    function getfirst() {
        $url = 'http://spikedmath.com';
        $data = array('nothing' => 'blahblah');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $first1 = explode('<h1 id="page-title" class="asset-name entry-title">', $result);
        $first2 =  explode('</h1>', $first1[1]);

        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $all;
        $url = 'http://spikedmath.com/'.$i.'.html';
        $data = array('nothing' => 'blahblah');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    
        $first = explode('<img src="http://spikedmath.com/comics', $result);
        $second = explode('</center>', $first[1]);
        $namebig = explode('alt="Spiked Math Comic - ',$second[0]);
        $name = explode('"',$namebig[1]);
        array_push($all, '<div class="well">'.'<img src="http://spikedmath.com/comics'.$second[0].'<div class="details"><span>#'.$i.'</span><span>'.$name[0].'</span><span class="s btn btn-default btn-sm" data-share="'.$i.'">Share</span></div></div>');
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
        $begin = getfirst();
        for($i=$begin;$i>$begin-2;$i--)   {
            getcomic($i);
        }
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Spiked Math <a href="http://spikedmath.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Spiked Math Comics, a math comic dedicated to humor, educate and entertain the geek in you.<br>Beware though, there might be some math involved .</p></div>';
        foreach($all as $item) echo $item;
    }
?>