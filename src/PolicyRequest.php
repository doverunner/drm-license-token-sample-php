<?php

namespace PallyCon;


class PolicyRequest
{
    public $_playbackPolicy;
    public $_securityPolicy;
    public $_externalKey;

    public function __construct(PlaybackPolicyRequest $playbackPolicyRequest=null
                                    , SecurityPolicyRequest $securityPolicyRequest=null
                                    , ExternalKeyRequest $externalKeyRequest=null)
    {
        if(!empty($playbackPolicyRequest)) {
            $this->_playbackPolicy =$playbackPolicyRequest ;
        }
        if(!empty($securityPolicyRequest)) {
            $this->_securityPolicy = $securityPolicyRequest;
        }
        if(!empty($externalKeyRequest)) {
            $this->_externalKey = $externalKeyRequest;
        }
    }

    public function toArray(){
        $arr= [];
        if(isset($this->_playbackPolicy)){
            $arr["playback_policy"] = $this->_playbackPolicy->toArray();
        }
        if(isset($this->_securityPolicy)){
            $arr["security_policy"] = $this->_securityPolicy->toArray();
        }
        if(isset($this->_externalKey)){
            $arr["external_key"] = $this->_externalKey->toArray();
        }

        return $arr;
    }

    public function toJsonString(){
        return json_encode($this->toArray());
    }

    /**
     * @return PlaybackPolicyRequest
     */
    public function getPlaybackPolicy()
    {
        return $this->_playbackPolicy;
    }

    /**
     * @param $playbackPolicyRequest
     */
    public function setPlaybackPolicy(PlaybackPolicyRequest $playbackPolicyRequest)
    {
        $this->_playbackPolicy = get_object_vars($playbackPolicyRequest);
    }

    /**
     * @return SecurityPolicyRequest
     */
    public function getSecurityPolicy()
    {
        return $this->_securityPolicy;
    }

    /**
     * @param $securityPolicyRequest
     */
    public function setSecurityPolicy(SecurityPolicyRequest $securityPolicyRequest)
    {
        $this->_securityPolicy = get_object_vars($securityPolicyRequest);
    }

    /**
     * @return ExternalKeyRequest
     */
    public function getExternalKey()
    {
        return $this->_externalKey;
    }

    /**
     * @param $externalKeyRequest
     */
    public function setExternalKey(ExternalKeyRequest $externalKeyRequest)
    {
        $this->_externalKey = get_object_vars($externalKeyRequest);
    }





}