<?php

namespace PallyCon;


use PallyCon\Exception\PallyConTokenException;

class PlaybackPolicyRequest {
    public $_limit;
    public $_persistent;
    public $_duration;
    public $_expireDate;

    public function __construct($limit=false, $persistent=false, $duration=0, $expireDate= "")
    {
        if(!empty($limit)) {
            if(is_bool($limit)){
                $this->_limit = $limit;
            }else{
                throw new PallyConTokenException(1011);
            }
        }else{
            $this->_limit = $limit;
        }

        if(!empty($persistent)) {
            if(is_bool($persistent)){
                $this->_persistent = $persistent;
            }else{
                throw new PallyConTokenException(1012);
            }
        }
        if(!empty($duration)) {
            if(is_int($duration)){
                $this->_duration = $duration;
            }else{
                throw new PallyConTokenException(1013);
            }
        }
        if(!empty($expireDate)) {
            if(preg_match('/[0-9]{4}-[0,1][0-9]-[0-5][0-9]T[0-2][0-3]:[0-5][0-9]:[0-5][0-9]Z/', $expireDate)){
                $this->_expireDate = $expireDate;
            }else{
                throw new PallyConTokenException(1014);
            }
        }
    }

    public function toArray(){
        $arr= [];
        if(isset($this->_limit)){
            $arr["limit"] = $this->_limit;
        }
        if(isset($this->_persistent)){
            $arr["persistent"] = $this->_persistent;
        }
        if(isset($this->_duration)){
            $arr["duration"] = $this->_duration;
        }
        if(isset($this->_expireDate)){
            $arr["expire_date"] = $this->_expireDate;
        }
        return $arr;
    }

    /**
     * @return bool
     */
    public function isLimit()
    {
        return $this->_limit;
    }

    /**
     * @param bool $limit
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * @return bool
     */
    public function isPersistent()
    {
        return $this->_persistent;
    }

    /**
     * @param bool $persistent
     */
    public function setPersistent($persistent)
    {
        $this->_persistent = $persistent;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->_duration = $duration;
    }

    /**
     * @return string
     */
    public function getExpireDate()
    {
        return $this->_expireDate;
    }

    /**
     * @param string $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->_expireDate = $expireDate;
    }



}
?>