<?php
require_once __DIR__  . '/PayPal-PHP-SDK/autoload.php';
require_once 'paypal.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

return getApiContext();

function getApiContext() {

	$apiContext = new ApiContext(new OAuthTokenCredential(
			'AbudRYBtDHMgkeZ3ohaF35yx1iNydgrN3FbWmNMD6jqdk-gfv50WWUpbytPfgowKpLAyNohBdorbcyyY',     // ClientID
	        'EKi_7EqzXJ3-HKAkTo5A2nOztUSIsQymmaDql1VK-nEOXD1meqKTr7EJsuneh8zolxKdzD_l_310K-5d'
	));
	return $apiContext;
}