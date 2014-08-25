<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = date('Y-m-d');
    $url = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($url) ) ));

    function getcomic($date)   {
        global $sendback,$comic;
        $date=str_replace('-', '/', $date);
        $ch = curl_init('http://www.gocomics.com/pearlsbeforeswine/'.$date);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $meta=explode('<meta property="og:image"', $result);
        $imagebig=explode('content="', $meta[1]);
        $image=explode('"', $imagebig[1]);
        $next=date('Y-m-d',(strtotime ( '-1 day' , strtotime ($date) ) ));
        $sendback = '{"comic":"Pearls Before Swine","image":"'.$image[0].'","desc":"'.$date.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($date).'","next":"'.base64_encode($next).'"}';
    }

    if(isset($_GET['next']) and $_GET['next']!='') {
        getcomic(base64_decode($_GET['next']));
    }
    elseif(isset($_GET['strip']) and $_GET['strip']!='')   {
        $next=getcomic(base64_decode($_GET['strip']));
    }
    else    {
        getcomic($url);
    }
    echo $sendback;
?>