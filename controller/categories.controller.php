<?php

require_once('UKM/vendor/autoload.php');
require_once(__DIR__ . '/../class/UKMinventar.class.php');

$inventar = new UkmInventarListe();
// var_dump($_GET);
if ($_GET["do"] == 'addcategory' ) {
    UKMinventar::addViewData('addcategory', 'true');
    }
if (!empty($_POST["fromcreatecategory"])) {
// var_dump($_POST);
$sql_values =   array(
    'name' => $_POST["categoryname"],
);
// var_dump($sql_values);
$inventar->addCategory($sql_values);
}
if ($_GET["do"] == 'deletecategory' ) {
    // var_dump($_GET);
    $inventar->deleteCategory($_GET["item_id"]);
}


$alle = $inventar->get_all_categories();
// var_dump($alle);
UKMinventar::addViewData('categories', $alle);




