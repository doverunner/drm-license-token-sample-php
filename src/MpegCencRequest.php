<?php
namespace PallyCon;

use PallyCon\Exception\PallyConTokenException;

class MpegCencRequest
{
    public $_keyId;
    public $_key;
    public $_iv = null;

    function __construct($keyId, $key, $iv=null)
    {
        if(preg_match('/[[:xdigit:]]{32}/', $keyId) && preg_match('/[[:xdigit:]]{32}/', $key) ){
            $this->_keyId = $keyId;
            $this->_key = $key;
        }else{
            throw new PallyConTokenException(1007);
        }

        if( !empty($iv) ){
            if(preg_match('/[[:xdigit:]]{32}/', $iv)){
                $this->_iv = $iv;
            }else{
                throw new PallyConTokenException(1008);
            }
        }

    }
    public function toArray(){
        $arr= [];
        if(isset($this->_keyId)){
            $arr["key_id"] = $this->_keyId;
        }
        if(isset($this->_key)){
            $arr["key"] = $this->_key;
        }
        if(isset($this->_iv)){
            $arr["iv"] = $this->_iv;
        }
        return $arr;
    }

    /**
     * @return mixed
     */
    public function getKeyId()
    {
        return $this->_keyId;
    }

    /**
     * @param mixed $keyId
     */
    public function setKeyId($keyId)
    {
        $this->_keyId = $keyId;
    }


    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return mixed
     */
    public function getIv()
    {
        return $this->_iv;
    }

    /**
     * @param mixed $iv
     */
    public function setIv($iv)
    {
        $this->_iv = $iv;
    }
    

}