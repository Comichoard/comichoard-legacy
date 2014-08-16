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
        if(strip_tags($second[0],'<img>') != 'There is no comic with this ID.')
            array_push($sendback, '<div class="card">'.strip_tags($second[0],'<img>').'</div>');
        return $i-1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$sendback[0];
    }
    else    {
        $i=getcomic(getfirst());
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Shortpacked 
                <a href="http://shortpacked.com/" type="button" class="btn btn-default" target="_blank">www.shortpacked.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Get official Shortpacked merchandise at <a href="http://shortpacked.bigcartel.com/" class="btn btn-default" target="_blank">www.shortpacked.bigcartel.com</a></p>
              </div>';
        echo $sendback;
    }
?>