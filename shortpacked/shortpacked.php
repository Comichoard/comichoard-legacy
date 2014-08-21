<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    
    function getfirst() {
        $url = 'http://www.shortpacked.com/index.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<a href="/index.php?id=', $result);
        $first2 =  explode('"', $first1[2]);

        return (intval($first2[0])+1);
    }

    function getcomic($i)   {
        global $sendback,$comic;
        $url = 'http://www.shortpacked.com/index.php?id='.$i;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<div id="comicbody">', $result);
        $second = explode('</div>', $first[1]);
        $second[0]=strip_tags($second[0],'<img>');
        $srcbig = explode('src="',$second[0]); 
        $src = explode('"',$srcbig[1]);
        $next=$i-1;

        if(strip_tags($second[0],'<img>') != 'There is no comic with this ID.')
            $sendback = '{"comic":"Shortpacked","image":"'.$src[0].'","desc":"# '.$i.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($i).'","next":"'.base64_encode($next).'"}';
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