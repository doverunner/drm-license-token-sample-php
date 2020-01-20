<?php


namespace PallyCon;


use PallyCon\Exception\PallyConTokenException;

class OutputProtectRequest
{
    public $_allowExternalDisplay;
    public $_controlHdcp;

    public function __construct($allowExternalDisplay=false, $controlHdcp=0)
    {
        if(!empty($allowExternalDisplay)){
            if(is_bool($allowExternalDisplay)){
                $this->_allowExternalDisplay = $allowExternalDisplay;
            }else{
                throw new PallyConTokenException(1015);
            }
        }

        if(!empty($controlHdcp)){
            if(is_int($controlHdcp)){
                $this->_controlHdcp = $controlHdcp;
            }else{
                throw new PallyConTokenException(1016);
            }
        }

    }

    public function toArray(){
        $arr= [];
        if(isset($this->_allowExternalDisplay)){
            $arr["allow_external_display"] = $this->_allowExternalDisplay;
        }
        if(isset($this->_controlHdcp)){
            $arr["control_hdcp"] = $this->_controlHdcp;
        }

        return $arr;
    }

    /**
     * @return bool
     */
    public function isAllowExternalDisplay()
    {
        return $this->_allowExternalDisplay;
    }

    /**
     * @param bool $allowExternalDisplay
     */
    public function setAllowExternalDisplay($allowExternalDisplay)
    {
        $this->_allowExternalDisplay = $allowExternalDisplay;
    }

    /**
     * @return int
     */
    public function getControlHdcp()
    {
        return $this->_controlHdcp;
    }

    /**
     * @param int $controlHdcp
     */
    public function setControlHdcp($controlHdcp)
    {
        $this->_controlHdcp = $controlHdcp;
    }



}