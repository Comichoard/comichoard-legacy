<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $sort='desc';
    if(isset($_GET['sort']))    {
        if($_GET['sort']=='asc')    {
            $sort='asc';
        }
    }

    function getfirst() {
        $url = 'http://www.twogag.com';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('property="og:url" content="http://www.twogag.com/archives/', $result);
        $first2 =  explode('"', $first1[1]);
        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $sendback,$comic,$sort;
        $ch = curl_init('http://www.twogag.com/archives/'.$i);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first = explode('id="comic">', $result);
        $second = explode('</a>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $second[0]=strip_tags($second[0],'<img>');
        $srcbig = explode('src="',$second[0]); 
        $src = explode('"',$srcbig[1]);

        if($sort=='asc')
        {
            $urlfirst = explode('class="comic_navi_right">', $result);
            $urlsecond = explode('href="', $urlfirst[1]);
            $urlthird = explode('"', $urlsecond[1]);
        }
        else
        {
            $urlfirst = explode('class="comic_navi_left">', $result);
            $urlsecond = explode('href="', $urlfirst[1]);
            $urlthird = explode('"', $urlsecond[2]);
        }
        
        $urlfourth = explode('archives/', $urlthird[0]);
        $next = explode('"', $urlfourth[1]);

        $jsoncomic = '{"comic":"Two Guys and Guy","image":"'.$src[0].'","desc":"'.$alt[0].'","link":"http://comichoard.com/'.$comic.'/?strip='.$i.'","next":"'.base64_encode($next[0]).'"}';
        $sendback=$jsoncomic;
    }


    if(isset($_GET['next']) and $_GET['next']!='') {
        getcomic(base64_decode($_GET['next']));
        echo $sendback;
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic($_GET['strip']);
        }
        $last=getfirst();
        if($sort=='asc')
            getcomic(4);
        else
            getcomic($last);
        echo $sendback;
    }
?>