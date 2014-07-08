<?php
function njit_login($user, $pass){
// user=UCID&pass=pass&uuid=0xACA021
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
"user" => $user,
"pass" => $pass,
"uuid" => "0xACA021"
)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);
 
// Logout to kill any sessions
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
curl_exec($ch);
curl_close($ch);
 
// Return validation bool
return strpos($result, "loginok.html") !== false;
}

$user = $_POST["user"];
$pass = $_POST["pass"];

$result = njit_login($user,$pass);

var_dump($result);
?>
