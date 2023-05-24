<?php
$url = "http://127.0.0.1/API/categorie.php/1"; 
$data = array( 'categorie_id' => '1',
'nom' => 'Desert'
 
	 );
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response) 
{
    return false;
}
?>