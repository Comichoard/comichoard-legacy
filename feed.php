<?php
    $comiclist = array();
    array_push($comiclist,"cyanideandhappiness","calvinandhobbes","toonhole","maximumble","garfield","channelate","buttersafe","smbc","xkcdcomic","pcweenies","poorlydrawnlines");
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
        $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/equinox/'.$now.'/'.$now.'.php';
        if(isset($goagain[0]))
            $url .= '?comic='.$goagain[0];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
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
    $card = explode('"card">',$result);
    preg_match('/<span>(.*?)<\/span>/',$result, $altreplace);
    $card[1] = str_replace($altreplace[0],'<span>'.$title[0].'</span>',$card[1]);
    echo $next.'!round'.$round.'!znavfu'.'<div class="card" data-comic="'.$now.'">'.$card[1];
?>