<?php
    $all = array();
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
    }

    function getcomic($url)   {
        if(intval($url)<1)
            return '0';
        global $all,$comic;
        $list = file_get_contents('data.xml');
        $first = explode('">'.$url, $list);
        $second = explode('href="', $first[0]);
        $alt=explode('</a>', $first[1]);
        $imgname=$second[sizeof($second)-1];
        if($imgname[0]=='/')
            $imgname=substr($imgname,1);
        $imgname = '<img src="http://threewordphrase.com/'.str_replace('htm','gif',$imgname).'" alt="'.$url.$alt[0].'">';;
        $image = '<div class="card">'.$imgname.'<div class="details"><span>'.$url.$alt[0].'</span>'.''.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.$url.'">Share</span></div></div>';
        array_push($all, $image);

        if(intval($url)<=10)
            return '0'.intval($url)-1;
        return intval($url)-1;
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($all,'<div class="jumbotron">More comics from Three Word Phrase...</div>');
        }
        else    {
            getfirst();
            $url = getcomic($url);
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Three Word Phrase <a href="http://www.threewordphrase.com" type="button" class="btn btn-default" target="_blank">www.threewordphrase.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Get official Three Word Phrase merchandise at <a href="http://www.topatoco.com/merchant.mvc?Screen=CTGY&Store_Code=TO&Category_Code=WELCOME" class="btn btn-default" target="_blank">TWP Store</a></p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>