<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

$LOGFILE = "viscounter_log.dat";
$COUNTFILE = "viscounter_count.dat";


//ERROR HANDLING
if (file_exists($LOGFILE) == 0) {
    fatal_error("No data yet?");
}


if ($_GET["from"] == "")  {
	fatal_error("Please enter a valid start date.");
}
if ($_GET["to"] == "") {
	fatal_error("Please enter a valid end date.");
}

//FUNCTION DECLARATIONS

function fatal_error($text){
	echo '<div style="background-color:red;color:white;padding:2%;">'.$text.'</div><br><br><a href="index.php">Back</a>';
	die();
}


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
        array_push($aryRange,date('Y-m-d',$iDateFrom)); 
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; 
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function getasciibar($count, $max) {
	$MAXLENGTH = 30;
	$BARCHAR = "█";
	if ($max == "") {
		$bar = "";
	}
	else {
		$bar = str_repeat($BARCHAR,($count / $max)*$MAXLENGTH);
	}
	return $bar;
}


//PREPARATION

	
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

$maxvalue = max(array_values($datescounted));
foreach ($statdates as $statdate) {
	
	$count = $datescounted[$statdate];
	if ($count == null) {$count = "0";}
	$OUT = $OUT."<br>$statdate&emsp;$count&emsp;".getasciibar($count, $maxvalue);
	$TOTALINTERVAL += $count;
}


//OUTPUT
//Total & Selection by day with ascii bar graph

echo "<b>TOTAL</b><br>$TOTAL<br><br><b>SELECTION</b><br>$TOTALINTERVAL<br><br>$OUT";

//Page hits
echo "<br><br><b>PAGE HITS</b><br><br>";

$out  = "";
$out .= "<table>";

$maxvalue = 10;
foreach($array2 as $key => $element){
    foreach($element as $subkey => $subelement){
        $count = $subelement;
    }
    if ($count > $maxvalue) { 
		$maxvalue = $count;
	}
}

foreach($array2 as $key => $element){
    $out .= "<tr>";
    foreach($element as $subkey => $subelement){
        $out .= "<td>$subelement</td>";
        $count = $subelement;
    }
    $out .= "<td>".getasciibar($count, $maxvalue)."</td></tr>";
}
$out .= "</table><br><br>";
echo $out;

//Recent pageloads

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
