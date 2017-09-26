<?php
	require_once('includes/global.php');
	$amount = $_POST["amount"];
	$nonce = $_POST["payment_method_nonce"];
	$result = Braintree_Transaction::sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonce,
    'options' => [
        'submitForSettlement' => true
    ]
	]);
	echo "<pre>";
	var_dump($result);
	echo "</pre>";
?>