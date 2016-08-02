<html>
<head>


</head>
<body>
<?php

function get2DArrayFromCsv($file, $delimiter) {
    if (($handle = fopen($file, "r+")) !== FALSE) {
        $i = 0;
        $data2DArray = array();
        while (($lineArray = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
            for ($j = 0; $j < count($lineArray); $j++) {
                $data2DArray[$i][$j] = $lineArray[$j];
            }
            $i++;
        }
        fclose($handle);
    }
    return $data2DArray;
}

function createDateRangeArray($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

$LOGFILE = "mincount_log.dat";
$COUNTFILE = "mincount_count.dat";

$array = get2DArrayFromCsv($LOGFILE, ",");
$array2 = get2DArrayFromCsv($COUNTFILE, ",");


$dates = array();

foreach ($array as $val)
{
       array_push($dates, $val[0]);
}

$TOTAL = count($dates);
 
$c = 0;
foreach ($dates as $date) {
	$datum = date("Y-m-d", (float) $date);
	$dates[$c] = $datum;
	$c = $c + 1;
	
}

$datescounted = array_count_values($dates);


$myDateTime = DateTime::createFromFormat('m/d/Y', $_GET["from"]);
$from = $myDateTime->format('Y-m-d');
$myDateTime = DateTime::createFromFormat('m/d/Y', $_GET["to"]);
$to = $myDateTime->format('Y-m-d');

$statdates=array();
$statdates = createDateRangeArray($from,$to);
$data = array();

$TOTALINTERVAL = 0;
$OUT = "";
foreach ($statdates as $statdate) {
	
	$count = $datescounted[$statdate];
	if ($count == null) {$count = "0";}
	$OUT = $OUT."<br>$statdate&emsp;$count";
	$TOTALINTERVAL += $count;
}


echo "<b>TOTAL</b><br>$TOTAL<br><br><b>SELECTION</b><br>$TOTALINTERVAL<br><br>$OUT";


echo "<br><br><b>PAGE HITS</b><br><br>";
$out  = "";
$out .= "<table>";
foreach($array2 as $key => $element){
    $out .= "<tr>";
    foreach($element as $subkey => $subelement){
        $out .= "<td>$subelement</td>";
    }
    $out .= "</tr>";
}
$out .= "</table><br><br>";
echo $out;

echo "<br><br><b>RECENT PAGELOADS</b><br><br>";
$out  = "";
$out .= "<table>";
$c = 0;
foreach($array as $key => $element){
    $out .= "<tr>";
    foreach($element as $subkey => $subelement){
        $out .= "<td>$subelement</td>";
    }
    $out .= "</tr>";
    $c += 1;
    if ($c > 50){
		break;
	}
}
$out .= "</table><br><br>";
echo $out;
?>
</body>
</html>
