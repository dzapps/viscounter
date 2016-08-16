<?php



$host = $_SERVER['HTTP_HOST'];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $DOMAIN);

$cookie_name = "viscounter";
$cookie_value = "false";

setcookie($cookie_name, $cookie_value, time() + (86400 * 10000), "/"); 
setcookie($cookie_name, $cookie_value, time() + (86400 * 10000),"/", $DOMAIN[0]);

?>
<!DOCTYPE html>
<html>
<body>
<?php echo "Cookie is NOT set!<br><a href='index.php'>Back</a>"; ?>

</body>
</html> 
