# PallyCon PHP Token Sample 

## 환경
- PHP Version 5.6 이상
- autoloader 를 사용하기 위해서는 Composer를 통해 설치. 

## Quick Example
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
    // tokenClient 생성
    $pallyConTokenClient = new PallyConDrmTokenClient();
    
    /* playback policy 룰 생성 */
    // https://pallycon.com/docs/en/multidrm/license/license-token/#playback-policy 
    $playbackPolicyRequest = new PlaybackPolicyRequest(false, false);
    
    /* 생성한 룰들을 합쳐서 빌드 */
    //https://pallycon.com/docs/en/multidrm/license/license-token/#token-rule-json
    $policyRequest = (new TokenBuilder)
        ->playbackPolicy($playbackPolicyRequest)
        ->build();
    
    /* 토큰 생성 */
    // siteId, accessKey, siteKey, userId, cid, policy 는 필수 값으로 반드시 set 되어야 한다.
    // https://pallycon.com/docs/en/multidrm/license/license-token/#token-json-example
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


ExternalKeyRequest

```

