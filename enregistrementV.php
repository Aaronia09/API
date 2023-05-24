<?php
	$url = 'http://127.0.0.1/API/voiture.php';
	$data = array('nom' => 'Mercedes',
	 'designation' => 'Belle Voiture', 
	 'prix' => '96580000', 
	 'couleur' => 'Bleu',
	 'annee' => '2020');
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	var_dump($result);
?>