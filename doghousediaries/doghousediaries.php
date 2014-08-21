<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://thedoghousediaries.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode("<a id='latestlink' href='http://thedoghousediaries.com/", $result);
        $first2 =  explode("'", $first1[1]);
        $url = $first2[0];
        return $url;
    }

    function getcomic($url)   {
        global $sendback,$comic;
        $ch = curl_init('http://thedoghousediaries.com/'.$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first = explode('<div id="imgdiv" style="text-align:center; margin-bottom:0px;">', $result);
        $second = explode('</div>', $first[1]);
        $altbig = explode("title='",$second[0]); 
        $alt = explode("'",$altbig[1]); 
        $second[0]=strip_tags($second[0],'<img>');

        $srcbig = explode("src='",$second[0]); 
        $src = explode("'",$srcbig[1]);
        $src[0]=substr($src[0],0,-1);

        $urlfirst = explode("<a id='previouslink' href='http://thedoghousediaries.com/", $result);
        $urlsecond = explode("'", $urlfirst[1]);

        $jsoncomic = '{"comic":"Doghouse Diaries","image":"http://thedoghousediaries.com/'.$src[0].'","desc":"'.$alt[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($urlsecond[0]).'"}';
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