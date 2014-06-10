<?php
    $all = array();

    function getfirst() {
        $url = 'http://www.shortpacked.com/index.php';
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

        $first1 = explode('<a href="/index.php?id=', $result);
        $first2 =  explode('"', $first1[2]);

        return (intval($first2[0])+1);
    }

    function getcomic($i)   {
        global $all;
        $url = 'http://www.shortpacked.com/index.php?id='.$i;
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
    
        $first = explode('<div id="comicbody">', $result);
        $second = explode('</div>', $first[1]);
        if(strip_tags($second[0],'<img>') != 'There is no comic with this ID.')
            array_push($all, '<div class="well">'.strip_tags($second[0],'<img>').'</div>');
        return $i-1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$all[0];
    }
    else    {
        $begin = getfirst();
        for($i=$begin;$i>$begin-2;$i--)   {
            getcomic($i);
        }
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Shortpacked <a href="http://shortpacked.com/" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Shortpacked! is a webcomic by David Willis set in a toy store.<br></p></div>';
        foreach($all as $item) echo $item;
    }
?>