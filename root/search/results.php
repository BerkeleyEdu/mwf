<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once('../assets/config.php');
include(dirname(__FILE__).'/header.php');
?>

<div class="content-full content-padded">
     <h2 class="content-first>">Search the UC Berkeley Web</h2>
        
    <div class="content-last">
        
        <div id="cse" style="width: 100%;">Loading...</div>
		
		<script src="http://www.google.com/jsapi" type="text/javascript"></script>
		
		<script type="text/javascript">
		  google.load('search', '1', {language : 'en'});
		  function OnLoad()
		  {
			var customSearchControl = new google.search.CustomSearchControl('005819902514904969462:g_ef7-0cl6u');
			customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
			customSearchControl.draw('cse');
			customSearchControl.execute("<?php echo $_GET['q'];?>");
		  }
		  google.setOnLoadCallback(OnLoad);
		</script>
		
	
		<style> 
		input.gsc-input { width:73%; max-width:300px} 
		</style>
		
							
	</div>
</div>

 <a class="button-full button-padded" href="http://m.berkeley.edu">Go to UCB Mobile</a>

	<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>


