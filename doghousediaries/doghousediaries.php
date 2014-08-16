<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = 'http://thedoghousediaries.com/';

    function getfirst() {
        global $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $first1 = explode('<div id="comic-', $result);
        $first2 =  explode('"', $first1[1]);
        $url = $first2[0];
    }

    function getcomic($url)   {
        global $sendback,$comic;
        $ch = curl_init('http://thedoghousediaries.com/'.$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    
        $first = explode('<div class="object">', $result);
        $second = explode('</div>', $first[1]);
        $altbig = explode('alt="',$second[0]); 
        $alt = explode('"',$altbig[1]); 
        $second[0]=strip_tags($second[0],'<img>');
        $image = '<div class="card">'.$second[0].'<div class="details"><span>'.$alt[0].'</span>'.''.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($url).'">Share</span></div></div>';
        $image = str_replace('alt="','alt="Doghouse Diaries: ', $image);
        array_push($sendback, $image);

        $urlfirst = explode('<div class="navi navi-comic navi-comic-above">', $result);
        $urlsecond = explode('<a href="http://thedoghousediaries.com/', $urlfirst[1]);
        $urlthird = explode('"', $urlsecond[2]);

        return $urlthird[0];
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $sendback[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($sendback,'<div class="jumbotron">More comics from Doghouse Diaries...</div>');
        }
        else    {
            getfirst();
            $url = getcomic($url);
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc">
                <h1>Doghouse Diaries <a href="http://thedoghousediaries.com" type="button" class="btn btn-default" target="_blank">www.thedoghousediaries.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Get official Doghouse Diaries merchandise at <a href="http://www.cafepress.com/adventurefactory" class="btn btn-default" target="_blank">www.cafepress.com/adventurefactory</a></p>
              </div>';
        echo $sendback;
    }
?>