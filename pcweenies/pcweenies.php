<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://pcweenies.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<span class="widget-title">The Story</span>', $result);
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
    
        $first = explode('<img src="http://pcweenies.com/wp-content/uploads/', $result);
        $second = explode('</div>', $first[2]);
        $altbig = explode('pcw.jpg',$first[2]); 
        $alt = substr($altbig[0],8,10);
        $src = explode('"',$second[0]);

        $urlfirst = explode('<td class="comic-nav">', $result);
        $urlsecond = explode('href="', $urlfirst[2]);
        $urlthird = explode('"',$urlsecond[1]);

        $jsoncomic = '{"comic":"PC Weenies","image":"http://pcweenies.com/wp-content/uploads/'.$src[0].'","desc":"'.$alt.'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($urlthird[0]).'"}';
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