<?php
namespace Test;

use PallyCon\Exception\PallyConTokenException;
use PallyCon\PlaybackPolicyRequest;
use PallyCon\TokenBuilder;
use PHPUnit\Framework\TestCase;

class TokenBuilderTest extends TestCase{
    public function testBuild(){
        $tokenBuilder = new TokenBuilder();

        //expireDate Setting
        $playbackPolicyRequest = new PlaybackPolicyRequest(true, true, 0, "2020-01-15T00:00:00Z");

        $policyRequest = $tokenBuilder->playbackPolicy($playbackPolicyRequest)->build();

        $this->assertEquals("{\"playback_policy\":{\"limit\":true,\"persistent\":true,\"expire_date\":\"2020-01-15T00:00:00Z\"}}",  $policyRequest->toJsonString());

        //duration Setting
        $playbackPolicyRequest = new PlaybackPolicyRequest(true, true, 160);

        $policyRequest = $tokenBuilder->playbackPolicy($playbackPolicyRequest)->build();

        $this->assertEquals("{\"playback_policy\":{\"limit\":true,\"persistent\":true,\"duration\":160}}",  $policyRequest->toJsonString());

        //error
        $playbackPolicyRequest = new PlaybackPolicyRequest(false, true, 160);
        try {
            $tokenBuilder->playbackPolicy($playbackPolicyRequest)->build();
        }catch (PallyConTokenException $e){
            $this->assertEquals(1010, $e->getCode());
        }

    }
}