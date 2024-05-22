<?php
class ESubscribe {

   
    //attributes
    
    private int $subscribe_id;
    private int $podcast_id;
    
    private int $subscriber_id;

    
    //constructor
    public function __construct(int $podcast_id, int $subscriber_id) {
        $this->podcast_id = $podcast_id;
        $this->subscriber_id = $subscriber_id;
    }
    //Methods

     /**
     * Get the value of subscribe_id
     * 
     * @return $subscribe_id
     */
    public function getSubscribeid() : int {
        return $this->subscribe_id;
    }
    /**
     * Get the value of podcast_id
     * 
     * @return $podcast_id
     */
    public function getPodcastid() : int {
        return $this->podcast_id;
    }
    /**
     * Get the value of subscriber_id
     * 
     * @return $subscriber_id
     */
    public function getSubscriberid() : int{
        return $this->subscriber_id;
    }
    
    /**
     * Set the value of $subscribe_id
     * 
     * @return $subscribe_id
     */
    public function setSubscribeid($subscribe_id) {
        $this->podcast_id = $subscribe_id;
    }
    

}