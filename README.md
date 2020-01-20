#PallyCon PHP Token Sample 

## 환경
- PHP Version 5.6 이상


Quick Examples

Create Streaming license
```php
<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use PallyCon\Exception\PallyConTokenException;
use PallyCon\PallyConDrmTokenClient;
use PallyCon\TokenBuilder;
use PallyCon\PlaybackPolicyRequest;

$config = include "config/config.php";

try{
    $pallyConTokenClient = new PallyConDrmTokenClient();
    
    /* create playback policy */
    $playbackPolicyRequest = new PlaybackPolicyRequest(false, false);
    
    /* create token rule build */
    $policyRequest = (new TokenBuilder)
        ->playbackPolicy($playbackPolicyRequest)
        ->build();
    
    /* create token */
    $result = $pallyConTokenClient
        ->playReady()
        ->siteId($config["siteId"])
        ->accessKey($config["accessKey"])
        ->siteKey($config["siteKey"])
        ->userId("testUser")
        ->cid("testCID")
        ->policy($policyRequest)
        ->execute();    
}catch (PallyConTokenException $e){
    $result = $e->toString();
}
    echo $result;
?>
```

