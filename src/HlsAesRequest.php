<?php
namespace PallyCon;

use PallyCon\Exception\PallyConTokenException;

class HlsAesRequest
{
    private $_key;
    private $_iv;
    /**
     * HlsAesRequest constructor.
     * @param $key
     * @param $iv
     * @throws PallyConTokenException
     */
    public function __construct($key, $iv)
    {
        if(preg_match('/[[:xdigit:]]{32}/', $key) && preg_match('/[[:xdigit:]]{32}/', $iv) ){
            $this->_key = $key;
            $this->_iv = $iv;
        }else{
            throw new PallyConTokenException(1006);
        }
    }

    public function toArray(){
        $arr= [];
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
