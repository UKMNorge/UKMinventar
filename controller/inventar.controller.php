<?php

require_once('UKM/vendor/autoload.php');
require_once(__DIR__ . '/../class/UKMinventar.class.php');

$inventar = new UkmInventarListe();
// var_dump($_GET);
if (!empty($_POST["fromcreate"])) {
    // var_dump($_POST);
    $sql_values =   array(
        'category_id' => $_POST["category"],
        'location_id' => $_POST["location"],
        'name' => $_POST["item"],
        'other' => $_POST["other"],
        'purchase_date' => $_POST["date"],
        'purchase_cost' => $_POST["price"],
    );
    // var_dump($sql_values);
    $inventar->addGjenstand($sql_values);
    }

    if ($_GET["do"] == 'delete' ) {
        // var_dump($_GET);
        $inventar->deleteGjenstand($_GET["item_id"]);
    }

    if (!empty($_POST["fromedit"])) {
        // var_dump($_POST);
        $sql_values =   array(
            'category_id' => $_POST["category"],
            'location_id' => $_POST["location"],
            'name' => $_POST["item"],
            'other' => $_POST["other"],
            'purchase_date' => $_POST["date"],
            'purchase_cost' => $_POST["price"],
        );
        $gjenstandid = $_POST["gjenstandid"];
         var_dump($gjenstandid);
        $inventar->updateGjenstand($sql_values, $gjenstandid);
    }

$alle = $inventar->get_all_items();
// var_dump($alle);
UKMinventar::addViewData('items', $alle);




