<?php

namespace Test;

error_reporting(E_ALL);
ini_set('display_errors', "1");


use Doverunner\SecurityPolicyWidevine;
use PHPUnit\Framework\TestCase;

use Doverunner\Exception\DoverunnerTokenException;
use Doverunner\DoverunnerDrmTokenClient;
use Doverunner\PlaybackPolicyRequest;
use Doverunner\SecurityPolicyRequest;
use Doverunner\ExternalKeyRequest;
use Doverunner\HlsAesRequest;
use Doverunner\MpegCencRequest;
use Doverunner\NcgRequest;
use Doverunner\TokenBuilder;


class DoverunnerDrmTokenClientTest extends TestCase
{
    private $_config;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_config = include "config/config.php";
    }

    public function testDrmType(){
        $DoverunnerTokenDrmClient = new DoverunnerDrmTokenClient();

        $DoverunnerTokenDrmClient->playready();
        $this->assertEquals("PlayReady", $DoverunnerTokenDrmClient->getDrmType());
        $DoverunnerTokenDrmClient->widevine();
        $this->assertEquals("Widevine", $DoverunnerTokenDrmClient->getDrmType());
        $DoverunnerTokenDrmClient->fairplay();
        $this->assertEquals("FairPlay", $DoverunnerTokenDrmClient->getDrmType());
        $DoverunnerTokenDrmClient->ncg();
        $this->assertEquals("NCG", $DoverunnerTokenDrmClient->getDrmType());
        $DoverunnerTokenDrmClient->wiseplay();
        $this->assertEquals("Wiseplay", $DoverunnerTokenDrmClient->getDrmType());
    }

    public function testRequireValue(){
        $DoverunnerTokenDrmClient = new DoverunnerDrmTokenClient();
        try{
            $DoverunnerTokenDrmClient->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode() . "\n";
            $this->assertEquals(1000, $e->getCode());
        }

        try{
            $DoverunnerTokenDrmClient->userId("testUser")->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode(). "\n";
            $this->assertEquals(1001, $e->getCode());
        }

        try{
            $DoverunnerTokenDrmClient->cid("test-cid")->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode(). "\n";
            $this->assertEquals(1002, $e->getCode());
        }

        try{
            $DoverunnerTokenDrmClient->siteId($this->_config["siteId"])->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode(). "\n";
            $this->assertEquals(1003, $e->getCode());
        }
        try{
            $DoverunnerTokenDrmClient->siteId($this->_config["accessKey"])->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode(). "\n";
            $this->assertEquals(1003, $e->getCode());
        }
        try{
            $DoverunnerTokenDrmClient->siteId($this->_config["siteKey"])->execute();
        }catch (DoverunnerTokenException $e){
            echo $e->getCode(). "\n";
            $this->assertEquals(1003, $e->getCode());
        }
    }
    public function testFullRule()
    {
        $DoverunnerTokenDrmClient = new DoverunnerDrmTokenClient();

        $playbackPolicyRequest = new PlaybackPolicyRequest(true, 0, "2020-01-15T00:00:00Z");

        $securityPolicyWidevine = new SecurityPolicyWidevine(5);

        $securityPolicyReqeust = new SecurityPolicyRequest("ALL", $securityPolicyWidevine);

        $hlsAesRequest = new HlsAesRequest("ALL", "12345678123456781234567812345678", "12345678123456781234567812345678", "12345678123456781234567812345678");
        $mpegCencRequest = new MpegCencRequest("ALL", "11345678123456781234567812345678", "11345678123456781234567812345678");
        $ncgRequest = new NcgRequest("1234567812345678123456781234567812345678123456781234567812345678");

        $externalKeyRequest = new ExternalKeyRequest(array($mpegCencRequest), array($hlsAesRequest), $ncgRequest);


        /* create token rule */
        $policyRequest = (new TokenBuilder)
            ->playbackPolicy($playbackPolicyRequest)
            ->securityPolicy(array($securityPolicyReqeust))
            ->externalKey($externalKeyRequest)
            ->build();

        $DoverunnerTokenDrmClient->playready()
            ->siteId($this->_config["siteId"]);

        echo("testFullRule : ".$policyRequest->toJsonString());

        $this->assertEquals(json_encode([
            "policy_version" => 2,
            "playback_policy" => [
                "persistent" => true,
                "allowed_track_types" => "ALL",
                "license_duration" => 0,
                "expire_date" => "2020-01-15T00:00:00Z",
                "rental_duration" => 0,
                "playback_duration" => 0
            ],
            "security_policy" => [[
                "track_type" => "ALL",
                "widevine" => [
                    "security_level" => 5,
                    "allow_test_device" => true
                ]
            ]],
            "external_key" => [
                "mpeg_cenc" => [[
                    "track_type" => "ALL",
                    "key_id" => "11345678123456781234567812345678",
                    "key" => "11345678123456781234567812345678"
                ]],
                "hls_aes" => [[
                    "track_type" => "ALL",
                    "key" => "12345678123456781234567812345678",
                    "iv" => "12345678123456781234567812345678",
                    "key_id" => "12345678123456781234567812345678",
                ]],
                "ncg" => [
                    "cek" => "1234567812345678123456781234567812345678123456781234567812345678"
                ],
            ]

        ]), json_encode($policyRequest->toArray()));
    }
}
