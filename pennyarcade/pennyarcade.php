<?php
    $all = array();
    $url = 'http://www.penny-arcade.com/comic';

    function getcomic($url)   {
        global $all;
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
        $first = explode('<img src="http://art.penny-arcade.com', $result);
        $second = explode('</a>', $first[1]);
        
        array_push($all, '<div class="well">'.'<img src="http://art.penny-arcade.com'.$second[0].'</div>');

        $urlfirst = explode('<a class="btn btnPrev" href="', $result);
        $urlsecond = explode('"', $urlfirst[1]);

        return $urlsecond[0];
    }

    if(isset($_GET['comic'])) {
        $url = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($url).'!znavfu';
        echo $all[0];
    }
    else    {
        for($i=0;$i<2;$i++)   {
            $url = getcomic($url);
        }
        echo base64_encode($url).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Penny Arcade <a href="http://www.penny-arcade.com/" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Penny Arcade is a webcomic focused on video games and video game culture, written by Jerry Holkins and illustrated by Mike Krahulik.<br>
              It is among the most popular and longest running gaming webcomics currently online.</p></div>';
        foreach($all as $item) echo $item;
    }
?>