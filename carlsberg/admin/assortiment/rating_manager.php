<?php
require_once "../dbaccessor.php";
 
class RatingManager extends DBAccessor {
	
	function __construct() {	
		parent::__construct();				
	}
	
	
	function getRating() {				 
		 $dir = $this->getString('id');
		 if(!$dir) {
		 	$_REQUEST['dir'] = 'DESC';
		 }
		 $query = "SELECT SQL_CALC_FOUND_ROWS r.* FROM studio_catalog_carslberg as r ";
		 $this->executeListQuery($query);
	}
	
	function saveRating() {
		$id = $this->getInt('id');
		$id_item = $this->getInt('id_item');
		$text_rating = $this->getString ('text');
		$protect_rating = $this->getInt ('protect_rating');
		$reliability_rating = $this->getInt ('reliability_rating');
		$comfort_rating = $this->getInt ('comfort_rating');
		$exploitation_rating = $this->getInt ('exploitation_rating');
		$design_rating = $this->getInt ('design_rating');
		$date_field = $this->getString ('date');
		$access = $this->getInt ('access');
		$rating = ($protect_rating + $reliability_rating + $comfort_rating + $exploitation_rating + $design_rating) / 5;
		$query = '';
		if($id) {
			$query = "UPDATE `studio_catalog_carslberg` SET `rating` = '{$rating}',`protect_rating`='{$protect_rating}',`reliability_rating`='{$reliability_rating}',`comfort_rating`='{$comfort_rating}',`exploitation_rating`='{$exploitation_rating}',`design_rating`='{$design_rating}',`text`='{$text_rating}',`access`='{$access}', `date`='{$date_field}' WHERE id = '{$id}'";
			$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query, 'descr_query' => 'Обновление оценки из админики'));				
			$result = $this->execute($query);
			if($result['result'] == 'success') {
				$result = $this->update_avg_studio_catalog_catalog ($id_item);
				if($result['result'] == 'success') {
					echo 1;
					return;
				}
			}
		} 
		echo 0;
	}
	
	function editRating() {
		$id = $this->getInt('id');
		$query = "SELECT * FROM studio_catalog_carslberg WHERE id = $id";
		$result = $this->getAssoc($query);
		echo json_encode($result);
	}
	
	function deleteRating() {
		$ids = $this->getString('ids');
		$query = "DELETE FROM studio_catalog_carslberg WHERE id IN ($ids)";
		$result = $this->execute($query);
		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
	}
}
?>
