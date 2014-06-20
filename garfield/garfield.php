<?php
    $all = array();
    $comic = str_replace('.php','',substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
    $url = date('Y-m-d');
    $url = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($url) ) ));

    function getcomic($date)   {
        global $all,$comic;
        array_push($all, '<div class="well"><img alt="Garfield '.$date.'" src="http://garfield.com/uploads/strips/'.$date.'.jpg" width="900"><div class="details"><span>'.$date.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($date).'">Share</span></div></div>');
        return date('Y-m-d',(strtotime ( '-1 day' , strtotime ($date) ) ));
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($all,'<div class="jumbotron">More comics from Garfield...</div>');
        }
        else    {
            for($i=0;$i<1;$i++)   {
                $url = getcomic($url);
            }
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Garfield <a href="http://www.garfield.com/comic" type="button" class="btn btn-default" target="_blank">Go to site</a><a class="fb-like btn btn-default" data-href="http://comichoard.com/'.$comic.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
              <p>Garfield is a comic strip created by Jim Davis.<br>
              It chronicles the life of the title character, the cat Garfield; his owner, Jon Arbuckle; and Jon\'s dog, Odie.</p>
              <p>Skip to comic from <input id="comicdateselect" type="date" class="form-control"></p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>