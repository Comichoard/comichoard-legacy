<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://www.penny-arcade.com/comic';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h5><a href="/" title="Penny Arcade">Penny Arcade</a></h5>', $result);
        $first2 =  explode('<a href=\'', $first1[1]);
        $first3 =  explode('\'', $first2[1]);
        $url = $first3[0];
        return $url;
    }

    function getcomic($url)   {
        global $sendback,$comic;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first = explode('<img src="http://art.penny-arcade.com', $result);
        $second = explode('</a>', $first[1]);
        $alt=explode('penny-arcade.com/comic/',$url);
        $alt[1]=str_replace('/','-',substr($alt[1],0,10));
        $src = explode('"',$second[0]);

        $urlfirst = explode('<a class="btn btnPrev" href="', $result);
        $urlsecond = explode('"', $urlfirst[1]);
        
        $jsoncomic = '{"comic":"Penny Arcade","image":"http://art.penny-arcade.com'.$src[0].'","desc":"'.$alt[1].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($urlsecond[0]).'"}';
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