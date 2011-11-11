<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
?>

		<div class="content-full content-padded">
        <h2 class="content-first>">Search the UC Berkeley Web</h2>
<div class="content-last">
<p>
     
<?php 
	$pos = strpos(Classification::get(),'BlackBerry'); 
	if ($pos !== false)
	{
	?>      

<form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" >
		<input type="text" id="search_text" name="search_text" style='width:73%; max-width:300px' />
		
          <input  id="search-button" class="form-last" name="Submit" type="submit" value="Search" />
          <input type="hidden" name="display_type" value="mobile" />
           <input type="hidden" name="noscript" value="yes" />
      </form>


<?php
}
else
{
?> 
          
 
    <form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" >
		<input type="text"  id="search_text" name="search_text" style="width:73%; max-width:300px;" />
          <input id="search-button" class="form-last" name="Submit" type="submit" value="Search"/>    
          <input type="hidden" name="display_type" value="mobile" />
<noscript>
 <input type="hidden" name="noscript" value="yes" />
</noscript>
      </form>
      
        
  
<?php 
}
?>

</p>
</div>
</div>
    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
