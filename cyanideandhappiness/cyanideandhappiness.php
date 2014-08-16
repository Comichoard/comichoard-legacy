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
        $url = 'http://explosm.net';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        
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
        global $sort;
        global $sendback,$comic;
        $url = 'http://explosm.net/comics/'.$i.'/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $name = explode('</nobr>',$result);
        $first = explode('overflow: auto; text-align: center;">', $result);
        $second = explode('</div>', $first[1]);
        $second[0] = str_replace(', a daily webcomic',' #'.$i,$second[0]);
        $srcbig = explode('src="',$second[0]); 
        $src = explode('"',$srcbig[1]);
        /*if($second[0] == '')    {
            $first = explode('<a href="http://explosm.net/show', $result);
            $second = explode('"><img', $first[1]);
            $url = str_replace('/autoplay','','http://explosm.net/show'.$second[0]);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $first = explode('<iframe width="728" height="410" src="//www.youtube.com/embed/', $result);
            $first2 = explode('" frameborder="0"', $first[1]);
            $second = array();
            if($first2[0]!='')
                $second[0] = '<iframe width="728" height="410" src="//www.youtube.com/embed/'.$first2[0].'" frameborder="0" allowfullscreen=""></iframe>';
            else
                $second[0] = '<h6>Comic does not exist.</h6>';
            $namebig = explode('episode/',$url);
            $name = explode('/',$namebig[1]);
            $name[0] = ucwords(str_replace('-',' ',$name[1]));
        }*/
        $next=0;
        if($sort=='asc')
            $next=$i+1;
        else
            $next=$i-1;
        $jsoncomic = '{"comic":"Cyanide and Happiness","image":"'.$src[0].'","desc":"# '.$i.'","link":"http://comichoard.com/'.$comic.'/?strip='.$i.'","next":"'.base64_encode($next).'"}';
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
            getcomic(39);
        else
            getcomic($last);
        echo $sendback;
    }
?>