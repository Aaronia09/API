<?php
	$url = 'http://127.0.0.1/API/marque.php';
	$data = array('marque_id' => '1',
	 'nom' => 'Toyota', 
	 'pays' => 'Japon', 
	 );
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