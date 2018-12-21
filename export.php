<?php
	$id= stripslashes ($_GET["id"]);
	if ($id) {
		include("/inc/config.php"); //Database connection here
		$format= stripslashes ($_GET["format"]);
		
		$query = "SELECT field1,filed2  FROM table where id in (".$id.") LIMIT 10";
		$result = mysql_query($query) or die ("Could not execute query");
		
		if ($format=="csv") {
			$field = mysql_num_fields($result);
			while($row = mysql_fetch_array($result)) {
				for($i = 0; $i < $field; $i++) {
					echo '"'.$row[mysql_field_name($result,$i)];
					if ($i<$field-1) {
						echo '",';
					}
				}
				echo ";\r\n";
			}
			} elseif ($format=="json") {
			$rows = array();
			while($r = mysql_fetch_assoc($result)) {
				$rows[] = $r;
			}
			echo json_encode($rows);
			} else {
			header("Content-type: text/xml; charset=utf-8");
			echo '<?xml version="1.0" encoding="utf-8"?>';
			echo '<data>';
			echo '<title>xml</title>';
			echo '<language>en-us</language>';
			while($data = mysql_fetch_assoc($result)) {
				foreach($data as $key => $value) {
					echo "<$key>$value</$key>";
				}
			}
			echo '</data>';
			}
		}
	?>	
