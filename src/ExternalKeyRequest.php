<?php
namespace PallyCon;

use PallyCon\HlsAesRequest;
use PallyCon\MpegCencRequest;
use PallyCon\NcgRequest;

class ExternalKeyRequest
{
    public $_mpegCenc;
    public $_hlsAes;
    public $_ncg;

    /**
     * HlsAesRequest constructor.
     * @param HlsAesRequest|null $hlsAesRequest
     * @param MpegCencRequest|null $mpegCencRequest
     * @param NcgRequest|null $ncgRequest
     */
    public function __construct(HlsAesRequest $hlsAesRequest=null
                                , MpegCencRequest $mpegCencRequest=null
                                , NcgRequest $ncgRequest=null)
    {
        if(!empty($hlsAesRequest)){
            $this->_hlsAes = $hlsAesRequest;
        }
        if(!empty($hlsAesRequest)){
            $this->_mpegCenc = $mpegCencRequest;
        }
        if(!empty($hlsAesRequest)){
            $this->_ncg = $ncgRequest;
        }
    }

    public function toArray(){
        $arr= [];
        if(isset($this->_mpegCenc)){
            $arr["mpeg_cenc"] = $this->_mpegCenc->toArray();
        }
        if(isset($this->_hlsAes)){
            $arr["hls_aes"] = $this->_hlsAes->toArray();
        }
        if(isset($this->_ncg)){
            $arr["ncg"] = $this->_ncg->toArray();
        }

        return $arr;
    }

    /**
     * @return MpegCencRequest
     */
    public function getMpegCencRequest()
    {
        return $this->_mpegCenc;
    }

    /**
     * @param MpegCencRequest $mpegCencRequest
     */
    public function setMpegCencRequest($mpegCencRequest)
    {
        $this->_mpegCenc = $mpegCencRequest;
    }

    /**
     * @return HlsAesRequest
     */
    public function getHlsAesRequest()
    {
        return $this->_hlsAes;
    }

    /**
     * @param HlsAesRequest $hlsAesRequest
     */
    public function setHlsAesRequest($hlsAesRequest)
    {
        $this->_hlsAes = $hlsAesRequest;
    }

    /**
     * @return NcgRequest
     */
    public function getNcgRequest()
    {
        return $this->_ncg;
    }

    /**
     * @param NcgRequest $ncgRequest
     */
    public function setNcgRequest($ncgRequest)
    {
        $this->_ncg = $ncgRequest;
    }

}