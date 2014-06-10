<?php
    $comiclist = array();
    array_push($comiclist, "cyanideandhappiness","calvinandhobbes","garfield","xkcdcomic","jl8","channelate","maximumble","pcweenies","poorlydrawnlines");
    $goagain = array();
    $round=1;
    if(isset($_GET['comic']))   {
        $front = explode('!round',$_GET['comic']);
        $now = base64_decode($front[0]);
        $round = $front[1];
    }
    else    {
        $now = $comiclist[0];
    }
    
    $count = $round;
    while($count)   {
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$now.'/'.$now.'.php';
        if(isset($goagain[0]))
            $url .= '?comic='.$goagain[0];
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
        $goagain = explode('!znavfu',$result);
        $count--;
    }
    $next =  base64_encode($comiclist[array_search($now,$comiclist)+1]);
    if($now == $comiclist[sizeof($comiclist)])  {
        $next =  base64_encode($comiclist[0]);
        $round++;
    }

    preg_match('/alt="(.*?)"/',$result, $title);
    $title[0] = substr($title[0],5,sizeof($title[0])-2);
    $well = explode('"well">',$result);
    preg_match('/<span>(.*?)<\/span>/',$result, $altreplace);
    $well[1] = str_replace($altreplace[0],'<span>'.$title[0].'</span>',$well[1]);
    echo $next.'!round'.$round.'!znavfu'.'<div class="well" data-comic="'.$now.'">'.$well[1].'</div>';
?>