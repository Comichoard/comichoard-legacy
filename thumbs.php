<style>.thumb-container{width:43%;text-align:justify;}@media screen and (max-width:768px) {.thumb-container{visibility:hidden;position: absolute;opacity: 0}}</style>
<span class="thumb-container">
	<div class="btn btn-default" data-href="jl8">JL8</div>
	<div class="btn btn-default" data-href="xkcdcomic">XKCD</div>
	<div class="btn btn-default" data-href="toonhole">Toonhole</div>
	<div class="btn btn-default" data-href="maximumble">Maximumble</div>
	<div class="btn btn-default" data-href="channelate">Channelate</div>
	<div class="btn btn-default" data-href="garfield">Garfield</div>
	<div class="btn btn-default" data-href="cyanideandhappiness">Cyanide &amp; Happiness</div>
	<div class="btn btn-default" data-href="buttersafe">Buttersafe</div>
	<div class="btn btn-default" data-href="smbc">SMBC</div>
	<div class="btn btn-default" data-href="spikedmath">Spiked Math</div>
	<div class="btn btn-default" data-href="pcweenies">PC Weenies</div>
	<div class="btn btn-default" data-href="calvinandhobbes">Calvin and Hobbes</div>
	<div class="btn btn-default" data-href="poorlydrawnlines">Poorly Drawn Lines</div>
	<div class="btn btn-default" data-href="pennyarcade">Penny Arcade</div>
	<div class="btn btn-default" data-href="shortpacked">Shortpacked</div>
</span>
<span class="thumb-container pull-right">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=659591854119619&version=v2.0";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
	<div>
		<p style="margin-bottom:20px">We survive on likes. Be nice.</p>
		<div class="fb-like" data-href="https://www.facebook.com/comichoard" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	</div>
</span>
<script>
	$(document).on('click','.thumb-container>.btn',function()	{
		window.location.href = $(this).attr('data-href');
	});
</script>