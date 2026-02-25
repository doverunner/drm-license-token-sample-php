# DoveRunner Token Sample - PHP (v3.1.0)

## Overview

This repository provides server-side sample code that can generate license token for DoveRunner multi-DRM service. DRM license tokens are used to authenticate license requests in multi-DRM integration workflows.

Here's how a license token works in the DRM license issuance process.
- When a multi-DRM client tries to play DRM content, the client requests a token to the content service platform to acquire DRM license. The service platform verifies that the user requesting the token has permission to the content, and then generates a token data according to the specification.
- The service platform can set usage rights and various security policies in the token data. The generated token is delivered to the client as response.
- When the client requests a DRM license with the token, DoveRunner cloud server validates the token and issues a license.

## Documentation

- [DoveRunner Docs](https://doverunner.com/docs/)


## Environment
- PHP Version 8.4.7 or later.
- Install Composer to use autoloader.

## Configuration

Before running the sample code, you need to configure your DoveRunner credentials.

1. Copy the example configuration file:
   ```bash
   cp tests/config/config.php.example tests/config/config.php
   ```

2. Edit `tests/config/config.php` and fill in your credentials:
   ```php
   <?php
   return [
       // DoveRunner API Credentials (required)
       'siteId'=> 'your-site-id',
       'siteKey'=> 'your-site-key',
       'accessKey'=> 'your-access-key',

       // User and Content Identifiers (required)
       'userId'=> 'test-user',
       'cid'=> 'test-cid'
   ];
   ```

3. Get your credentials from [DoveRunner Console](https://console.doverunner.com)

**Note**: `config.php` is excluded from version control for security. Never commit sensitive credentials to the repository.

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
    // https://doverunner.com/docs/content-security/multi-drm/license/license-token/#playback_policy
    
    //persistent : true / duration : 600
    $playbackPolicyRequest = new PlaybackPolicyRequest(true, 600);
    
    //SecurityPolicy: SecurityPolicyRequest.php
    //$securityPolicyRequest = new SecurityPolicyRequest("ALL");
    
    //ExternalKey: ExternalkeyRequest.php
    
    /* Build rule */
    //https://doverunner.com/docs/content-security/multi-drm/license/license-token/#token-json-format
    $policyRequest = (new TokenBuilder)
        ->playbackPolicy($playbackPolicyRequest)
    //->securityPolicy($securityPolicyRequest)
        ->build();
    
    /* Create token */
    // siteId, accessKey, siteKey, userId, cid, policy is required.
    // https://doverunner.com/docs/content-security/multi-drm/license/license-token/#token-json-example
    $result = $DoverunnerTokenClient
        ->playReady()
        ->siteId($config["siteId"])
        ->accessKey($config["accessKey"])
        ->siteKey($config["siteKey"])
        ->userId($config["userId"])
        ->cid($config["cid"])
        ->policy($policyRequest)
        ->execute();    
    
}catch (DoverunnerTokenException $e){
    $result = $e->toString();
}
    echo $result;
?>


ExternalKeyRequest

```

## Support

If you have any questions or issues with the token sample, please create a ticket at [DoveRunner Helpdesk](https://support.doverunner.com) website.
