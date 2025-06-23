<?php
namespace Test;

use Doverunner\Exception\DoverunnerTokenException;
use Doverunner\ExternalKeyRequest;
use Doverunner\HlsAesRequest;
use Doverunner\MpegCencRequest;
use Doverunner\NcgRequest;
use Doverunner\OutputProtectRequest;
use Doverunner\DoverunnerDrmTokenClient;
use Doverunner\PlaybackPolicyRequest;
use Doverunner\SecurityPolicyFairplay;
use Doverunner\SecurityPolicyNcg;
use Doverunner\SecurityPolicyPlayReady;
use Doverunner\SecurityPolicyRequest;
use Doverunner\SecurityPolicyWidevine;
use Doverunner\SecurityPolicyWiseplay;
use Doverunner\TokenBuilder;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * simple streaming license test
     */
    public function testSimpleRuleSample(){
        $config = include "config/config.php";
        try {
            $doverunnerTokenClient = new DoverunnerDrmTokenClient();

            /** --------------------------------------------------------
             * Sample Data
             */
            $playbackPolicyRequest = new PlaybackPolicyRequest(true, 1000);

            /**----------------------------------------------------------*/

            /* create token rule build */
            $policyRequest = (new TokenBuilder)
                ->playbackPolicy($playbackPolicyRequest)
                ->build();

            /* create token */
            $result = $doverunnerTokenClient
                ->playReady()
                ->siteId($config["siteId"])
                ->accessKey($config["accessKey"])
                ->siteKey($config["siteKey"])
                ->userId("testUser")
                ->cid("testCID")
                ->policy($policyRequest)
                ->execute();

            $this->assertEquals(json_encode([
                "policy_version" => 2,
                "playback_policy" => [
                    "persistent" => true, "allowed_track_types"=>"ALL", "license_duration"=>1000, "rental_duration"=>0,
                    "playback_duration"=>0]]), json_encode($doverunnerTokenClient->getPolicy()->toArray()));

            echo "testSimpleRuleSample :".json_encode($doverunnerTokenClient->getPolicy()->toArray()) . "\n";
        }catch (DoverunnerTokenException $e){
            $result = $e->toString();
        }
        echo $result . "\n";;

    }

    /**
     * simple offline streaming license test
     */
    public function testOfflineSimpleRuleSample(){
        $config = include "config/config.php";
        try {
            $doverunnerTokenClient = new DoverunnerDrmTokenClient();

            /** --------------------------------------------------------
             * Sample Data
             */
            $playbackPolicyRequest = new PlaybackPolicyRequest(true, 0, "", 2000, 2000);

            /**----------------------------------------------------------*/

            /* create token rule build */
            $policyRequest = (new TokenBuilder)
                ->playbackPolicy($playbackPolicyRequest)
                ->build();

            /* create token */
            $result = $doverunnerTokenClient
                ->playReady()
                ->siteId($config["siteId"])
                ->accessKey($config["accessKey"])
                ->siteKey($config["siteKey"])
                ->userId("testUser")
                ->cid("testCID")
                ->policy($policyRequest)
                ->execute();

            $this->assertEquals(json_encode([
                "policy_version" => 2,
                "playback_policy" => [
                    "persistent" => true, "allowed_track_types"=>"ALL", "license_duration"=>0, "rental_duration"=>2000, "playback_duration"=>2000]]), json_encode($doverunnerTokenClient->getPolicy()->toArray()));

            echo "testOfflineSimpleRuleSample :".json_encode($doverunnerTokenClient->getPolicy()->toArray()) . "\n";
        }catch (DoverunnerTokenException $e){
            $result = $e->toString();
        }
        echo $result . "\n";

    }

    /**
     *
     */

    public function testFullRuleSample(){
        $config = include "config/config.php";

        try {
            $doverunnerTokenClient = new DoverunnerDrmTokenClient();

            /** --------------------------------------------------------
             * Sample Data
             */
            $playbackPolicyRequest = new PlaybackPolicyRequest( true, 0, "2020-01-15T00:00:00Z");

            $securityPolicyWidevine = new SecurityPolicyWidevine(1, 'HDCP_V1');
            $securityPolicyPlayReady = new SecurityPolicyPlayReady(3000, 200, 200);
            $securityPolicyFairplay = new SecurityPolicyFairplay(1,true,false);
            $securityPolicyNcg = new SecurityPolicyNcg(false, false, 1);
            $securityPolicyWiseplay = new SecurityPolicyWiseplay(0, 1);

            $securityPolicyAll = new SecurityPolicyRequest("ALL", $securityPolicyWidevine
                                        , $securityPolicyPlayReady, $securityPolicyFairplay, $securityPolicyNcg
                                        , $securityPolicyWiseplay);

            $hlsAesRequest = new HlsAesRequest("ALL", "123456781234FF781234567812345678", "123456781234FF781234567812345678", "123456781234FF781234567812345678");
            $mpegCencRequest = new MpegCencRequest("ALL", "113456781234FF781234567812345678", "113456781234FF781234567812345678");
            $ncgRequest = new NcgRequest("123456781234FF78123456781234567812345678123456781234567812345678");
            $externalKeyRequest = new ExternalKeyRequest(array($mpegCencRequest), array($hlsAesRequest), $ncgRequest);

            /*----------------------------------------------------------*/

            /* create token rule build*/
            $policyRequest = (new TokenBuilder)
                ->playbackPolicy($playbackPolicyRequest)
                ->securityPolicy(array($securityPolicyAll))
                ->externalKey($externalKeyRequest)
                ->build();

            /* create token */
            $result = $doverunnerTokenClient
                ->playReady()
                ->siteId($config["siteId"])
                ->accessKey($config["accessKey"])
                ->siteKey($config["siteKey"])
                ->userId("testUser")
                ->cid("testCID")
                ->policy($policyRequest)
                ->responseFormat("custom")
                ->execute();

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
                        "security_level" => 1,
                        "required_hdcp_version" => "HDCP_V1",
                        "allow_test_device" => true
                    ],
                    "playready" =>[
                        "security_level"=>3000,
                        "digital_video_protection_level" => 200,
                        "analog_video_protection_level" => 200,
                        "enable_license_cipher" => false,
                    ],
                    "fairplay" =>[
                        "hdcp_enforcement"=>1,
                        "allow_airplay"=>true,
                        "allow_av_adapter"=>false
                    ],
                    "ncg" =>[
                        "allow_mobile_abnormal_device"=>false,
                        "allow_external_display"=>false,
                        "control_hdcp"=>1
                    ],
                    "wiseplay" => [
                        "security_level" => 0,
                        "output_control" => 1,
                    ]
                ]],
                "external_key" => [
                    "mpeg_cenc" => [[
                        "track_type" => "ALL",
                        "key_id" => "113456781234FF781234567812345678",
                        "key" => "113456781234FF781234567812345678"
                    ]],
                    "hls_aes" => [[
                        "track_type" => "ALL",
                        "key" => "123456781234FF781234567812345678",
                        "iv" => "123456781234FF781234567812345678",
                        "key_id" => "123456781234FF781234567812345678"
                    ]],
                    "ncg" => [
                        "cek" => "123456781234FF78123456781234567812345678123456781234567812345678"
                    ],
                ]

            ]), json_encode($doverunnerTokenClient->getPolicy()->toArray()));

            $this->assertEquals("custom", $doverunnerTokenClient->getResponseFormat());
            echo "testFullRuleSample :".json_encode($doverunnerTokenClient->getPolicy()->toArray()) . "\n";
        }catch (DoverunnerTokenException $e){
            $result = $e->toString();
        }

        echo "testFullRuleSample : " . $result . "\n";
    }
}