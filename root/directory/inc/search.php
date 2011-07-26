<?php

if(isset($_POST['string'])){
    $value = $_POST['string'];
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
    
    <form id="search-form" action="results.php" method="post">
        <input type="text" name="string" id="search-box" value="<?php echo $value; ?>"  style='width:73%; max-width:300px'/> <input id="search-button" type="submit" name="submit" value="Search" class="form-last" />
    </form>
</div>