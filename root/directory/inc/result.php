<div class="content-full content-padded directory-entry">

<?php 

$user = $searcher->user($_GET['u']);

//print "<pre>";
//print_r($user);
//print "</pre>";

if(count($user) > 0){

?>

    <h1 class="content-first"><?php echo ucwords(strtolower($user['cn'][0])); ?></h1>
    <?php if(isset($user['title'][0]) || isset($user['department'][0])){ ?>
    <div>
        <?php if(isset($user['title'][0])){ ?><p><span class="label">Title</span> <?php //echo  ucwords(strtolower($user['title'][0])); 
		echo $user['title'][0];
		?></p><?php } ?>
        
        <?php if(isset($user['berkeleyeduunitcalnetdeptname'][0])){ ?><p><span class="label">Department</span> <?php echo $user['berkeleyeduunitcalnetdeptname'][0]; ?></p><?php } ?>
        
        
    </div>
    <?php } ?>
    
    <?php if(isset($user['berkeleyeduunitcalnetdeptname'][0])){ ?>

    <div>

        <?php

        $dp = isset($user['berkeleyeduunitcalnetdeptname'][0]) ? $user['berkeleyeduunitcalnetdeptname'][0] : '';
        $pc = isset($user['postalcode'][0]) ? $user['postalcode'][0] : '';
        $pa = isset($user['postaladdress'][0]) ? $user['postaladdress'][0] : '';

        preg_match('/^([^,]+),\s+([^,]+)(.*)$/', utf8_decode($user['cn'][0]), $m);
        $nm = "$m[2] $m[1]$m[3]";

        if (strlen($pa) > 0 && preg_match('/^(\d\d\d\d)/', $pc, $m)) {
            printf('<p><span class="label">Address</span>%s</span></p>',
                   str_replace('$', '<br />', htmlspecialchars(trim($pa))), htmlspecialchars(trim($m[1])));
        } ?>


    </div>

    <?php } ?>
    


    <?php if(isset($user['mail'][0])){ ?>
    
    <div class="content-button center">
        <a href="mailto:<?php echo urlencode($user['mail'][0]); ?>">
            <div class="label">Email Address</div>
            <?php echo $user['mail'][0]; ?></a>
    </div>
    <?php } ?>
    <?php if(isset($user['telephonenumber'][0])){ ?>
    <div class="content-button center">
        <a href="tel:<?php echo $user['telephonenumber'][0]; ?>">
            <div class="label">Telephone Number</div>
            <?php echo $user['telephonenumber'][0]; ?></a>
    </div>
    <?php } ?>
    <?php if(isset($user['facsimiletelephonenumber'][0])){ ?>
    <div class="content-button center">
        <a href="tel:<?php echo $user['facsimiletelephonenumber'][0]; ?>">
            <div class="label">Fax Number</div>
            <?php echo $user['facsimiletelephonenumber'][0]; ?></a>
    </div>
    <?php } ?>
    <?php if(isset($user['mobile'][0])){ ?>
    <div class="content-button center">
        <a href="tel:<?php echo $user['mobile'][0]; ?>">
            <div class="label">Mobile Number</div>
            <?php echo $user['mobile'][0]; ?></a>
    </div>
    <?php } ?>
    <?php if(isset($user['url'][0])){ ?>
    <div class="content-button center">
        <a href="<?php echo $user['url'][0]; ?>" target="_blank">
            <div class="label">Web Address</div>
            <?php echo $user['url'][0]; ?></a>
    </div>
    <?php } ?>

<?php }else{ ?>

    <h1 class="content-first light">Search Result: Error</h1>
    <div class="content">
    	<p>Details on the specified user cannot be displayed because an error was encountered during retrieval.</p>
    </div>

<?php } ?>

</div>