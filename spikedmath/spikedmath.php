<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));

    function getfirst() {
        return 560;
        $url = 'http://spikedmath.com';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<h1 id="page-title" class="asset-name entry-title">', $result);
        $first2 =  explode('</h1>', $first1[1]);

        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $sendback,$comic;
        $url = 'http://spikedmath.com/'.$i.'.html';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<img src="http://spikedmath.com/comics', $result);
        $second = explode('</center>', $first[1]);
        $namebig = explode('alt="Spiked Math Comic - ',$second[0]);
        $name = explode('"',$namebig[1]);
        $src = explode('"',$second[0]);
        
        $jsoncomic = '{"comic":"Spiked Math","image":"http://spikedmath.com/comics'.$src[0].'","desc":"# '.$i.' '.$name[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($i).'","next":"'.base64_encode($i-1).'"}';
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