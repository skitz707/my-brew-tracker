<?php
//-------------------------------------------------------------------------------------------
// recipieDetail.php - Recipie Details
// myBrewTracker.com
// Written by: Michael C. Szczepanik
// July 6th, 2018
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// debug values
//-------------------------------------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// program includes
//-------------------------------------------------------------------------------------------
require_once("classes/MBTDatabase.php");
require_once("classes/MBTRecipie.php");
require_once("classes/MBTYeast.php");
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// mainline
//-------------------------------------------------------------------------------------------
// testing override
$userId = 1;

$database = new MBTDatabase();
$recipie = new MBTRecipie($database);
$yeast = new MBTYeast($database);

$recipie->loadRecipieById($_GET['recipieId']);
$yeast->loadYeastById($recipie->getYeastId());

$grains = $recipie->getGrains();
$grainCount = 1;
$totalQuantity = 0;
$totalNeeded = 0;

$pageTitle = "MBT - Recipie Details";
$crumbTrail = 'My Brew Tracker > My Recipies > Recipie Detail';
$menuOptions = "";

require_once("includes/header.php");
?>

<br /><br />
<div id="mainContent">
	<span class="largeHeading">Recipie Details: <?php echo $recipie->getRecipieName(); ?></span>
	<br /><br />
	<?php echo getRecipieHeaderHTML($recipie); ?>
</div>

<!--
echo "<br /><br /><br />Grains:<br />";

echo '<table width="40%" style="padding: 5px;">';
echo '	<tr>';
echo '		<th style="text-align: left;">#</th>';
echo '		<th style="text-align: left;">Grain</th>';
echo '		<th style="text-align: left;">Country</th>';
echo '		<th style="text-align: right;">Qty</th>';
echo '		<th>U/M</th>';
echo '		<th style="text-align: right;">On Hand</th>';
echo '		<th style="text-align: right;">Need</th>';
echo '	</tr>';

foreach ($grains as $grainDetailId) {
	$recipieDetail = $database->getDatabaseRecord("mybrew.recipieDetail", array("recipieDetailId"=>$grainDetailId));
	$grainData = $database->getDatabaseRecord("mybrew.grains", array("grainId"=>$recipieDetail['associatedId']));
	$unitOfMeasure = $database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$recipieDetail['unitOfMeasureId']));
	$onHandGrain = $database->getDatabaseRecord("mybrew.myStorage", array("userId"=>$userId, "itemType"=>"G", "associatedId"=>$grainData['grainId']));
	$grainNeeded = $recipieDetail['quantity'] - $onHandGrain['quantity'];
	
	echo '
		<tr>
			<td style="text-align: left;">' . $grainCount . '</td>
			<td style="text-align: left;">' . $grainData['grainName'] . '</td>
			<td style="text-align: left;">' . $grainData['country'] . '</td>
			<td style="text-align: right;">' . $recipieDetail['quantity'] . '</td>
			<td style="text-align: center;">' . $unitOfMeasure['unitOfMeasure'] . '</td>
			<td style="text-align: right;">' . $onHandGrain['quantity'] . '</td>
			<td style="text-align: right;">' . $grainNeeded . '</td>
		</tr>
	';
	
	$grainCount++;
	$totalQuantity += $recipieDetail['quantity'];
	$totalNeeded += $grainNeeded;
}

echo '
		<tr>
			<td colspan="3" style="text-align: right;">TOTAL:</td>
			<td style="text-align: right;">' . $totalQuantity . '</td>
			<td></td>
			<td></td>
			<td style="text-align: right;">' . $totalNeeded . '</td>
		</tr>
	</table>
	Mash Time: ' . $recipie->getMashTime() . ' min.
';

// print hops
$hopsCount = 1;
$hops = $recipie->getHops();
$totalHopsNeeded = 0;
$totalHops = 0;

echo '<br /><br />';
echo '
	Hops:
	<br />
	<table width="40%" style="padding 5px;">
		<tr>
			<th style="text-align: left;">#</th>
			<th style="text-align: left;">Hop</th>
			<th style="text-align: right;">AA</th>
			<th style="text-align: right;">Qty</th>
			<th>U/M</th>
			<th style="text-align: right;">On Hand</th>
			<th style="text-align: right;">Need</th>
		</tr>
';

foreach ($hops as $hopDetailId) {
	$recipieDetail = $database->getDatabaseRecord("mybrew.recipieDetail", array("recipieDetailId"=>$hopDetailId));
	$hopData = $database->getDatabaseRecord("mybrew.hops", array("hopId"=>$recipieDetail['associatedId']));
	$unitOfMeasure = $database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$recipieDetail['unitOfMeasureId']));
	$onHandHops = $database->getDatabaseRecord("mybrew.myStorage", array("userId"=>$userId, "itemType"=>"G", "associatedId"=>$hopData['hopId']));
	$hopsNeeded = $recipieDetail['quantity'] - $onHandHops['quantity'];
	
	echo '
		<tr>
			<td style="text-align: left;">' . $hopsCount . '</td>
			<td style="text-align: left;">' . $hopData['hopName'] . '</td>
			<td style="text-align: right;">' . $hopData['averageAA'] . '</td>
			<td style="text-align: right;">' . $recipieDetail['quantity'] . '</td>
			<td style="text-align: center;">' . $unitOfMeasure['unitOfMeasure'] . '</td>
			<td style="text-align: right;">' . $onHandHops['quantity'] . '</td>
			<td style="text-align: right;">' . $hopsNeeded . '</td>
		</tr>
	';
	
	$totalHops += $recipieDetail['quantity'];
	$totalHopsNeeded += $hopsNeeded;
}

echo '
		<tr>
			<td colspan="3" style="text-align: right;">TOTAL:</td>
			<td style="text-align: right;">' . $totalHops . '</td>
			<td></td>
			<td></td>
			<td style="text-align: right;">' . $totalHopsNeeded . '</td>
		</tr>
	</table>
	<br /><br />
';

if ($yeast->getSupplierName() > "") {
	$yeastName = $yeast->getYeastName() . ' (' . $yeast->getSupplierName() . ')';
} else {
	$yeastName = $yeast->getYeastName();
}

echo 'Yeast:<br />' . $yeastName;
-->
<?php
require_once("includes/footer.php");
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// get recipie header html
//-------------------------------------------------------------------------------------------
function getRecipieHeaderHTML($recipie) {
	$returnHTML = "";
	
	$returnHTML .= 
		$recipie->getRecipieName() . ' (' . $recipie->getBeerTypeName() . ') <br />
		ABV: ' . $recipie->getAverageABV() . ' IBUs: ' . $recipie->getAverageIBU() . " Boil Time: " . $recipie->getBoilTime() . " min.<br />
		Batch Size: " . $recipie->getBatchSize() . " " . $recipie->getBatchUnitOfMeasureName() . "
		Boil Size: " . $recipie->getBoilSize() . " " . $recipie->getBoilUnitOfMeasureName() . "<br />
		Original Gravity: " . $recipie->getOriginalGravity() . " Final Gravity: " . $recipie->getFinalGravity();
		
	return $returnHTML;
}
//-------------------------------------------------------------------------------------------