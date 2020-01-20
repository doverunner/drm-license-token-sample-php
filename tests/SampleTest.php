<?php
namespace Test;

use PallyCon\Exception\PallyConTokenException;
use PallyCon\ExternalKeyRequest;
use PallyCon\HlsAesRequest;
use PallyCon\MpegCencRequest;
use PallyCon\NcgRequest;
use PallyCon\OutputProtectRequest;
use PallyCon\PallyConDrmTokenClient;
use PallyCon\PlaybackPolicyRequest;
use PallyCon\SecurityPolicyRequest;
use PallyCon\TokenBuilder;
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
            $pallyConTokenClient = new PallyConDrmTokenClient();

            /** --------------------------------------------------------
             * Sample Data
             */
            $playbackPolicyRequest = new PlaybackPolicyRequest(false, false);

            /**----------------------------------------------------------*/

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

            $this->assertEquals(json_encode([
                "playback_policy" => [
                    "limit" => false]]), json_encode($pallyConTokenClient->getPolicy()->toArray()));

            echo json_encode($pallyConTokenClient->getPolicy()->toArray());
        }catch (PallyConTokenException $e){
            $result = $e->toString();
        }
        echo $result;



    }

    /**
     *
     */
    public function testFullRuleSample(){
        $config = include "config/config.php";

        try {
            $pallyConTokenClient = new PallyConDrmTokenClient();

            /** --------------------------------------------------------
             * Sample Data
             */
            $playbackPolicyRequest = new PlaybackPolicyRequest(true, true, 0, "2020-01-15T00:00:00Z");

            $outputProtectRequest = new OutputProtectRequest(true, 2);
            $securityPolicyReqeust = new SecurityPolicyRequest(true, $outputProtectRequest, true, 150);

            $hlsAesRequest = new HlsAesRequest("123456781234FF781234567812345678", "123456781234FF781234567812345678");
            $mpegCencRequest = new MpegCencRequest("123456781234FF781234567812345678", "123456781234FF781234567812345678");
            $ncgRequest = new NcgRequest("123456781234FF78123456781234567812345678123456781234567812345678");
            $externalKeyRequest = new ExternalKeyRequest($hlsAesRequest, $mpegCencRequest, $ncgRequest);

            /*----------------------------------------------------------*/

            /* create token rule build*/
            $policyRequest = (new TokenBuilder)
                ->playbackPolicy($playbackPolicyRequest)
                ->securityPolicy($securityPolicyReqeust)
                ->externalKey($externalKeyRequest)
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

            $this->assertEquals(json_encode([
                "playback_policy" => [
                    "limit" => true,
                    "persistent" => true,
                    "expire_date" => "2020-01-15T00:00:00Z"
                ],
                "security_policy" => [
                    "hardware_drm" => true,
                    "output_protect" => [
                        "allow_external_display" => true,
                        "control_hdcp" => 2
                    ],
                    "allow_mobile_abnormal_device" => true,
                    "playready_security_level" => 150
                ],
                "external_key" => [
                    "mpeg_cenc" => [
                        "key_id" => "123456781234FF781234567812345678",
                        "key" => "123456781234FF781234567812345678"
                    ],
                    "hls_aes" => [
                        "key" => "123456781234FF781234567812345678",
                        "iv" => "123456781234FF781234567812345678"
                    ],
                    "ncg" => [
                        "cek" => "123456781234FF78123456781234567812345678123456781234567812345678"
                    ],
                ]

            ]), json_encode($pallyConTokenClient->getPolicy()->toArray()));


        }catch (PallyConTokenException $e){
            $result = $e->toString();
        }

        echo $result;
    }
}