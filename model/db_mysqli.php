<?php


class Database {
	private $link;

	function __construct(){
		global $cfg;

		$this->link = mysqli_connect($cfg->db_host,$cfg->db_user, $cfg->db_senha , $cfg->db_banco ,$cfg->db_porta ) or die("erro: ". mysqli_connect_error());
	}

	function query($sql) {
		mysqli_query($this->link, "SET NAMES utf8");
		$result = mysqli_query($this->link, $sql) or die(mysqli_error($this->link));
	
		// Verificar si la consulta es SELECT
		if ($result instanceof mysqli_result) {
			$array_result = array();
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$array_result[] = $row;
			}
			return $array_result;
		}
	
		// Si es una consulta DELETE, INSERT o UPDATE, devolver true/false
		return $result;
	}
	

	function query_insert($sql){

		mysqli_query($this->link, "SET NAMES utf8");
		mysqli_query($this->link,  $sql)or die(mysqli_error($this->link));

		return mysqli_insert_id($this->link);
	}
	
	function query_update($sql){

		mysqli_query($this->link, "SET NAMES utf8");
		mysqli_query($this->link,  $sql)or die(mysqli_error($this->link));

	}
	
}
?>