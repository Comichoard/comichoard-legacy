<style>.modal-content{border-radius:0;-o-border-radius:0;-moz-border-radius:0;-webkit-border-radius:0}.modal-header{font-size:24px;font-weight:300}.modal-body>{text-align:justify}.modal-body>.btn{padding:2%;margin:1%;margin-bottom:2%;}.modal-body>.btn:hover{background: #3498db;color: #fff;}</style>
<div id="comicselect" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <p class="modal-title">Select Comic to read</p>
      </div>
      <div class="modal-body">        
        <div class="btn btn-default btn-lg" data-href="jl8">JL8</div>
        <div class="btn btn-default" data-href="cyanideandhappiness">Cyanide &amp; Happiness</div>
        <div class="btn btn-default" data-href="calvinandhobbes">Calvin and Hobbes</div>
        <div class="btn btn-default" data-href="toonhole">Toonhole</div>
        <div class="btn btn-default" data-href="maximumble">Maximumble</div>
        <div class="btn btn-default" data-href="garfield">Garfield</div>
        <div class="btn btn-default" data-href="channelate">Channelate</div>
        <div class="btn btn-default" data-href="buttersafe">Buttersafe</div>
        <div class="btn btn-default" data-href="pennyarcade">Penny Arcade</div>
        <div class="btn btn-default btn-lg" data-href="xkcdcomic">XKCD</div>
        <div class="btn btn-default" data-href="pcweenies">PC Weenies</div>
        <div class="btn btn-default" data-href="poorlydrawnlines">Poorly Drawn Lines</div>
        <div class="btn btn-default" data-href="spikedmath">Spiked Math</div>
        <div class="btn btn-default" data-href="shortpacked">Shortpacked</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','.modal-body>.btn',function() {
    window.location.href = "http://comichoard.com/"+$(this).attr('data-href');
  });
</script>