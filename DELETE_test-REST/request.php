<?php

    $reference= '' . $_POST['Ref'] . '';
    $sageHost= "https://gateway.sagepayments.net";
    $sageURL= "/web_services/gateway/api/ecommercetransactions";
    
    $MID = '111111111111';
    $MKEY = '1X1X1X1X1X1X';
    
    echo '<pre>';
    
    echo "Using Ref # " . (string)$reference;
    echo "</br></br>";
    
    echo "URL being used is " . $sageURL;
    echo "</br></br>";
    
    echo "MID: " . (string)$MID;
    echo "</br></br>";
    
    $builtURL= $sageHost . $sageURL . "/" . (string)$reference;
    $combinedRequestString = "DELETE" . $builtURL;
    $HMAC = base64_encode(hash_hmac('sha1', $combinedRequestString, $MKEY, true));
    
    echo "Request made with HMAC: " . (string)$HMAC;
    echo "</br></br>";
    echo "Requested URL is: " . $builtURL;
    echo "</br></br>";
    
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $builtURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE,1);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
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
