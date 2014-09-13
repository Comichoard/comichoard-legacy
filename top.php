<div id="comic-select-menu">
    <div class="content"></div>
</div>
<div id="comic-select-menu-mobile">
    <div class="content"></div><br><br>
</div>

<div id="top" class="panel-heading">
    <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
        <span>Comic</span> Hoard
    </a>
    <a id="comic-select-btn" class="btn btn-default btn-lg closed">
        Select Comic To Read
    </a>
    <a id="comic-tap-btn" class="fa fa-bars closed"></a>
    <?php
        if($source=='feed')   {
            echo '<a id="fbpage" href="contact.php" class="btn btn-default btn-lg" target="_blank">Contact us</a>';
        }
        if(isset($_COOKIE[$source]) && $source!='feed')    {
            echo '<a id="resume" type="button" class="btn btn-default btn-lg" data-del="yes">Resume</a>';
        }
    ?>
</div>