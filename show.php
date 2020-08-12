<?php
$auth = base64_encode("admin:admin");
$context = stream_context_create([
    "http" => [
        "header" => "Authorization: Basic $auth"
    ]
]);
$json = file_get_contents('http://chess1.metamath.ru/state/', false, $context);
$obj = json_decode($json);
//print_r ($obj);
echo "<link rel='stylesheet' href='style.css'>";
echo "<table rows=8 cols=8 border=1>";
$ltr = Array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H');
for ($row = 8; $row > 0; $row--) {
	echo "<tr id='r".$row."'>";
	foreach ($ltr as $key => $r) {
		echo "<td id='".$r.$row."'"; 
		if ((($row%2 == 1) && ($key%2 == 1)) || (($row%2 == 0) && ($key%2 == 0)))
			echo "class='bl'>";
		else
			echo "class='wh'>";
		}
	echo "</tr>";
}
echo "</table>";

echo "<label for='MoveId'><h3>Номер хода</h3></label>";
echo "<div id='MoveId'></div>";

echo "<label for='cmd'><h3>Предыдущий ход</h3></label>";
echo "<div id='cmd'></div>";

echo "<label for='ret'><h3>Выбывшие фигуры</h3></label>";
echo "<div id='ret'></div>";
//print_r ($obj);
$array = (array) $obj;
$arr = json_decode(json_encode($array['board_state']), TRUE);
//print_r ($arr);
foreach ($arr as $figure => $fld) {
	if (($figure == 'cmd') && ($fld == ""))
		echo "
			<script type='text/javascript'>
				document.getElementById('cmd').innerHTML = 'N/A';
			</script>";
	echo "
	<script type='text/javascript'>
		document.getElementById('".strval($fld)."').innerHTML = document.getElementById('".strval($fld)."').innerHTML + '".strval($figure)."';
		if (document.getElementById('ret').innerHTML != '')
			document.getElementById('ret').innerHTML = document.getElementById('ret').innerHTML + ' ';
	</script>";
	if ($figure == 'MoveId')
		echo "
			<script type='text/javascript'>
				document.getElementById('MoveId').innerHTML = '".strval($fld)."';
			</script>";
	
}

?>