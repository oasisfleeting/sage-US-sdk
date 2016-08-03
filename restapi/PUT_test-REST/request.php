<?php

    //Puts together the URL
    $reference= '' . $_POST['Ref'] . '';
    $sageHost= "https://gateway.sagepayments.net";
    $sageURL= "/web_services/gateway/api/ecommercetransactions";
    
    $MID = '111111111111';
    $MKEY = '1X1X1X1X1X1X';
    
    $transaction = '<?xml version="1.0" encoding="utf-8"?> 
    <CreditCardCaptureTransactionRequest xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/wapiGateway.Models"> 
    <T_AMT>' . $_POST['Amt'] . '</T_AMT> 
    <T_TAX>' . $_POST['Tax'] . '</T_TAX> 
    </CreditCardCaptureTransactionRequest>';
    
    echo '<pre>';
    
    echo "Using Ref # " . (string)$reference;
    echo "</br></br>";
    
    echo "URL being used is " . $sageURL;
    echo "</br></br>";
    
    echo "MID: " . (string)$MID;
    echo "</br></br>";
    
    $builtURL= $sageHost . $sageURL . "/" . (string)$reference;
    $combinedRequestString = "PUT" . $builtURL . $transaction;
    $HMAC = base64_encode(hash_hmac('sha1', $combinedRequestString, $MKEY, true));
    
    echo "Request made with HMAC: " . (string)$HMAC;
    echo "</br></br>";
    echo "Requested URL is: " . $builtURL;
    echo "</br></br>";
    echo "Amounts submitted: " . (string)$transaction;
    echo "</br></br>";
    
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $builtURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $transaction);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/xml; charset=utf-8',
            'Accept: application/xml',
           'Authentication: ' . $MID . ":" . $HMAC
           )
        );
        curl_setopt($ch, CURLOPT_HEADER,1);
        $result = curl_exec($ch);
        $respCodes = curl_getinfo($ch);
    curl_close($ch);
    
    echo "Response code to request was: " . $respCodes['http_code'];
    if ($respCodes['http_code'] <> 200) {
            exit;
    }
    echo "</br></br>";
    echo "Results: " . $result;
    echo "</br></br>";
    echo '</pre>';
?>
