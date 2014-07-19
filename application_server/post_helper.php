<?php

/*
	$url is the POST url
	$code is an output variable
	$data contains an assoc. array with the POST body
*/
function Post($url, $code, $data) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER  , true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);

	$code = (string)curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	return $result;
}
?>