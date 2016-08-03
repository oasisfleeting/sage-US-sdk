<?php
    
    // Your user was redirected to this page after completing their payment on the SEVD interface.
       // *If you're processing a Non-UI transaction this does not apply to you.
    // During that redirect, their browser made a POST containing the transaction response.
    
    // Just like the original request, the response is tokenized to avoid exposing any information 
    // to the user's browser.
    
    $Sage_msg="";
    
    $tokenized_response = $_POST['response'];

    // This cURL block is decrypting the response.
    $detokenization_url = 'https://www.sageexchange.com/virtualpaymentterminal/frmopenenvelope.aspx';
    $request = 'request=' . urlencode($tokenized_response);
    $ch = curl_init($detokenization_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $request = stripcslashes(curl_exec ($ch));
        $raw_response = stripcslashes(curl_exec($ch));
    curl_close($ch);
    
    if ((substr($request,0,13)=="status_code=6") ||  (substr($request,0,13)=="status_code=7")) {
	if (substr($request,0,13)=="status_code=6") {
		$Sage_msg="User cancelled transaction";
	    //header('location:');
	}
	if (substr($request,0,13)=="status_code=7") {
		$Sage_msg="Transaction Timeout";
	    //header('location:');
	}
	echo "<br /><br />".$Sage_msg."<br /><br />";
	}
    
    // Casting the response string to an XML object makes handling the data much easier.
    // PHP's SimpleXMLElement class really doesn't like it when XML is labeled UTF-16 
    // but contains UTF-8 data. A quick str_replace() takes care of this.
    try
    {
        $response = new SimpleXMLElement($raw_response);
    }
    catch (Exception $e)
    {
        $raw_response = str_replace("utf-16", "utf-8", $raw_response);
        $response = new SimpleXMLElement($raw_response);
    }

    
    // [Some database calls and/or logging here, probably.]

?>


<!DOCTYPE html>
<html>
    <head>
        <title>pg 3 - SEVD Sample</title>
    </head>
    
    <body>
        
        <h3>Payment Results:</h3>
        <!-- We're done! Give your user a result: -->
        
        <?php
            echo '<pre>';
            echo 'Thank you for shopping with us, ' . $response->PaymentResponses->PaymentResponseType->Customer->Name->FirstName . '! <br />';
            echo 'Your transaction was ' . $response->PaymentResponses->PaymentResponseType->Response->ResponseMessage . '<br />';
            echo 'Your order number is ' . $response->PaymentResponses->PaymentResponseType->TransactionResponse->Reference1 . '<br />';
            echo '</pre>';
        ?>

    </body>
</html>
