<!DOCTYPE html>
<html>

<head>
    <title>UCB Mobile | Cal Day</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <link rel="stylesheet" href="http://m-qa.berkeley.edu/assets/css.php" type="text/css" media="screen" />
    <script type="application/javascript" src="http://m-qa.berkeley.edu/assets/js.php?no_ga"></script>
	<script type="text/javascript" src="http://m-qa.berkeley.edu/assets/js.php?standard_libs=geolocation"></script>

<script language="javascript">
function getLocationNow(filter)
{
		mwf.touch.geolocation.getPosition
		(
			function(pos)
			{ 
				var thislink = 'upcoming.php?lat='+pos['latitude']+'&lon='+pos['longitude']+'&filter='+filter;
				window.location = thislink; 
			} 
			//function(err){ alert("Err:"+err); }
		)
}
</script>	
	
</head>

<body>

	<h1 id="header">
        <a href="http://m-qa.berkeley.edu/">
        <img src="http://m-qa.berkeley.edu/assets/img/berkeley-home.png" alt="UC Berkeley" 
width="88" height="35" />         </a> 
<span>Cal Day</span>    </h1>
    
<div class="menu-full menu-detailed menu-padded">
             <h1 class="light menu-first">Find Events</h1>
             <ol>
				<li><a onClick="getLocationNow('near')" href="#">Near by at 10:30 a.m.</a></li> 
				<li><a onClick="getLocationNow('none')" href="#">All at 10:30 a.m.</a></li> 
                <li><a href="xxx.html">Search all events</a></li>                            
			</ol>
        </div>

    <a class="button-full button-padded" href="http://m-qa.berkeley.edu">Go to Berkeley Mobile</a>

	<div id="footer">

        <p>University of California &copy; 2011 UC Regents<br />
           <a href="http://www.berkeley.edu?ovrrdr=1">View Full Site</a></p>

    </div>

</body>

</html>

