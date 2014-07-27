<?php
    if(isset($_POST['source']) && isset($_POST['position'])) {
        setcookie($_POST['source'],$_POST['position'],time()+3600*24*365);
        echo 'done';
    }

    if(isset($_POST['source']) && isset($_POST['getpos'])) {
        if(isset($_COOKIE[$_POST['source']]))
            echo $_COOKIE[$_POST['source']];
        else
            echo 'notsaved';
    }
?>