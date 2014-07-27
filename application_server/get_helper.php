<?php

function MyGet($url, &$code) {
$ch = curl_init();

curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
));

$result = curl_exec($ch);

$code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);
return $result;
}

?>
