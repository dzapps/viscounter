<?php


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}

$user_os        =   getOS();
$user_browser   =   getBrowser();

$caller = $_SERVER['HTTP_REFERER'];
$ip = get_client_ip();
$hits = 0;

$LOGFILE = "mincount_log.dat";
$COUNTFILE = "mincount_count.dat";



if(!file_exists($LOGFILE))
{
   $fp = fopen($LOGFILE,"w"); 
   fwrite($fp,"");
   fclose($fp);
}

if(!file_exists($COUNTFILE))
{
   $fp = fopen($COUNTFILE,"w"); 
   fwrite($fp,""); 
   fclose($fp);
}

$date = time();


$current = file_get_contents($LOGFILE);
$current = $date.",".$ip . ",".$user_os.",".$user_browser.",".$caller . "\n".$current;
file_put_contents($LOGFILE, $current);

$current = file_get_contents($COUNTFILE);
$counted = false;
$out = "";
foreach(preg_split("/((\r?\n)|(\r\n?))/", $current) as $line){
	if (strcasecmp($line, "") != 0) {
    $sline = explode(",", $line);
    $url = $sline[0];
    $count = $sline[1];
    if (strcasecmp($url, $caller) == 0) {
			$counted = true;
			$out = $out . $url.",".($count + 1)."\n";
			$hits = ($count + 1);
	 }
	 else {
	 		$out = $out . $line."\n";	 
	 }
	}
} 

if ($counted == false){
		$out .= $caller.",1\n";
}

file_put_contents($COUNTFILE, $out);

echo $hits

?>
