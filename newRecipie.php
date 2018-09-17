<?php
//-------------------------------------------------------------------------------------------
// newRecipie.php - New Recipie
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
require_once("classes/MBTBeer.php");
require_once("classes/MBTYeast.php");
require_once("classes/MBTStandards.php");
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// mainline
//-------------------------------------------------------------------------------------------
// testing override
$userId = 1;

$database = new MBTDatabase();
$recipie = new MBTRecipie($database);
$beer = new MBTBeer($database);
$yeast = new MBTYeast($database);
$standards = new MBTStandards($database);

$pageTitle = "MBT - Recipie Details";
$crumbTrail = 'My Brew Tracker > My Recipies > Recipie Detail';
$menuOptions = "";

$beerTypeDropDownHTML = $beer->getBeerTypeDropDown(null);
$yeastTypeDropDownHTML = $yeast->getYeastDropDownHTML(null);
$batchUnitOfMeasureDropDownHTML = $standards->getUnitOfMeasureDropDownHTML('batchSize', null);
$boilUnitOfMeasureDropDownHTML = $standards->getUnitOfMeasureDropDownHTML('boilSize', null);

require_once("includes/header.php");
?>

<br /><br />
<div id="mainContent">
	<span class="largeHeading">Create Recipie</span>
	<br /><br />
	<form method="post" id="recipieForm" action="selectRecipieDetails.php">
	<table style="margin-left: auto; margin-right: auto;">
		<tr>
			<td>Name</td>
			<td><input type="text" class="textField" id="recipieName" name="recipieName" size="25" maxLength="50" /></td>
		</tr>
		<tr>
			<td>Beer Type</td>
			<td><?php echo $beerTypeDropDownHTML; ?></td>
		</tr>
		<tr>
			<td>Average IBU</td>
			<td><input type="text" class="textField" id="averageIBU" name="averageIBU" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Average ABV</td>
			<td><input type="text" class="textField" id="averageABV" name="averageABV" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Original Gravity</td>
			<td><input type="text" class="textField" id="originalGravity" name="originalGravity" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Final Gravity</td>
			<td><input type="text" class="textField" id="finalGravity" name="finalGravity" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Mash Temp</td>
			<td><input type="text" class="textField" id="mashTemp" name="mashTemp" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Mash Time</td>
			<td><input type="text" class="textField" id="mashTime" name="mashTime" size="4" maxLength="6" /></td>
		</tr>
		<tr>
			<td>Yeast</td>
			<td><?php echo $yeastTypeDropDownHTML; ?></td>
		</tr>
		<tr>
			<td>Batch Size</td>
			<td><input type="text" class="textField" id="batchSize" name="batchSize" size="4" maxLength="6" /> <?php echo $batchUnitOfMeasureDropDownHTML; ?></td>
		</tr>
		<tr>
			<td>Boil Size</td>
			<td><input type="text" class="textField" id="boilSize" name="boilSize" size="4" maxLength="6" /> <?php echo $boilUnitOfMeasureDropDownHTML; ?></td>
		</tr>
		<tr>
			<td>Boil Time</td>
			<td><input type="text" class="textField" id="boilTime" name="boilTime" size="4" maxLength="6" /></td>
		</tr>
	</table>
	</form>
	<br />
	<div class="blueButton" onClick="document.getElementById('recipieForm').submit();">Select Details</div>
</div>

 <?php
require_once("includes/footer.php");
//-------------------------------------------------------------------------------------------