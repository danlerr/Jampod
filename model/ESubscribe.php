<?php
class ESubscribe {
    //attributi
    private $podcast_id;

    private $subscriber_id;
    //constructor
    public function __construct($podcast_id, $subscriber_id) {
        $this->podcast_id = $podcast_id;
        $this->subscriber_id = $subscriber_id;
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
    public function getFollowerid() {
        return $this->subscriber_id;
    }
    /**
     * Set the value of subscriber_id
     * 
     * @return $subscriber_id
     */
    public function setFollowerid($subscriber_id) {
        $this->subscriber_id = $subscriber_id;
    }
    /**
     * Set the value of $podcast_id
     * 
     * @return $$podcast_id
     */
    public function setPodcastid($podcast_id) {
        $this->podcast_id = $podcast_id;
    }

}