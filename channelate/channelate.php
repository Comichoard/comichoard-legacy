<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.channelate.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h2 class="post-title">', $result);
        $first2 =  explode('<a href="', $first1[1]);
        $first3 =  explode('"', $first2[1]);
        $url = $first3[0];
        return $url;
    }

    function getcomic($url)   {
        global $sendback,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<img src="http://www.channelate.com/comics/', $result);
        $second = explode('</div>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]);
        $src = explode('"',$second[0]);

        $urlfirst = explode('<td class="comic_navi_left">', $result);
        $urlsecond = explode('<a href="', $urlfirst[1]);
        $urlthird = explode('"', $urlsecond[2]);

        $jsoncomic = '{"comic":"Channelate","image":"http://www.channelate.com/comics/'.$src[0].'","desc":"'.$alt[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($urlthird[0]).'"}';
        $sendback=$jsoncomic;
    }

    if(isset($_GET['next']) and $_GET['next']!='') {
        getcomic(base64_decode($_GET['next']));
    }
    elseif(isset($_GET['strip']) and $_GET['strip']!='')   {
        $next=getcomic(base64_decode($_GET['strip']));
    }
    else    {
        $url=getfirst();
        getcomic($url);
    }
    echo $sendback;
?>