<?php
//-------------------------------------------------------------------------------------------
// selectRecipieDetails.php - New Recipie
// myBrewTracker.com
// Written by: Michael C. Szczepanik
// September 17th, 2018
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
require_once("classes/MBTGrain.php");
require_once("classes/MBTHop.php");
require_once("classes/MBTStandards.php");
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// mainline
//-------------------------------------------------------------------------------------------
// testing override
$userId = 1;

$database = new MBTDatabase();
$recipie = new MBTRecipie($database);
$grain = new MBTGrain($database);
$hop = new MBTHop($database);
$standards = new MBTStandards($database);

if (!isset($_GET['recipieId'])) {
	$header['ownerId'] = $userId;
	$header['recipieName'] = $_POST['recipieName'];
	$header['beerTypeId'] = $_POST['beerTypeId'];
	$header['yeastId'] = $_POST['yeastId'];
	$header['averageIBU'] = $_POST['averageIBU'];
	$header['averageABV'] = $_POST['averageABV'];
	$header['originalGravity'] = $_POST['originalGravity'];
	$header['finalGravity'] = $_POST['finalGravity'];
	$header['mashTemp'] = $_POST['mashTemp'];
	$header['mashTime'] = $_POST['mashTime'];
	$header['batchSize'] = $_POST['batchSize'];
	$header['batchUnitOfMeasureId'] = $_POST['unitOfMeasureIdbatchSize'];
	$header['boilSize'] = $_POST['boilSize'];
	$header['boilUnitOfMeasureId'] = $_POST['unitOfMeasureIdboilSize'];
	$header['boilTime'] = $_POST['boilTime'];

	$database->insertdatabaseRecord("mybrew.recipieHeader", $header);

	$recipieId = $database->getColumnMax("mybrew.recipieHeader", "recipieId", array("ownerId"=>$userId));
} else {
	$recipieId = $_GET['recipieId'];
}

// load recipie object
$recipie->loadRecipieById($recipieId);
$recipieHeader = $recipie->getRecipieHeaderHTML();


$pageTitle = "MBT - Recipie Details";
$crumbTrail = 'My Brew Tracker > My Recipies > Recipie Detail';
$menuOptions = "";

$grainTypesDropDownHTML = $grain->getGrainTypesDropDownHTML(null);
$hopTypesDropDownHTML = $hop->getHopTypesDropDownHTML(null);
$unitOfMeasureDropDownHTML = $standards->getUnitOfMeasureDropDownHTML("", null);

require_once("includes/header.php");
?>

<div id="mainContent">
	<br /><br />
	<?php echo $recipieHeader; ?>
	<br /><br />
	<span class="mediumHeader">Grains:</span><br />
	<form method="post" action="addGrainToRecipie.php" id="grainForm">
	<table style="margin-left: auto; margin-right: auto;">
		<tr>
			<th>#</th>
			<th style="text-align: left;">Grain</th>
			<th>Amount</th>
			<th>U/M</th>
			<th>Action</th>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $grainTypesDropDownHTML; ?></td>
			<td><input type="text" class="textField" size="3" maxlength="5" name="quantity" id="quantity" /></td>
			<td><?php echo $unitOfMeasureDropDownHTML; ?></td>
			<td><div class="greenButton" onClick="document.getElementById('grainForm').submit();">Add</div></td>
		</tr>
		<tr>	
			<td colspan="4"><hr /></td>
		</tr>
		<?php getGrainDetails($database, $recipieId); ?>
	</table>
	<input type="hidden" id="recipieId" name="recipieId" value="<?php echo $recipieId; ?>" />
	</form>
	<br /><br /><br />
	<span class="mediumHeader">Hops</span>
	<form method="post" action="addHopToRecipie.php" id="hopForm">
	<table style="margin-left: auto; margin-right: auto;">
		<tr>
			<th>#</th>
			<th style="text-align: left;">Hop</th>
			<th>Amount</th>
			<th>U/M</th>
			<th>Add When</th>
			<th>Action</th>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $hopTypesDropDownHTML; ?></td>
			<td><input type="text" class="textField" size="3" maxlength="5" name="quantity" id="quantity" /></td>
			<td><?php echo $unitOfMeasureDropDownHTML; ?></td>
			<td><input type="text" class="textField" size="5" maxlength="10" name="whenToAdd" id="whenToAdd" /></td>
			<td><div class="greenButton" onClick="document.getElementById('hopForm').submit();">Add</div></td>
		</tr>
		<tr>	
			<td colspan="5"><hr /></td>
		</tr>
		<?php getHopsDetails($database, $recipieId); ?>
	</table>
	<input type="hidden" id="recipieId" name="recipieId" value="<?php echo $recipieId; ?>" />
	</form>
	<br /><br />
	<div class="blueButton" onClick="document.location.href='myRecipies.php';">Finish</div>
</div>

 <?php
require_once("includes/footer.php");
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// get grain details
//-------------------------------------------------------------------------------------------
function getGrainDetails($database, $recipieId) {
	$selectStmt = "select * from mybrew.recipieDetail where recipieId = ? and ingredientType = 'G'";
	$i = 1;
	$totalQuantity = 0;
	
	if ($selectHandle = $database->databaseConnection->prepare($selectStmt)) {
		if (!$selectHandle->execute(array(0=>$recipieId))) {
			var_dump($database->databaseConnection->errorInfo());
		}
		
		while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
			$grainRecord = $database->getDatabaseRecord("mybrew.grains", array("grainId"=>$data['associatedId']));
			$unitOfMeasure = $database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$data['unitOfMeasureId']));
			
			echo '<tr>
					<td> ' . $i . '.</td>
					<td>' . $grainRecord['grainName'] . ' - ' . $grainRecord['country'] . '</td>
					<td style="text-align: right;">' . $data['quantity'] . '</td>
					<td style="text-align: center;">' . $unitOfMeasure['unitOfMeasure'] . '</td>
					<td><a href="removeRecipieDetail.php?recipieDetailId=' . $data['recipieDetailId'] . '">Remove</a></td>
				  </tr>
			';
			
			$totalQuantity += $data['quantity'];
		}
	} else {
		var_dump($database->databaseConnection->errorInfo());
	}
	
	echo '<tr>
			<td colspan="2" style="text-align: right; font-weight: bold;">TOTAL:</td>
			<td style="text-align: right; font-weight: bold;">' . number_format($totalQuantity, 2, ".", ",") . '</td>
			<td colspan="2"></td>
		  </tr>
	';
}
//-------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------
// get hop details
//-------------------------------------------------------------------------------------------
function getHopsDetails($database, $recipieId) {
	$selectStmt = "select * from mybrew.recipieDetail where recipieId = ? and ingredientType = 'H'";
	$i = 1;
	$totalQuantity = 0;
	
	if ($selectHandle = $database->databaseConnection->prepare($selectStmt)) {
		if (!$selectHandle->execute(array(0=>$recipieId))) {
			var_dump($database->databaseConnection->errorInfo());
		}
		
		while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
			$hopRecord = $database->getDatabaseRecord("mybrew.hops", array("hopId"=>$data['associatedId']));
			$unitOfMeasure = $database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$data['unitOfMeasureId']));
			
			echo '<tr>
					<td> ' . $i . '.</td>
					<td>' . $hopRecord['hopName'] . '</td>
					<td style="text-align: right;">' . $data['quantity'] . '</td>
					<td style="text-align: center;">' . $unitOfMeasure['unitOfMeasure'] . '</td>
					<td> ' . $data['whenToAdd'] . '</td>
					<td><a href="removeRecipieDetail.php?recipieDetailId=' . $data['recipieDetailId'] . '">Remove</a></td>
				  </tr>
			';
			
			$totalQuantity += $data['quantity'];
		}
	} else {
		var_dump($database->databaseConnection->errorInfo());
	}
	
	echo '<tr>
			<td colspan="2" style="text-align: right; font-weight: bold;">TOTAL:</td>
			<td style="text-align: right; font-weight: bold;">' . number_format($totalQuantity, 2, ".", ",") . '</td>
			<td colspan="2"></td>
		  </tr>
	';
}
//-------------------------------------------------------------------------------------------