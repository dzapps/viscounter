<?php
$cookie_name = "viscounter";
$cookie_value = "true";
setcookie($cookie_name, $cookie_value, time() + (86400 * 10000), "/");
setcookie($cookie_name, $cookie_value, time() + (86400 * 10000),"/", "julianibus.de");
?>

<!DOCTYPE html>
<html>
<body>

<?php echo "Cookie is set!"; ?>

</body>
</html> 
