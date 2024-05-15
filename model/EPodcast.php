<?php

class EPodcast{

    //attributes 

    private $podcast_id;

    private $podcast_name;

    private $podcast_description;

    private $user;

    private $subcribe_counter;

    //private $episodes;

    private DateTime $podcast_creation_date;

    //constructor

    public function __construct($podcast_name, $podcast_description, $user)
    {
        $this->podcast_name = $podcast_name;
        $this->podcast_description = $podcast_description;
        $this->user = $user;
        $this->subcribe_counter = 0;
        //$this->episodes = array();
        $this->setTime();
    }

    //methods
    
    /**
     * Get the value of podcast_id
     *
     * @return $podcast_id
     */
    public function getPodcastId()
    {
        return $this->podcast_id;
    }

    //setPodcastId(..)? Autoincrement?

    /**
     * Get the value of podcast_name
     *
     * @return $podcast_name
     */
    public function getPodcastName()
    {
        return $this->podcast_name;
    }

    /**
     * Set the value of podcast_name
     *
     * @param $podcast_name
     */
    public function setPodcastName($podcast_name)
    {
        $this->podcast_name = $podcast_name;
    }

    /**
     * Get the value of podcast_description
     *
     * @return $podcast_description
     */
    public function getPodcastDescription()
    {
        return $this->podcast_description;
    }
    
    /**
     * Set the value of podcast_description
     *
     * @param $podcast_description
     */
    public function setPodcastDescription($podcast_description)
    {
        $this->podcast_name = $podcast_description;
    }
    /**
     * Get the value of podcast_creation_date
     *
     * @return $podcast_creation_date
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of podcast_creation_date
     *
     * @return $podcast_creation_date
     */
    public function getTime()
    {
        return $this->podcast_creation_date;
    }

    /**
     * Set the value of podcast_creation_date
     *
     * @param 
     */
    public function setTime()
    {
        $this->podcast_creation_date = new DateTime("now");
    }

    /**
     * Get the value of subcribe_counter
     *
     * @return $subcribe_counter
     */
    public function getSubscribeCounter()
    {
        return $this->subcribe_counter;
    }

    //setSubCounter? funzione che incrementa? addEpisode? getEpisode?


    //altri get e set da vedere con le relazioni 

}

?>