<?php

require_once('UKM/vendor/autoload.php');
require_once(__DIR__ . '/../class/UKMinventar.class.php');

$inventar = new UkmInventarListe();
if (!empty($_GET["item_id"])) {
    $gjenstand = $inventar->get_item_by_id($_GET["item_id"]);

$all_categories = $inventar->get_all_categories();
$all_locations = $inventar->get_all_locations();
// var_dump($gjenstand["item_category_id"]);
}

UKMinventar::addViewData('categories', $all_categories );
UKMinventar::addViewData('category_id', $gjenstand["item_category_id"] );
UKMinventar::addViewData('location_id', $gjenstand["item_location_id"] );
UKMinventar::addViewData('locations', $all_locations );
UKMinventar::addViewData('item', $gjenstand);