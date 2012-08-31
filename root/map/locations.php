<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');

$locations = new Locations('http://www.berkeley.edu/data/ucb_map_coordinates.xml');
$search_results = false;

if($search_results = (isset($_GET['search']) && strlen(trim($_GET['search'])) > 0 && $search = trim($_GET['search'])))
    $locations = $locations->search($search);

include(dirname(__FILE__).'/header_locations.php');

?>

   <div class="content-full content-padded">
         <h1 class="light menu-first">Search Buildings</h1>
         <div>
            <form action="locations.php" method="get" style="position: relative; height: 30px; margin: 0px; padding: 0px;" >
            <input type="submit" value="Search" style="width:90px; font-size: 12px; float: right; height: 30px; padding: 0px; border: 0; background-color: #226; color: #fff;">
            <input type="text" id="menu-filter" name="search" style="position: absolute; left: -10px; right: 80px; height: 30px; font-size: 14px; padding: 0px 10px; border: 0; background-color: #eee; color: #555;">
            </form>
         </div>
        
    </div>

    <div class="menu-full menu-detailed menu-padded menu-filterable">
         <h1 class="light menu-first"><?php echo $search_results ? 'Buildings (Results)' : 'Buildings'; ?></h1>
         <ol>
             <?php
             if(!$search_results)			 	
             if(count($locations) == 0)
                 echo '<li><a><em>No results</em></a></li>';
			 else
          		echo '<li class=only-webkit><a href="map.php">All Buildings</a></li>';
				
             foreach($locations as $location)
                echo '<li><a href="map.php?loc='.urlencode($location['name']).'">'.$location['name'].'</a></li>';
             if($search_results)
                 echo '<li><a href="locations.php"><em>List All Buildings</em></a></li>';
             ?>
        </ol>
    </div>

    <a class="button-full button-padded" href="index.php">Go to Maps &amp; Tour</a>

    <script>
    if(typeof $ != 'undefined')
    {
        $('#menu-filter').siblings('input[type=submit]').hide();
        $('#menu-filter').css('right', '0px');
        var filter = function() {
            var str = $('#menu-filter').val().toLowerCase();
            var ele = $('.menu-filterable li');
            for(var i = 0; i < ele.length; i++)
            {
                var elei = $(ele[i]);
                if(str.length == 0)
                    elei.show();
                if(elei.children('a').html().toLowerCase().indexOf(str) >= 0)
                    elei.show();
                else
                    elei.hide();
            }
            window.setTimeout(filter, 500);
        }
        window.setTimeout(filter, 500);
    }
    </script>

<?php include(dirname(__FILE__).'/footer.php'); ?>