<?php

    /*
    In a production environment:
        - your verb and URL may differ between requests.
        - for GET/DELETE requests, you won't have any $xml
    */
    
    function makeHmac($xml)
    {
        $M_KEY ='1X1X1X1X1X1X';
        $verb = 'POST';
        $url = 'https://gateway.sagepayments.net/web_services/gateway/api/vaultcreditcardtokens';
        $HASHSUBJECT = $verb . $url . $xml;
        return base64_encode(hash_hmac('sha1', $HASHSUBJECT, $M_KEY, true));
    }

?>