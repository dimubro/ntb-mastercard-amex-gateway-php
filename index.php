<?php

$url = 'https://nationstrustbankplc.gateway.mastercard.com/api/nvp/version/62';

$data = array(
    'apiOperation' => 'CREATE_CHECKOUT_SESSION',
    'apiUsername' => 'merchant user name',
    'apiPassword' => 'api_password',
    'merchant' => 'merchent_id',
    'order.id' => '15245',
    'order.amount' => '10.00',
    'order.currency' => 'LKR',
    'order.description' => 'ONLINE PURCHASE',
    'interaction.returnUrl' => 'http://url_url/status.php?ReceiptNo=15245',
    'interaction.merchant.name' => 'merchanrt name',
    'interaction.operation' => 'PURCHASE',
);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

$response = curl_exec($ch);

if ($response === false) {
    // redirect payment fail
} else {
    
    $pattern = "/successIndicator=([^\&]+)/";
    if (preg_match($pattern, $response, $matches)) {
                
        $successIndicator = $matches[1];
        //Update the order details with the successIndicator. This is intended to verify the success of the payment. 
    }
    $pattern = "/session\.id=([^\&]+)/";

    // Use preg_match to extract the session.id value
    if (preg_match($pattern, $response, $matches)) {
        // The session.id value will be in $matches[1]
        $sessionID = $matches[1];
        
    }

}

curl_close($ch);


?>

<html>
    <head>
        <script src="https://nationstrustbankplc.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="errorCallback" data-cancel="cancelCallback"></script>
        <script type="text/javascript">
            function errorCallback(error) {
                  console.log(JSON.stringify(error));
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
            }
            Checkout.configure({
              session: { 
                id: '<?=$sessionID?>'
                }
            });
        </script>
    </head>
    <body>
       ...
      <div id="embed-target"> </div> 
      <input type="button" value="Pay with Embedded Page" onclick="Checkout.showEmbeddedPage('#embed-target');" />
      <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />
       ...
    </body>
</html>