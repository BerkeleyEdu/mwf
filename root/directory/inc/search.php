<?php

if(isset($_POST['search'])){
    $value = $_POST['search'];
}else if(substr($_SERVER['REQUEST_URI'], strlen($_SERVER['REQUEST_URI'])-10, 9)  == 'index.php'){
	$value = '';
}else if(isset($_SESSION['lastsearch'])){
    $value = $_SESSION['lastsearch'];
}else{
	$value = '';
}

?>

<div class="content-full content-padded center">
    <h1 class="content-first">Search Directory</h1>
    
    <form id="ucbsearchform" action="results.php" method="post">
        <input type="text" name="search" id="ucbsearchtext" value="<?php echo $value; ?>"  style='width:73%; max-width:300px' placeholder="By name, phone, or email"/> <input id="ucbsearchbutton" type="submit" name="submit" value="Search" class="form-last" />
    </form>
</div>