<?php

# REMINDER: This only works for DRM Free Channels
# As of me writing this, it works for all Disney Channels and Freeform HD.

# Required Cookies:
# JSESSIONID
# DYN_USER_ID
# DYN_USER_CONFIRM
# These can be gotten with Cookies.txt or any other Cookie Related Extension, Fiddler or Chrome DevTools

# Account must be paid and in good standing with whatever plan allows watching online.

if(!isset($_GET["chid"])) {
    exit();
}
$c = curl_init('https://www.directv.com/json/authorization');
curl_setopt($c, CURLOPT_VERBOSE, 1);
$cookies = 'JSESSIONID=123; DYN_USER_ID=456; DYN_USER_CONFIRM=789;'
curl_setopt($c, CURLOPT_COOKIE, $cookies);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_REFERER, "https://www.directv.com/guide?lpos=Header:1");
curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36");
curl_setopt($c, CURLOPT_HTTPHEADER, array("Accept: application/json, text/plain, */*", "DNT: 1", "Accept-Language: en-US;q=0.9,en;q=0.8")); 
$page = json_decode(curl_exec($c), true);
curl_close($c);

$c = curl_init("https://pgauth-ca.dtvce.com/pgauth/content/authorize?et=".rawurlencode($page["authorization"]["etoken"])."&sig=".rawurlencode($page["authorization"]["signature"])."&sid=".$page["authorization"]["siteId"]."&suid=".$page["authorization"]["siteUserId"]."&actiontype=1&clientid=web&channel.id=".$_GET["chid"]."&geo.zipcode=&output=json");
curl_setopt($c, CURLOPT_VERBOSE, 1);
curl_setopt($c, CURLOPT_COOKIE, 'JSESSIONID=WRT0cKxLtrS0nc3Sqv6CjT2YnGhhG8HJXvRKkDDTjcLJhNj61pCp!1075333385; DYN_USER_ID=1488169957; DYN_USER_CONFIRM=52dc6a3daafbde397177b136d8cb1341;');
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_REFERER, "https://www.directv.com/guide?lpos=Header:1");
curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36");
curl_setopt($c, CURLOPT_HTTPHEADER, array("Accept: */*", "DNT: 1", "Accept-Language: en-US;q=0.9,en;q=0.8")); 
$page = json_decode(curl_exec($c), true);
curl_close($c);
header("Location: ".$page["playBackUrl"]);

?>
