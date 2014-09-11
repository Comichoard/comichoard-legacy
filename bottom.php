<div class="social">
	<a class="fa fa-facebook" href="https://facebook.com/comichoard" target="_blank"></a>
    <a class="fa fa-twitter" href="https://twitter.com/ComicHoard" target="_blank"></a>
</div>

<div id="scrolldown"><i class="fa fa-backward"></i><i class="fa fa-play"></i><i class="fa fa-forward"></i></div>
<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>

<input id="firstcomic" type="hidden" value="<?php if(isset($firstcomic[0])) echo base64_encode($firstcomic[0]);?>">
<input id="source" type="hidden" value="<?php if(isset($source)) echo $source;?>">
<input id="sort" type="hidden" value="<?php if(isset($sort)) echo $sort;?>">
<input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">

<script>
    var sort = $("#sort").val();
    var source = $("#source").val();
    var website = $("#website").val();
    var firstcomic = $('#firstcomic').val();
    var flag = 0;
</script>