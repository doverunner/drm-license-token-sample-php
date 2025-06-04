# Doverunner PHP Token Sample (v3.0)

## 환경
- PHP Version 8.4.7 or later.
- Install Composer to use autoloader. 

## Quick Example
tests/SampleTest.php
```php
<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use Doverunner\Exception\DoverunnerTokenException;
use Doverunner\DoverunnerDrmTokenClient;
use Doverunner\TokenBuilder;
use Doverunner\PlaybackPolicyRequest;

$config = include "config/config.php";

try{
    // TokenClient constructor
    $DoverunnerTokenClient = new DoverunnerDrmTokenClient();
    
    /* Create playback policy rule */
    // https://doverunner.com/docs/en/multidrm/license/license-token/#playback-policy
    
    //persistent : true / duration : 600
    $playbackPolicyRequest = new PlaybackPolicyRequest(true, 600);
    
    //SecurityPolicy: SecurityPolicyRequest.php
    //$securityPolicyRequest = new SecurityPolicyRequest("ALL");
    
    //ExternalKey: ExternalkeyRequest.php
    
    /* Build rule */
    //https://doverunner.com/docs/en/multidrm/license/license-token/#token-rule-json
    $policyRequest = (new TokenBuilder)
        ->playbackPolicy($playbackPolicyRequest)
    //->securityPolicy($securityPolicyRequest)
        ->build();
    
    /* Create token */
    // siteId, accessKey, siteKey, userId, cid, policy is required.
    // https://doverunner.com/docs/en/multidrm/license/license-token/#token-json-example
    $result = $DoverunnerTokenClient
        ->playReady()
        ->siteId($config["siteId"])
        ->accessKey($config["accessKey"])
        ->siteKey($config["siteKey"])
        ->userId("testUser")
        ->cid("testCID")
        ->policy($policyRequest)
        ->execute();    
    
}catch (DoverunnerTokenException $e){
    $result = $e->toString();
}
    echo $result;
?>


ExternalKeyRequest

```

