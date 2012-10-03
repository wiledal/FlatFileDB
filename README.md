FlatFileDB
=======

**Version 1.0**
**By Hugo Wiledal**

Features
--------
* Read and write to .csv file format for easy flat file db handling

## Angry example usage (I wrote this in frustration, it's all good though)

### get($table):
GETS THE FUCKING TABLE (URL) AND RETURNS IT IN A FUCKING ARRAY WHERE EACH FUCKING COLUMN IS REPRESENTED BY ITS TITLE.
FOR INSTANCE:
```php
$db = new FlatFileDB();
$table = $db->get("dbtable.csv");
foreach($table as $row) {
	echo $row["user_name"].": ".$row["user_score"];
}
```

### insert($table, $row, $id):
INSERTS A FUCKING ROW INTO THE FILE AND SHIT LIKE THAT.
FOR INSTANCE:
```php
$db = new FlatFileDB();
$entry = array(
	"user_name" => "God",
	"user_score" => "-666"
);
$db->insert("dbtable.csv", $entry);
```

### update($table, $id, $row):
WHAT THE FUCK DO YOU THINK IT FUCKING DOES?!
YOU HAVE TO PROVIDE THE _id OF THE ROW YOU WANT TO UPDATE. THIS ID IS GENERATED AUTOMAGICALLY, OR SET BY YOU IF YOU WANT TO DO THAT YOU PIECE OF SHIT.
FOR INSTANCE:
```php
$db = new FlatFileDB();
$entry = array(
	"user_name" => "God",
	"user_score" => "-666666"
);
$db->update("dbtable.csv", $rowID, $entry);
```

### delete($table, $id):
DE-FUCKING-LETES A ROW, WHERE THE ROW ID = THE FUCKING _id.
FOR INSTANCE:
```php
$db = new FlatFileDB();
$db->delete("dbtable.csv", $rowID);
```