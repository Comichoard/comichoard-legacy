<?php
    $sendback = '';
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = date('Y-m-d');
    $url = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($url) ) ));

    function getcomic($date)   {
        global $sendback,$comic;
        array_push($sendback, '<div class="card"><img alt="Garfield '.$date.'" src="http://garfield.com/uploads/strips/'.$date.'.jpg" width="900"><div class="details"><span>'.$date.'</span>'.'<span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="http://comichoard.com/'.$comic.'/?strip='.base64_encode($date).'">Share</span></div></div>');
        return date('Y-m-d',(strtotime ( '-1 day' , strtotime ($date) ) ));
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $sendback[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($sendback,'<div class="jumbotron">More comics from Garfield...</div>');
        }
        else
        $url = getcomic($url);
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc">
                <h1>Garfield <a href="http://www.garfield.com/comic" type="button" class="btn btn-default" target="_blank">www.garfield.com</a>
                <a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                <p>Skip to comic from <input id="comicdateselect" type="date" class="form-control">Get official Garfield merchandise at <a href="http://garfield.com/shop" class="btn btn-default" target="_blank">www.garfield.com/shop</a></p>
              </div>';
        echo $sendback;
    }
?>