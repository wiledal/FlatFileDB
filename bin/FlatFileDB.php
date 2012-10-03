<?php
/* 
	FLAT FUCKING FILE DB OH YEAH MOTHERFUCKER FEEL IT. 
	by: HUGO MOTHERFUCKING WILEDAL, BITCH
	description:
		CREATES AND READS FROM MOTHERFUCKING CSV FILES TO MAKE YOUR LIFE MOTHERFUCKING FINE WHILE MAKING SHIT MOTHERFUCKER OH YEAH PEANUTBUTTER
		EVERY ROW IN A TABLE GETS ITS OWN FUCKING _id FOR YOUR FUCKING CONVENIENCE.
		THERE IS NO FUCKING SEARCH OR FIND FUNCTIONS HERE, JUST A GOOD FUCKING BASE. WRITE YOUR OWN SHIT, HOT DAMN YOU'RE FUCKING LAZY.

	USAGE (public functions):
		get($table):
			GETS THE FUCKING TABLE (URL) AND RETURNS IT IN A FUCKING ARRAY WHERE EACH FUCKING COLUMN IS REPRESENTED BY ITS TITLE.
			FOR INSTANCE:
				$db = new FlatFileDB();
				$table = $db->get("dbtable.csv");
				foreach($table as $row) {
					echo $row["user_name"].": ".$row["user_score"];
				}


		insert($table, $row, $id):
			INSERTS A FUCKING ROW INTO THE FILE AND SHIT LIKE THAT.
			FOR INSTANCE:
				$db = new FlatFileDB();
				$entry = array(
					"user_name" => "God",
					"user_score" => "-666"
				);
				$db->insert("dbtable.csv", $entry);

		update($table, $id, $row):
			WHAT THE FUCK DO YOU THINK IT FUCKING DOES?!
			YOU HAVE TO PROVIDE THE _id OF THE ROW YOU WANT TO UPDATE. THIS ID IS GENERATED AUTOMAGICALLY, OR SET BY YOU IF YOU WANT TO DO THAT YOU PIECE OF SHIT.
			FOR INSTANCE:
				$db = new FlatFileDB();
				$entry = array(
					"user_name" => "God",
					"user_score" => "-666666"
				);
				$db->update("dbtable.csv", $rowID, $entry);

		delete($table, $id):
			DE-FUCKING-LETES A ROW, WHERE THE ROW ID = THE FUCKING _id.
			FOR INSTANCE:
				$db = new FlatFileDB();
				$db->delete("dbtable.csv", $rowID);


*/

class FlatFileDB {
	function FlatFileDB() {
		// INITIATE MOTHERFUCKER
	}
	function insert($table, $row, $id = "") {
		$headers = $this->_getTableHeaders($table);
		$writeString = '';
		$row["_id"] = $id;
		if ($id == "") $row["_id"] = md5(time()*rand());

		foreach ($headers as $key => $value) {
			if ($row[$value]) {
				$writeString.='"'.$row[$value].'",';
			}else{
				$writeString.='"",';
			}
			
		}
		$writeString.="\n";
		$file = fopen($table, "a");
		fwrite($file, $writeString);
		fclose($file);
	}
	function delete($table, $id) {
		$rows = $this->get($table);
		foreach($rows as $key => $row) {
			if ($row["_id"] == $id) {
				$this->_removeRowFromTable($table, $key+1);
				break;
			}
		}
	}
	function update($table, $id, $row) {
		$this->delete($table, $id);
		$this->insert($table, $row, $id);
	}
	function get($table) {
		$headers = $this->_getTableHeaders($table);
		$rows = array();
		$file = fopen($table, "r");
		fgets($file); // SKIP FIRST MOTHERFUCKING LINE
		while($rowData = fgets($file)) {
			$row = array();
			$splitData = $this->_splitRow($rowData);
			foreach($headers as $key => $field) {
				$row[$field] = $splitData[$key];
			}
			array_push($rows, $row);
		}
		fclose($file);
		return $rows;
	}

	function _removeRowFromTable($table, $row) {
		$f = file($table);
		unset($f[$row]);
		$writeOut = "";
		foreach($f as $line) {
			$writeOut.=$line;
		}
		$file = fopen($table, "w");
		fwrite($file, $writeOut);
		fclose($file);
	}
	function _getTableHeaders($table) {
		$f = fopen($table, "r");
		$headers = fgets($f);
		fclose($f);
		return $this->_splitRow($headers);
	}
	function _splitRow($row) {
		$arr = split('\",\"', $row);
		$arr[0] = substr($arr[0], 1);
		$arr[count($arr)-1] = substr($arr[count($arr)-1], 0, strlen($arr[count($arr)-1])-3);
		return $arr;
	}
}

?>