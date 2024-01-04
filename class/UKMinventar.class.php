<?php

use UKMNorge\Database\SQL\Query;
use UKMNorge\Database\SQL\Insert;
use UKMNorge\Database\SQL\Update;


require_once('UKM/Autoloader.php');

/**
 * Henter og skriver fra databasen
 */
class UkmInventarListe {

	/**
	 * protecting  the input form the SQL injection and script injection.
	 * @param $data
	 * @return mixed
	 */
	public function sanitizer ($data)
	{
		if (!empty($data)) {
			foreach ($data as $key => $dataValue) {
				if (empty($dataValue)) {
					continue;
				}
				$dataValue = strip_tags($dataValue);
				$data[$key] = mysql_real_escape_string($dataValue, $this->link);
			}
		}

		return $data;
	}

	/**
	 * Henter alle id'er for en søknadsrunde
	 *
	 * @return void
	 */
	public function get_all_items() {
		$sql = new Query(
				"SELECT ukm_inventory_items.id as item_id, ukm_inventory_items.name as item_name, 
				ukm_inventory_items.purchase_cost, ukm_inventory_items.purchase_date, ukm_inventory_items.other,
				ukm_inventory_locations.name as location_name,
				ukm_inventory_categories.name as category_name
				FROM ukm_inventory_items
				INNER JOIN ukm_inventory_categories on ukm_inventory_items.category_id = ukm_inventory_categories.id
				INNER JOIN ukm_inventory_locations on ukm_inventory_items.location_id = ukm_inventory_locations.id
				WHERE ukm_inventory_items.deleted = 'false'
				ORDER BY ukm_inventory_items.purchase_date DESC");
		$res = $sql->run();
		$items = [];
		while( $row = Query::fetch( $res ) ) {
			$items[] = $row;
		}		
		return $items;
	}
    // Function to get a single item by ID
    public function get_item_by_id($id) {
		$sql = new Query(
			"SELECT ukm_inventory_items.id as item_id, ukm_inventory_items.name as item_name, 
			ukm_inventory_items.purchase_cost, ukm_inventory_items.purchase_date, ukm_inventory_items.other as item_other,
			ukm_inventory_items.category_id as item_category_id, ukm_inventory_items.location_id as item_location_id,
			ukm_inventory_locations.name as location_name,
			ukm_inventory_categories.name as category_name
			FROM ukm_inventory_items
			INNER JOIN ukm_inventory_categories on ukm_inventory_items.category_id = ukm_inventory_categories.id
			INNER JOIN ukm_inventory_locations on ukm_inventory_items.location_id = ukm_inventory_locations.id
			WHERE ukm_inventory_items.id = $id");
		$res = $sql->run();
		$row = Query::fetch( $res )	;
		return $row;
    }

	public function get_all_categories() {
		$sql = new Query(
				"SELECT * FROM ukm_inventory_categories
				WHERE ukm_inventory_categories.deleted = 'false'");
		$res = $sql->run();
		$categories = [];
		while( $row = Query::fetch( $res ) ) {
			$categories[] = $row;
		}		
		return $categories;
	}

	public function get_all_locations() {
		$sql = new Query(
				"SELECT * FROM ukm_inventory_locations
				WHERE ukm_inventory_locations.deleted = 'false'");
		$res = $sql->run();
		$locations = [];
		while( $row = Query::fetch( $res ) ) {
			$locations[] = $row;
		}		
		return $locations;
	}

	public function updateGjenstand($sql_values, $gjenstandid) {
		$sql = new Update('ukm_inventory_items',array('id'=>$gjenstandid));
		foreach ($sql_values as $key => $val) {
			$sql->add($key, $val);
		}
		$sql->run();
	}

	/**
	 * Legger til ny oppføring i inventar databasen
	 *
	 * @param [type] $sql_values
	 * @return void
	 */
	public function addGjenstand($sql_values) {

		$sql = new Insert('ukm_inventory_items');
		foreach ($sql_values as $key => $val) {
			$sql->add($key, $val);
		}

		try {
			$id = $sql->run();

		} catch( Exception $e ) {

		}
	}

	public function deleteGjenstand($id) {
		$sql = new Update('ukm_inventory_items', array('id' => $id));
		// var_dump($sql);
		$sql->add("deleted", "true");
		$sql->run();
	}

	public function addCategory($sql_values) {

		$sql = new Insert('ukm_inventory_categories');
		foreach ($sql_values as $key => $val) {
			$sql->add($key, $val);
		}

		try {
			$id = $sql->run();

		} catch( Exception $e ) {

		}
	}

	public function deleteCategory($id) {
		$sql = new Update('ukm_inventory_categories', array('id' => $id));
		// var_dump($sql);
		$sql->add("deleted", "true");
		$sql->run();
	}

	public function addLocation($sql_values) {

		$sql = new Insert('ukm_inventory_locations');
		foreach ($sql_values as $key => $val) {
			$sql->add($key, $val);
		}

		try {
			$id = $sql->run();

		} catch( Exception $e ) {

		}
	}

	public function deleteLocation($id) {
		$sql = new Update('ukm_inventory_locations', array('id' => $id));
		// var_dump($sql);
		$sql->add("deleted", "true");
		$sql->run();
	}
	/**
	 * Hjelpefunksjon for getSoknadFromID
	 *
	 * @param [type] $res
	 * @return void
	 */
	public function getSoknadData( $res ) {
		$soknad = [];
		foreach ($res as $key => $val) {
			$soknad[$key] = $val;
		}
		return $soknad;
	}

	public function getRapportData( $res ) {
		$rapport = [];
		foreach ($res as $key => $val) {
			$rapport[$key] = $val;
		}
		return $rapport;
	}
}