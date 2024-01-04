<?php

require_once('UKM/vendor/autoload.php');
require_once(__DIR__ . '/../class/UKMinventar.class.php');

$inventar = new UkmInventarListe();
$all_categories = $inventar->get_all_categories();
$all_locations = $inventar->get_all_locations();

UKMinventar::addViewData('categories', $all_categories );
UKMinventar::addViewData('locations', $all_locations );