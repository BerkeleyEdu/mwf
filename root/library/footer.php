	<div id="footer">
        <p><?php 
		if ($copyright = Config::get('global', 'copyright_text'))
           echo (str_replace('2012', date('Y'), $copyright));
		?><br />
           <a href="http://library.berkeley.edu/?ovrrdr=1">View Full Site</a></p>
    </div>

</body>

</html>