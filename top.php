<div id="top" class="panel-heading">
    <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
        <span>Comic</span> Hoard
    </a>
    <a id="comicselect-btn" class="btn btn-default btn-lg" data-toggle="modal" data-target="#comicselect">
        Select Comic To Read
    </a>
    <?php
        if($source=='feed')   {
            echo '<a id="fbpage" href="contact.php" class="btn btn-default btn-lg" target="_blank">Contact us</a>';
        }
        if(isset($_COOKIE[$source]) && $source!='feed')    {
            echo '<a id="resume" type="button" class="btn btn-default btn-lg" data-del="yes">Resume</a>';
        }
    ?>
</div>