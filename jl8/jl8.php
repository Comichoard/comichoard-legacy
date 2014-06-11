<?php
    $all = array();

    function getfirst()     {
        $url = 'http://jl8comic.tumblr.com';
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

        preg_match('/jl8-(.*?)-/',$result, $matches);
        return substr($matches[0],4,3);
    }

    $sort = 'desc';
    function getcomic($num)   {
        global $all,$sort;
        if($num == 50)  {
            $cnt = 1;
            while($cnt != 9)    {
                array_push($all, '<div class="well"><img alt="JL8 #'.$num.'" src="http://www.limbero.org/jl8/comics/'.$num.'_'.$cnt.'.jpeg"><div class="details"><span>#'.$num.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($num).'">Share</span></div></div>');    
                $cnt++;
            }
        }
        else {
            array_push($all, '<div class="well"><img alt="JL8 #'.$num.'" src="http://www.limbero.org/jl8/comics/'.$num.'.jpeg"><div class="details"><span>#'.$num.'</span>'.'<span class="s btn btn-default btn-lg" data-share="'.base64_encode($num).'">Share</span></div></div>');
        }
        if($sort == 'desc')
            return --$num;
        else
            return ++$num;
    }

    $last=getfirst();
    $next=$last;
    if(isset($_GET['comic'])) {
        $recieved = explode('!sort',$_GET['comic']);
        $sort = $recieved[1];
        $num = base64_decode($recieved[0]);
        if($num>$last || $num<1)
            array_push($all,'<br><br><div class="jumbotron">Ran out of comics to show.<br>Here\'s something else to read <a href="http://comichoard.com/?comic=pcw" type="button" class="btn btn-default">PC Weenies</a> </div>');
        else
            $next = getcomic($num);
        echo base64_encode($next).'!sort'.$sort.'!znavfu';
        foreach($all as $item) echo $item;
    }
    else    {
        if(isset($_GET['strip']))   {
            getcomic(base64_decode($_GET['strip']));
            array_push($all,'<div class="jumbotron">More comics from JL8...</div>');
        }
        else    {
            if($_GET['sort'] == 'asc') {
                $sort = 'asc';
                $next = getcomic(1);
            }
            else    {      
                $sort = 'desc';
                $next = getcomic($last);
            }
        }
        echo base64_encode($next).'!sort'.$sort.'!znavfu';
        echo '<div class="jumbotron cdesc"><h1>JL8 <a href="http://jl8comic.tumblr.com" type="button" class="btn btn-default" target="_blank">Go to site</a></h1>
              <p>JL8 is a comic strip created by Yale Stewart. It tells tales based on younger versions of DC superheroes.</p>
              <p>
              <span>Sort in order
              <a href="http://'.$_SERVER['HTTP_HOST'].'/jl8/?sort=asc" type="button" class="btn btn-default">From the start</a>
              <a href="http://'.$_SERVER['HTTP_HOST'].'/jl8/?sort=desc" type="button" class="btn btn-default">Most recent first</a></span>
              <span>Skip to comic # <input id="comicnumselect" type="text" class="form-control" placeholder="1-'.$last.'")"></span>
              </p>
              </div>';
        foreach($all as $item) echo $item;
    }
?>