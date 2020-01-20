<?php


namespace PallyCon;


use PallyCon\Exception\PallyConTokenException;
use PallyCon\OutputProtectRequest;

class SecurityPolicyRequest
{
    public $_hardwareDrm;
    public $_outputProtect;
    public $_allowMobileAbnormalDevice;
    public $_playreadySecurityLevel;

    public function __construct($hardwareDrm=false, OutputProtectRequest $outputProtectRequest=null
                                    , $allowMobileAbnormalDevice=false, $playreadySecurityLevel=0)
    {
        if(!empty($hardwareDrm)){
            if(is_bool($hardwareDrm) ){
                $this->_hardwareDrm = $hardwareDrm;
            }else{
                throw new PallyConTokenException(1015);
                throw new PallyConTokenException("The hardwareDrm must be boolean.", 1003);
            }
        }
        if(!empty($hardwareDrm)) {
            if (!empty($outputProtectRequest)) {
                $this->_outputProtect = $outputProtectRequest;
            }
        }
        if(!empty($allowMobileAbnormalDevice)) {
            if (is_bool($allowMobileAbnormalDevice)) {
                $this->_allowMobileAbnormalDevice = $allowMobileAbnormalDevice;
            } else {
                throw new PallyConTokenException(1016);
            }
        }
        if(!empty($playreadySecurityLevel)) {
            if (is_int($playreadySecurityLevel)) {
                $this->_playreadySecurityLevel = $playreadySecurityLevel;
            } else {
                throw new PallyConTokenException(1017);
            }
        }
    }

    public function toArray(){
        $arr= [];
        if(isset($this->_hardwareDrm)){
            $arr["hardware_drm"] = $this->_hardwareDrm;
        }
        if(isset($this->_outputProtect)){
            $arr["output_protect"] = $this->_outputProtect->toArray();
        }
        if(isset($this->_allowMobileAbnormalDevice)){
            $arr["allow_mobile_abnormal_device"] = $this->_allowMobileAbnormalDevice;
        }
        if(isset($this->_playreadySecurityLevel)){
            $arr["playready_security_level"] = $this->_playreadySecurityLevel;
        }
        return $arr;
    }

    /**
     * @return mixed
     */
    public function getHardwareDrm()
    {
        return $this->_hardwareDrm;
    }

    /**
     * @param mixed $hardwareDrm
     */
    public function setHardwareDrm($hardwareDrm)
    {
        $this->_hardwareDrm = $hardwareDrm;
    }

    /**
     * @return mixed
     */
    public function getOutputProtect()
    {
        return $this->_outputProtect;
    }

    /**
     * @param mixed $outputProtect
     */
    public function setOutputProtect($outputProtect)
    {
        $this->_outputProtect = $outputProtect;
    }

    /**
     * @return mixed
     */
    public function getAllowMobileAbnormalDevice()
    {
        return $this->_allowMobileAbnormalDevice;
    }

    /**
     * @param mixed $allowMobileAbnormalDevice
     */
    public function setAllowMobileAbnormalDevice($allowMobileAbnormalDevice)
    {
        $this->_allowMobileAbnormalDevice = $allowMobileAbnormalDevice;
    }

    /**
     * @return mixed
     */
    public function getPlayreadySecurityLevel()
    {
        return $this->_playreadySecurityLevel;
    }

    /**
     * @param mixed $playreadySecurityLevel
     */
    public function setPlayreadySecurityLevel($playreadySecurityLevel)
    {
        $this->_playreadySecurityLevel = $playreadySecurityLevel;
    }


}