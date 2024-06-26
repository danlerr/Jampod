<?php
class ESubscribe {

   
    //attributes
    
    private  $subscribe_id;
    private  $podcast_id;
    
    private  $subscriber_id;

    
    //constructor
    public function __construct( $podcast_id,  $subscriber_id) {
        $this->podcast_id = $podcast_id;
        $this->subscriber_id = $subscriber_id;
    }
    //Methods

     /**
     * Get the value of subscribe_id
     * 
     * @return $subscribe_id
     */
    public function getId()  {
        return $this->subscribe_id;
    }
    /**
     * Get the value of podcast_id
     * 
     * @return $podcast_id
     */
    public function getPodcastid() {
        return $this->podcast_id;
    }
    /**
     * Get the value of subscriber_id
     * 
     * @return $subscriber_id
     */
    public function getSubscriberid() {
        return $this->subscriber_id;
    }
    
    /**
     * Set the value of $subscribe_id
     * 
     * @return $subscribe_id
     */
    public function setSubscribeid($subscribe_id) {
        $this->subscribe_id = $subscribe_id;
    }
    

}