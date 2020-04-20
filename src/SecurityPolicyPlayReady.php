<?php

namespace PallyCon;


use PallyCon\Exception\PallyConTokenException;

class SecurityPolicyPlayReady
{
    public $_securityLevel;
    public $_digitalVideoProtectionLevel;
    public $_analogVideoProtectionLevel;
    public $_compressedDigitalAudioProtectionLevel;
    public $_uncompressedDigitalAudioProtectionLevel;
    public $_requireHdcpType1;


    public function __construct($securityLevel=150
                                    , $digitalVideoProtectionLevel=null
                                    , $analogVideoProtectionLevel=null
                                    , $compressedDigitalAudioProtectionLevel=null
                                    , $uncompressedDigitalAudioProtectionLevel=null
                                    , $requireHdcpType1= null)
    {
        if(is_numeric($securityLevel)){
            $this->_securityLevel = $securityLevel;
        }else{
            throw new PallyConTokenException(1102);
        }
        if(!empty($digitalVideoProtectionLevel)) {
            if (is_numeric($digitalVideoProtectionLevel)) {
                $this->_digitalVideoProtectionLevel = $digitalVideoProtectionLevel;
            } else {
                throw new PallyConTokenException(1103);
            }
        }
        if(!empty($analogVideoProtectionLevel)) {
            if (is_numeric($analogVideoProtectionLevel)) {
                $this->_analogVideoProtectionLevel = $analogVideoProtectionLevel;
            } else {
                throw new PallyConTokenException(1104);
            }
        }
        if(!empty($compressedDigitalAudioProtectionLevel)) {
            if (is_numeric($compressedDigitalAudioProtectionLevel)) {
                $this->_compressedDigitalAudioProtectionLevel = $compressedDigitalAudioProtectionLevel;
            } else {
                throw new PallyConTokenException(1105);
            }
        }
        if(!empty($uncompressedDigitalAudioProtectionLevel)) {
            if (is_numeric($uncompressedDigitalAudioProtectionLevel)) {
                $this->_uncompressedDigitalAudioProtectionLevel = $uncompressedDigitalAudioProtectionLevel;
            } else {
                throw new PallyConTokenException(1106);
            }
        }
        if(!empty($requireHdcpType1)) {
            if (is_bool($requireHdcpType1)) {
                $this->_requireHdcpType1 = $requireHdcpType1;
            } else {
                throw new PallyConTokenException(1107);
            }
        }
    }

    public function toArray()
    {
        $arr = [];
        if (isset($this->_securityLevel)) {
            $arr["security_level"] = $this->_securityLevel;
        }
        if (isset($this->_digitalVideoProtectionLevel)) {
            $arr["digital_video_protection_level"] = $this->_digitalVideoProtectionLevel;
        }
        if (isset($this->_analogVideoProtectionLevel)) {
            $arr["analog_video_protection_level"] = $this->_analogVideoProtectionLevel;
        }
        if (isset($this->_compressedDigitalAudioProtectionLevel)) {
            $arr["compressed_digital_audio_protection_level"] = $this->_compressedDigitalAudioProtectionLevel;
        }
        if (isset($this->_uncompressedDigitalAudioProtectionLevel)) {
            $arr["uncompressed_digital_audio_protection_level"] = $this->_uncompressedDigitalAudioProtectionLevel;
        }
        if (isset($this->_requireHdcpType1)) {
            $arr["require_hdcp_type1"] = $this->_requireHdcpType1;
        }

        return $arr;
    }

    /**
     * @return int|string
     */
    public function getSecurityLevel()
    {
        return $this->_securityLevel;
    }

    /**
     * @param int|string $securityLevel
     */
    public function setSecurityLevel($securityLevel)
    {
        $this->_securityLevel = $securityLevel;
    }

    /**
     * @return int|string
     */
    public function getDigitalVideoProtectionLevel()
    {
        return $this->_digitalVideoProtectionLevel;
    }

    /**
     * @param int|string $digitalVideoProtectionLevel
     */
    public function setDigitalVideoProtectionLevel($digitalVideoProtectionLevel)
    {
        $this->_digitalVideoProtectionLevel = $digitalVideoProtectionLevel;
    }

    /**
     * @return int|string
     */
    public function getAnalogVideoProtectionLevel()
    {
        return $this->_analogVideoProtectionLevel;
    }

    /**
     * @param int|string $analogVideoProtectionLevel
     */
    public function setAnalogVideoProtectionLevel($analogVideoProtectionLevel)
    {
        $this->_analogVideoProtectionLevel = $analogVideoProtectionLevel;
    }

    /**
     * @return int|string
     */
    public function getCompressedDigitalAudioProtectionLevel()
    {
        return $this->_compressedDigitalAudioProtectionLevel;
    }

    /**
     * @param int|string $compressedDigitalAudioProtectionLevel
     */
    public function setCompressedDigitalAudioProtectionLevel($compressedDigitalAudioProtectionLevel)
    {
        $this->_compressedDigitalAudioProtectionLevel = $compressedDigitalAudioProtectionLevel;
    }

    /**
     * @return int|string
     */
    public function getUncompressedDigitalAudioProtectionLevel()
    {
        return $this->_uncompressedDigitalAudioProtectionLevel;
    }

    /**
     * @param int|string $uncompressedDigitalAudioProtectionLevel
     */
    public function setUncompressedDigitalAudioProtectionLevel($uncompressedDigitalAudioProtectionLevel)
    {
        $this->_uncompressedDigitalAudioProtectionLevel = $uncompressedDigitalAudioProtectionLevel;
    }

    /**
     * @return bool
     */
    public function isRequireHdcpType1()
    {
        return $this->_requireHdcpType1;
    }

    /**
     * @param bool $requireHdcpType1
     */
    public function setRequireHdcpType1($requireHdcpType1)
    {
        $this->_requireHdcpType1 = $requireHdcpType1;
    }
}
