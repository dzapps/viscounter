

<html> 
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Viscounter - View Stats</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#from" ).datepicker();
    $( "#to" ).datepicker();
  } );
  </script>
</head>

<body>
<form action="viewstats.php" method="get">
<b>VIEW STATS</b>
<br><br><table>
	<tr>
<td>from</td>
<td><input id="from" name="from" type="date" /></td></tr>
<tr><td>to</td>
<td><input id="to" name="to" type="date" /></td></tr>
<br>
</table>
<br>

<input type="submit" value="Submit"></input>
</form>

<b>Blocking Cookie</b><br>
<?php
$cookie_name = "viscounter";
if($_COOKIE[$cookie_name] != "true") {
    echo "Cookie is NOT set!";
} else {
    echo "Cookie is set!";
}
?>
<br>
<button onclick="window.location.href='unsetblockingcookie.php'">Unset</button>
<button onclick="window.location.href='setblockingcookie.php'">Set</button>
</body>
</html>
