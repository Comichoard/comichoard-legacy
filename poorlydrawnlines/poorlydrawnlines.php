<?php
    $all = array();
    $url = 'http://www.poorlydrawnlines.com/';

    function getcomic($url)   {
        global $all;
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
    
        $first = explode('<div id="post">', $result);
        $second = explode('</div>', $first[1]);
        $second[0] = str_replace('<p>','',$second[0]);
        $second[0] = str_replace('</p>','',$second[0]);
        $altbig = explode('alt="',$second[0]);
        $alt = explode('"',$altbig[1]);
        $alt[0] = str_replace('-',' ',$alt[0]);
        $alt[0] = str_replace('_','',$alt[0]);
        $second[0] = str_replace('alt="','alt="Poorly Drawn Lines ',$second[0]);
        
        $image = '<div class="well">'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.'<span class="s btn btn-default btn-sm" data-share="'.base64_encode($url).'">Share</span></div></div>';
        array_push($all, $image);

        $urlfirst = explode('<li class="previous">', $result);
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
            array_push($all,'<div class="jumbotron">More comics from Poorly Drawn Lines...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Poorly Drawn Lines <a href="http://poorlydrawnlines.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Poorly Drawn Lines is a webcomic by Reza Farazmand.<br>It is updated every Monday, Wednesday, and Friday.</p></div>';
        foreach($all as $item) echo $item;
    }
?>