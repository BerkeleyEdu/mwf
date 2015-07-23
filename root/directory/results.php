<?php

session_start();

include('ucb_directory.class.php');
$searcher = new UCLA_Directory();

$search_results = array();

if(isset($_POST['search'])){
    $search_query_result = $searcher->search($_POST['search']);
    foreach($search_query_result as $result)
    {
            $search_results[$result['uid'][0]] = $result['cn'][0];
    }
	
	if (count($search_results) < 51)
	{
    	natcasesort($search_results);
	}

	$_SESSION['lastsearch'] = $_POST['search'];
}else if(isset($_SESSION['lastsearch'])){
    $search_query_result = $searcher->search($_SESSION['lastsearch']);
    foreach($search_query_result as $result)
    {
            $search_results[$result['uid'][0]] = $result['cn'][0];
    }
	if (count($search_results) < 51)
	{
   		 natcasesort($search_results);
	}
}else{
	header('Location: index.php');
}

$zero_results = (count($search_results) == 0);
//$valid_results = (count($search_results) < 249 && count($search_results) > 0);
$valid_results = (count($search_results) < 51 && count($search_results) > 0);

?><!DOCTYPE html>

<html>
<head>
    <title>UCB Mobile | Directory</title>
    <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
	<?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../assets/js.php?no_ga"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../assets/js.php"></script>';	
	}
	?>
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <link rel="stylesheet" href="css/directory.css" type="text/css" media="screen" />
</head>

<body>

    <?php include('inc/header.php'); ?>
    
    <?php include('inc/search.php'); ?>

    <!-- RESULT LIST -->
    <?php 
	//if($valid_results){ 
	if(!$zero_results){ 
	?>
    
    <?php
			if(!$valid_results){ 
			 echo '<div class="content-full content-padded"><div class="content-last"><em>Results are limited to the first 50 people matching <strong>'. $value .'</strong>.<br/> Try advanced search on <strong><a href="http://www.berkeley.edu/directory">full site</a></strong>.</em></div></div>';
			}
			
		?>
    <div class="menu-full menu-detailed menu-padded">       
        <h1 class="menu-first">Search Results</h1>
        <ol>
            <?php
			$count = 0;
            foreach($search_results as $id=>$name)
			{ 
			    if ($count < 50)
				{
					echo '<li><a href="result.php?u='.$id .'">';
					echo ucwords(strtolower($name)).'</a></li>';
				}
				$count++;
			}
		 ?>
        </ol>
    </div>
    <?php }else{ ?>
    
    <div class="content-full content-padded">

        <h1 class="content-first">Search Results</h1>
    	<?php if($zero_results){ ?>
        <p class="content-last"><em>No matches to your search. Please try again.</em></p>
        <?php }else{ ?>
        <p class="content-last"><em>Results exceeded 50 records. Please try again.</em></p>
        <?php } ?>

    </div>
    <?php } ?>

    <div class="clear"></div>
    
     <a class="button-full button-padded" href="index.php">Go to Directory</a>
    
    <?php include('inc/footer.php'); ?>

</body>

</html>