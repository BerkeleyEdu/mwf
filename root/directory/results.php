<?php

session_start();

include('ucb_directory.class.php');
$searcher = new UCLA_Directory();

$search_results = array();

if(isset($_POST['string'])){
    $search_query_result = $searcher->search($_POST['string']);
    foreach($search_query_result as $result)
    {
            $search_results[$result['uid'][0]] = $result['cn'][0];
    }
    natcasesort($search_results);

	$_SESSION['lastsearch'] = $_POST['string'];
}else if(isset($_SESSION['lastsearch'])){
    $search_query_result = $searcher->search($_SESSION['lastsearch']);
    foreach($search_query_result as $result)
    {
            $search_results[$result['uid'][0]] = $result['cn'][0];
    }
    natcasesort($search_results);
}else{
	header('Location: index.php');
}

$zero_results = (count($search_results) == 0);
$valid_results = (count($search_results) < 249 && count($search_results) > 0);

?><!DOCTYPE html>

<html>
<head>
    <title>UCB Mobile | Directory</title>
    <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
	<?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../assets/js.php?no_ga&webkit_libs=transitions"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../assets/js.php&webkit_libs=transitions"></script>';	
	}
	?>
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <link rel="stylesheet" href="css/directory.css" type="text/css" media="screen" />
</head>

<body>

    <?php include('inc/header.php'); ?>
    
    <?php include('inc/search.php'); ?>

    <!-- RESULT LIST -->
    <?php if($valid_results){ ?>
    <div class="menu-full menu-detailed menu-padded">

        <h1 class="menu-first">Search Results</h1>
        <ol>
            <?php foreach($search_results as $id=>$name){ ?>
            <li><a href="result.php?u=<?php echo $id; ?>">
                <?php echo ucwords(strtolower($name)); ?>
                </a></li>
            <?php } ?>
        </ol>
    </div>
    <?php }else{ ?>
    
    <div class="content-full content-padded">

        <h1 class="content-first">Search Results</h1>
    	<?php if($zero_results){ ?>
        <p class="content-last"><em>No matches to your search. Please try again.</em></p>
        <?php }else{ ?>
        <p class="content-last"><em>Results exceeded 250 records. Please try again.</em></p>
        <?php } ?>

    </div>
    <?php } ?>

    <div class="clear"></div>
    
     <a class="button-full button-padded" href="index.php">Go to Directory</a>
    
    <?php include('inc/footer.php'); ?>

</body>

</html>