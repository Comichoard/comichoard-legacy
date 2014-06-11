<div class="thumbup" data-href="jl8">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xpf1/t1.0-9/16084_284396851680947_494939775_n.jpg">
	</div>
	<div class="thumbname">JL8</div>
</div>

<div class="thumbup" data-href="cyanideandhappiness">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-b-a.akamaihd.net/hphotos-ak-xfp1/t1.0-9/1476312_10152729057010476_659501497_n.jpg">
	</div>
	<div class="thumbname">Cyanide &amp; Happiness</div>
</div>

<div class="thumbup" data-href="calvinandhobbes">
	<div class="thumb">
		<img src="http://upload.wikimedia.org/wikipedia/en/thumb/b/b2/Calvin_and_Hobbes_Original.png/275px-Calvin_and_Hobbes_Original.png">
	</div>
	<div class="thumbname">Calvin and Hobbes</div>
</div>

<div class="thumbup" data-href="garfield">
	<div class="thumb">
		<img src="https://scontent-b.xx.fbcdn.net/hphotos-xfp1/t1.0-9/10430820_10152187715905847_8044973747742160917_n.jpg">
	</div>
	<div class="thumbname">Garfield</div>
</div>

<div class="thumbup" data-href="xkcdcomic">
	<div class="thumb">
		<img src="https://s3.amazonaws.com/static.fitocracy.com/site_media/images/xkcd-logo.jpg" style="height:150px;width:230px;position:relative;left:-40px">
	</div>
	<div class="thumbname">XKCD</div>
</div>

<div class="thumbup" data-href="channelate">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xaf1/t1.0-9/10245474_10152341775225675_8549029901616632783_n.png">
	</div>
	<div class="thumbname">Channelate</div>
</div>

<div class="thumbup" data-href="maximumble">
	<div class="thumb">
		<img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/p160x160/1897874_714128748618163_1375949339_a.jpg">
	</div>
	<div class="thumbname">Maximumble</div>
</div>

<div class="thumbup" data-href="buttersafe">
	<div class="thumb">
		<img src="http://buttersafe.com/images/ButtersafeLogo.png" style="height:180px;width:380px;position:relative;left:-123px;top:10px;z-index:3">
	</div>
	<div class="thumbname">Buttersafe</div>
</div>

<div class="thumbup" data-href="pcweenies">
	<div class="thumb">
		<img src="http://robot6.comicbookresources.com/wp-content/uploads/2011/05/pc-weenies.jpg">
	</div>
	<div class="thumbname">PC Weenies</div>
</div>

<div class="thumbup" data-href="poorlydrawnlines">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xaf1/t1.0-9/206890_209869635709223_2035565_n.jpg">
	</div>
	<div class="thumbname">Poorly Drawn Lines</div>
</div>

<div class="thumbup" data-href="pennyarcade">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-ash2/t1.0-9/1098000_10151923662484705_9519592_n.jpg">
	</div>
	<div class="thumbname">Penny Arcade</div>
</div>

<div class="thumbup" data-href="spikedmath">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-b-a.akamaihd.net/hphotos-ak-ash2/t1.0-9/581453_10150774309267235_1506624257_n.jpg">
	</div>
	<div class="thumbname">Spiked Math</div>
</div>

<div class="thumbup" data-href="shortpacked">
	<div class="thumb">
		<img src="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xap1/t1.0-9/13224_10151329003914601_870855877_n.png">
	</div>
	<div class="thumbname">Shortpacked</div>
</div>

<script>
	$('.thumbup').hover(function()	{
		$(this).children('.thumb').animate({top:'-=40px'},200);
	},function()	{
		$(this).children('.thumb').animate({top:'+=40px'},200);
	});

	$(document).on('click','.thumbup',function()	{
		window.open($(this).attr('data-href'),'_blank');
	});
</script>