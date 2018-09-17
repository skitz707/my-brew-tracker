<?php
//-------------------------------------------------------------------------------------------
// addHopToRecipie.php - New Recipie
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
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// mainline
//-------------------------------------------------------------------------------------------
// testing override
$userId = 1;

$database = new MBTDatabase();

$detail['recipieId'] = $_POST['recipieId'];
$detail['ingredientType'] = "H";
$detail['associatedId'] = $_POST['hopId'];
$detail['quantity'] = $_POST['quantity'];
$detail['unitOfMeasureId'] = $_POST['unitOfMeasureId'];
$detail['whenToAdd'] = $_POST['whenToAdd'];

$database->insertDatabaseRecord("mybrew.recipieDetail", $detail);

header("Location: selectRecipieDetails.php?recipieId=" . $_POST['recipieId']);
//-------------------------------------------------------------------------------------------