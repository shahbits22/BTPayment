<?php


require_once './vendor/braintree/braintree_php/lib/Braintree.php';
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9yrtqbh6v3d7929g');
Braintree_Configuration::publicKey('w7cbprq7s5kzjb45');
Braintree_Configuration::privateKey('44f692cd30d80aa8557bf648cfbb07a0');

if(isset($_GET["bt_challenge"])) {
    echo(Braintree_WebhookNotification::verify($_GET["bt_challenge"]));
}

//$sampleNotification = Braintree_WebhookTesting::sampleNotification(
//    Braintree_WebhookNotification::SUBSCRIPTION_WENT_PAST_DUE,
//    'my_id'
//);
//$webhookNotification = Braintree_WebhookNotification::parse(
//    $sampleNotification['signature'],
//    $sampleNotification['payload']
//);
//$message = $webhookNotification->subscription->id;
//echo $message;
if(
    isset($_POST["bt_signature"]) &&
    isset($_POST["bt_payload"])
) {
	$webhookNotification = Braintree_WebhookNotification::parse(
        $_POST["bt_signature"], $_POST["bt_payload"]);
		
		$message =
        "[Webhook Received " . $webhookNotification->timestamp->format('Y-m-d H:i:s') . "] "
        . "Kind: " . $webhookNotification->kind . " | "
		. "MerchantAccountStatus: " . $webhookNotification->merchantAccount->status . " | "
		. "MerchantAccountID: " . $webhookNotification->merchantAccount->id . " | "
		. "MasterMerchantAccoutnID: " . $webhookNotification->merchantAccount->masterMerchantAccount->id . "\n";
       

    file_put_contents("webhook.log", $message, FILE_APPEND);
}

?>