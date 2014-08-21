<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $source = 'smbc';

    function getfirst() {
        $url = 'http://www.smbc-comics.com/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('var num = Math.floor(Math.random()*', $result);
        $first2 =  explode(')', $first1[1]);

        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $sendback,$comic;
        $url = 'http://www.smbc-comics.com/?id='.$i.'/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $first = explode('<div id="comicimage">', $result);
        $second = explode('</div>', $first[1]);
        $srcbig = explode("src='",$second[0]); 
        $src = explode("'",$srcbig[1]);
        $jsoncomic = '{"comic":"Saturday Morning Breakfast Cereal","image":"'.$src[0].'","desc":"# '.$i.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($i).'","next":"'.base64_encode($i-1).'"}';
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