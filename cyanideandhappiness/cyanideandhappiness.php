<?php
    $all = array();

    function getfirst() {
        $url = 'http://explosm.net';
        $data = array('nothing' => 'blahblah');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        $first1 = explode('http://www.explosm.net/comics/', $result);
        $first2 =  explode('/', $first1[1]);
        if($first2[0] == '')    {
            $basis = strtotime('2014-05-22 12:00:00');
            $diff=floor(time()-$basis)/(3600*24);
            $first2[0] = 3565 + $diff;
        }
        return intval($first2[0]);
    }

    function getcomic($i)   {
        global $all;
        $url = 'http://explosm.net/comics/'.$i.'/';
        $data = array('nothing' => 'blahblah');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $name = explode('</nobr>',$result);
        $first = explode('overflow: auto; text-align: center;">', $result);
        $second = explode('</div>', $first[1]);
        $second[0] = str_replace(', a daily webcomic',' #'.$i,$second[0]);
        if($second[0] == '')    {
            $first = explode('<a href="http://explosm.net/show', $result);
            $second = explode('"><img', $first[1]);
            $url = str_replace('/autoplay','','http://explosm.net/show'.$second[0]);
            $data = array('nothing' => 'blahblah');
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $first = explode('<iframe width="728" height="410" src="//www.youtube.com/embed/', $result);
            $first2 = explode('" frameborder="0"', $first[1]);
            $second = array();
            $second[0] = '<iframe width="728" height="410" src="//www.youtube.com/embed/'.$first2[0].'" frameborder="0" allowfullscreen=""></iframe>';
            $namebig = explode('episode/',$url);
            $name = explode('/',$namebig[1]);
            $name[0] = ucwords(str_replace('-',' ',$name[1]));
        }
        array_push($all, '<div class="well">'.$second[0].'<div class="details"><span>#'.$i.'</span><span>'.substr($name[0],-10).'</span><span class="s btn btn-default btn-lg" data-share="'.$i.'">Share</span></div></div>');
        return $i-1;
    }

    if(isset($_GET['comic'])) {
        $sendback = getcomic(base64_decode($_GET['comic']));
        echo base64_encode($sendback).'!znavfu'.$all[0];
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic($_GET['strip']);
            array_push($all,'<div class="jumbotron">More comics from Cyanide and Happiness...</div>');
            $count--;
        }
        $i=getcomic(getfirst());
        echo base64_encode($i).'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>Cyanide & Happiness <a href="http://explosm.net" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>Cyanide & Happiness is a webcomic written and illustrated by Kris Wilson, Rob DenBleyker, Matt Melvin and Dave McElfatrick.<br>The comic\'s authors attribute its success to its often controversial nature.</p></div>';
        foreach($all as $item) echo $item;
    }
?>