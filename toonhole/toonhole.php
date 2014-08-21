<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.toonhole.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h2>', $result);
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

        $first = explode('<div id="comic">', $result);
        $second = explode('</div>', $first[1]);
        $second[0] = str_replace('href', 'target="_blank" href', $second[0]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $second[0]=strip_tags($second[0],'<img>');
        $srcbig = explode('src="',$second[0]); 
        $src = explode('"',$srcbig[1]);

        $urlfirst = explode('<div id="mini_nav">', $result);
        $urlsecond = explode('<a href="', $urlfirst[1]);
        $urlthird = explode('"', $urlsecond[1]);

        $jsoncomic = '{"comic":"Toonhole","image":"'.$src[0].'","desc":"'.$alt[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($urlthird[0]).'"}';
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