<?php
$url = "http://127.0.0.1/API/voiture.php/1"; // modifier le produit 1
$data = array('nom' => 'Mercedes',
	 'designation' => 'Belle Voiture', 
	 'prix' => '96580000', 
	 'couleur' => 'Bleu',
	 'annee' => '2020');
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