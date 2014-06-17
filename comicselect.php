<select id="selcomic" class="cd-select">
     <option value="-1" selected>Select Comic</option>
     <option value="/jl8">JL8</option>
     <option value="/cyanideandhappiness">Cyanide &amp; Happiness</option>
     <option value="/calvinandhobbes">Calvin and Hobbes</option>
     <option value="/garfield">Garfield</option>
     <option value="/xkcdcomic">XKCD</option>
     <option value="/channelate">Channelate</option>
     <option value="/maximumble">Maximumble</option>
     <option value="/buttersafe">Buttersafe</option>
     <option value="/pcweenies">PC Weenies</option>
     <option value="/poorlydrawnlines">Poorly Drawn Lines</option>
     <option value="/pennyarcade">Penny Arcade</option>
     <option value="/spikedmath">Spiked Math</option>
     <option value="/shortpacked">Shortpacked</option>
 </select>

 <div class="links">
     <a href="http://comichoard.com/cyanideandhappiness"></a>
     <a href="http://comichoard.com/calvinandhobbes"></a>
     <a href="http://comichoard.com/garfield"></a>
     <a href="http://comichoard.com/xkcdcomic"></a>
     <a href="http://comichoard.com/jl8"></a>
     <a href="http://comichoard.com/channelate"></a>
     <a href="http://comichoard.com/maximumble"></a>
     <a href="http://comichoard.com/buttersafe"></a>
     <a href="http://comichoard.com/pcweenies"></a>
     <a href="http://comichoard.com/poorlydrawnlines"></a>
     <a href="http://comichoard.com/pennyarcade"></a>
     <a href="http://comichoard.com/spikedmath"></a>
     <a href="http://comichoard.com/shortpacked"></a>
</div>

<script>
     $(document).on('click','.cd-dropdown',function()    {
          if($('#top').hasClass('movable'))  {
               $('#top').removeClass('movable');
               $('#top').css('position','fixed');
               $('#top').css({bottom:''});
          }
          else {
               $('#top').addClass('movable');
               $('#top').css('position','absolute');
               $('#top').css({bottom:'0'});
          }
     });
</script>
