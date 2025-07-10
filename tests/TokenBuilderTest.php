<?php
namespace Test;

use DoveRunner\Exception\DoveRunnerTokenException;
use DoveRunner\PlaybackPolicyRequest;
use DoveRunner\TokenBuilder;
use PHPUnit\Framework\TestCase;

class TokenBuilderTest extends TestCase{
    public function testBuild(){
        $tokenBuilder = new TokenBuilder();

        //expireDate Setting
        $playbackPolicyRequest = new PlaybackPolicyRequest(true, 0, "2020-01-15T00:00:00Z");

        $policyRequest = $tokenBuilder->playbackPolicy($playbackPolicyRequest)->build();

        $this->assertEquals("{\"policy_version\":2,\"playback_policy\":{\"persistent\":true,\"allowed_track_types\":\"ALL\",\"license_duration\":0,\"expire_date\":\"2020-01-15T00:00:00Z\",\"rental_duration\":0,\"playback_duration\":0}}",  $policyRequest->toJsonString());

        //duration Setting
        $playbackPolicyRequest = new PlaybackPolicyRequest(true, 160);

        $policyRequest = $tokenBuilder->playbackPolicy($playbackPolicyRequest)->build();

        $this->assertEquals("{\"policy_version\":2,\"playback_policy\":{\"persistent\":true,\"allowed_track_types\":\"ALL\",\"license_duration\":160,\"rental_duration\":0,\"playback_duration\":0}}",  $policyRequest->toJsonString());
    }
}