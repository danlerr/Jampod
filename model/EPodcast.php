<?php

class EPodcast{

    //attributes 

    /**
    * @var int|null $podcast_id The ID of the podcast. Auto-incremented by the database.
    */
    private int $podcast_id;

    private string $podcast_name;

    private string $podcast_description;

    private int $user_id;

    private int $subcribe_counter;
    /** 
    /** @var EEpisode[] /*
    private $episodes; */

    private DateTime $podcast_creation_date;

    //constructor

    public function __construct($podcast_name, $podcast_description, $user_id)
    {
        $this->podcast_id =null;  //inizializza id_podcast come nullo
        $this->podcast_name = $podcast_name;
        $this->podcast_description = $podcast_description;
        $this->user_id = $user_id;
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
     * Get the value of podcast_description
     *
     * @return $podcast_description
     */
    public function getPodcastDescription()
    {
        return $this->podcast_description;
    }

    /**
     * Get the value of user_id
     *
     * @return $user_id
     */
    public function getUserId()
    {
        return $this->user_id;
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

    /**
     * Get the list of episodes
     *
     * @return $episodes
     */
    /**public function getEpisodes()
    {
        return $this->episodes;
    }*/
    
    /**
     * Get the value of podcast_creation_date
     *
     * @return $podcast_creation_date
     */
    public function getCreationDate()
    {
        return $this->podcast_creation_date;
    }

    /**
     * Set the value of podcast_id
     *
     * @param $podcast_id
     */
    public function setPodcastId($podcast_id)
    {
        $this->podcast_id = $podcast_id;
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
     * Set the value of podcast_description
     *
     * @param $podcast_description
     */
    public function setPodcastDescription($podcast_description)
    {
        $this->podcast_description = $podcast_description;
    }

    //setSubCounter ??

    /**
     * Set the value of podcast_creation_date
     *
     * @param 
     */
    public function setTime()
    {
        $this->podcast_creation_date = new DateTime("now");
    }

}
