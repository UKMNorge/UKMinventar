<?php

require_once('UKM/vendor/autoload.php');
require_once(__DIR__ . '/../class/UKMinventar.class.php');

$inventar = new UkmInventarListe();
// var_dump($_GET);
if ($_GET["do"] == 'addlocation' ) {
    UKMinventar::addViewData('addlocation', 'true');
    }
if (!empty($_POST["fromcreatelocation"])) {
// var_dump($_POST);
$sql_values =   array(
    'name' => $_POST["locationname"],
);
// var_dump($sql_values);
$inventar->addLocation($sql_values);
}
if ($_GET["do"] == 'deletelocation' ) {
    // var_dump($_GET);
    $inventar->deleteLocation($_GET["item_id"]);
}


$alle = $inventar->get_all_locations();
// var_dump($alle);
UKMinventar::addViewData('locations', $alle);




