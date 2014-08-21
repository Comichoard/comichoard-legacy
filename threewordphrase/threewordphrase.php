<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = '1';

    function getfirst() {
        global $url;
        $ch = curl_init('http://threewordphrase.com/archive.htm');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<span class="links">', $result);
        $first2 =  explode('</span>', $first1[1]);

        $check1 = explode('>', $first2[0]);
        $check2 = explode('.', $check1[1]);

        if(file_exists('data.xml')) {
            $list = file_get_contents('data.xml');
            $checklist1 = explode('>', $list);
            $checklist2 = explode('.', $checklist1[1]);
            if($check2[0]!=$checklist2[0])  {
                file_put_contents('data.xml', $first2[0]);
            }
        }
        $url=$check2[0];
        return $url;
    }

    function getcomic($url)   {
        if(intval($url)<1)
            return '0';
        global $sendback,$comic;
        $list = file_get_contents('data.xml');
        $first = explode('">'.$url, $list);
        $second = explode('href="', $first[0]);
        $alt=explode('</a>', $first[1]);
        $imgname=$second[sizeof($second)-1];
        if($imgname[0]=='/')
            $imgname=substr($imgname,1);
        $imgname = '<img src="http://threewordphrase.com/'.str_replace('htm','gif',$imgname).'" alt="'.$url.$alt[0].'">';;
        $srcbig = explode('src="',$imgname);
        $src = explode('"',$srcbig[1]);

        if(intval($url)<=10)
            $next='0'.intval($url)-1;
        $next=intval($url)-1;

        $jsoncomic = '{"comic":"Three Word Phrase","image":"'.$src[0].'","desc":"'.$url.$alt[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'","next":"'.base64_encode($next).'"}';
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