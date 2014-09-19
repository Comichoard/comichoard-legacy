<?php
    $comiclist = array();
    array_push($comiclist,"cyanideandhappiness","pearlsbeforeswine","toonhole","maximumble","garfield","channelate","buttersafe","xkcdcomic","doghousediaries","pcweenies","smbc","threewordphrase","mercworks","poorlydrawnlines");
    $goagain = array();
    $round=1;
    if(isset($_GET['next']))   {
        $front = explode('!round',$_GET['next']);
        $now = base64_decode($front[0]);
        $round = $front[1];
    }
    else    {
        $now = $comiclist[0];
    }
    
    $count = $round;
    while($count)   {
        $server = $_SERVER['HTTP_HOST'];
        if($server=='localhost')
            $server.='/comichoard';
        $url = 'http://'.$server.'/'.$now.'/'.$now.'.php';
        if(isset($goagain[0]))
            $url .= '?next='.$goagain[0];
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

    $jsoncomic = explode('}', $result);    
    $jsoncomic[0].='}';
    $data=json_decode($jsoncomic[0]);
    $data->{"next"}=$next.'!round'.$round;
    echo json_encode($data);
?>