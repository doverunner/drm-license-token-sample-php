<?php
namespace PallyCon;
use PallyCon\ExternalKeyRequest;
use PallyCon\PlaybackPolicyRequest;
use PallyCon\SecurityPolicyRequest;
use PallyCon\PolicyRequest;
use PallyCon\Exception\PallyConTokenException;

class TokenBuilder
{
    private $_playbackPolicyRequest;
    private $_securityPolicyRequest;
    private $_externalKeyRequest;

    /**
     * @param mixed $playbackPolicyRequest
     * @return TokenBuilder
     */
    public function playbackPolicy(PlaybackPolicyRequest $playbackPolicyRequest){
        if(!empty($playbackPolicyRequest)){
            $this->_playbackPolicyRequest = $playbackPolicyRequest;
        }

        return $this;
    }

    /**
     * @param mixed $securityPolicyRequest
     * @return TokenBuilder
     */
    public function securityPolicy(SecurityPolicyRequest $securityPolicyRequest){
        if(!empty($securityPolicyRequest)) {
            $this->_securityPolicyRequest = $securityPolicyRequest;
        }
        return $this;
    }

    /**
     * @param mixed $externalKeyRequest
     * @return TokenBuilder
     */
    public function externalKey(ExternalKeyRequest $externalKeyRequest){
        if(!empty($externalKeyRequest)){
            $this->_externalKeyRequest = $externalKeyRequest;
        }

        return $this;
    }

    public function build()
    {
        try {
            $policyRequest = new PolicyRequest($this->_playbackPolicyRequest
                , $this->_securityPolicyRequest
                , $this->_externalKeyRequest);
            $this->checkValidation();
        }catch (PallyConTokenException $e){
            throw $e;
        }
        return $policyRequest;
    }

    /**
     * @throws PallyConTokenException
     */
    private function checkValidation()
    {
        if(!empty($this->_playbackPolicyRequest)){
            $playbackPolicy = $this->_playbackPolicyRequest;
            if((0 != $playbackPolicy->getDuration() || "" != $playbackPolicy->getExpireDate())
                && !$playbackPolicy->isLimit()){
                throw new PallyConTokenException(1010);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getPlaybackPolicyRequest()
    {
        return $this->_playbackPolicyRequest;
    }

    /**
     * @return mixed
     */
    public function getSecurityPolicyRequest()
    {
        return $this->_securityPolicyRequest;
    }


    /**
     * @return mixed
     */
    public function getExternalKeyRequest()
    {
        return $this->_externalKeyRequest;
    }

}