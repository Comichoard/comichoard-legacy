<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));

    function getcomic($i)   {
        global $all,$comic;
        $url='http://imgur.com/gallery/hot/viral/page/'.$i;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        
        $name = explode("<div class=\"inline\">&nbsp;images&nbsp;of ",$result);
        $name = explode(',', $name[1]); 
        $first = explode('<div class="posts">', $result);
        $second = explode('<div class="clear"></div>', $first[1]);
        $second[0] = strip_tags($second[0],'<img>');
        $second = explode('src="',$second[0]);

        $imgstring='';
        for($j=1;$j<sizeof($second);$j+=1) {
            $src=explode('pspan', $second[$j]);
            $imgstring.='<img src="'.$src[0].'">';
        }
        array_push($all, '<div class="well">'.$imgstring.'<div class="details"><span>'.ucwords($name[0]).'</span><span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.$url.'">Share</span></div></div>');

        return $i+1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic($_GET['strip']);
            array_push($all,'<div class="jumbotron">More comics from imgur...</div>');
            $count--;
        }
        $url=getcomic(0);
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Best of Imgur <a href="http://imgur.com/" type="button" class="btn btn-default" target="_blank">Go to site</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
        <p>Click to preview</p></div>';
        foreach($all as $item) echo $item;
    }
?>