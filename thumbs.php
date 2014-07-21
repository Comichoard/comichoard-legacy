<div class="thumb-container">
	<div class="btn btn-default" data-href="jl8">JL8</div>
	<div class="btn btn-default" data-href="xkcdcomic">XKCD</div>
	<div class="btn btn-default" data-href="toonhole">Toonhole</div>
	<div class="btn btn-default" data-href="maximumble">Maximumble</div>
	<div class="btn btn-default" data-href="spikedmath">Spiked Math</div>
	
	<div class="btn btn-default" data-href="garfield">Garfield</div>
	<div class="btn btn-default" data-href="pennyarcade">Penny Arcade</div>
	<div class="btn btn-default" data-href="shortpacked">Shortpacked</div>
	<div class="btn btn-default" data-href="pcweenies">PC Weenies</div>
	<div class="btn btn-default" data-href="buttersafe">Buttersafe</div>
	<div class="btn btn-default" data-href="calvinandhobbes">Calvin and Hobbes</div>
	<div class="btn btn-default" data-href="cyanideandhappiness">Cyanide &amp; Happiness</div>
	<div class="btn btn-default" data-href="channelate">Channelate</div>
	<div class="btn btn-default" data-href="smbc">SMBC</div>
	<div class="btn btn-default" data-href="poorlydrawnlines">Poorly Drawn Lines</div>
</div>
<script>
	$(document).on('click','.thumb-container>.btn',function()	{
		window.location.href = $(this).attr('data-href');
	});
</script>