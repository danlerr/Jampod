<?php

class EPodcast{

    //attributes 

    /**
    * @var int|null $podcast_id The ID of the podcast. Auto-incremented by the database.
    */
    private  $podcast_id;

    private  $podcast_name;

    private  $podcast_description;

    private  $category;

    private  $user_id;

    private  $subcribe_counter;

    private  $image_mimetype;

    private $image_data;

    private  $podcast_creationtime;

    //constructor

    public function __construct($podcast_name, $podcast_description, $user_id, $category)
    {
        $this->podcast_name = $podcast_name;
        $this->podcast_description = $podcast_description;
        $this->user_id = $user_id;
        $this->category = $category;
        $this->subcribe_counter = 0;
        $this->image_mimetype = "";
        $this->setTime();
    }

    //methods
    
    /**
     * Get the value of podcast_id
     *
     * @return $podcast_id
     */
    public function getId()
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

    public function getPodcastCategory(){
        return $this->category;
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
     * Get the value of podcast_creation_date
     *
     * @return $podcast_creation_date
     */
    public function getCreationDate()
    {
        return $this->podcast_creationtime;
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

    public function setPodcastCategory($podcast_category){
        $this->category = $podcast_category;
    }

    /**
     * Set the value of podcast_creation_date
     *
     * @param 
     */
    public function setTime()
    {
        $this->podcast_creationtime = new DateTime("now");
    }

    public function getEncodedImageData()
    {
        return base64_encode($this->image_data);
    }
    public function getImageMimeType() : string 
    {
        return $this->image_mimetype;
    }
    
    public function getImageData() 
    {
        return $this->image_data;
    }

    public function setImageData($image_data) {
        $this->image_data = $image_data;
    }
    
    public function setImageMimetype( $image_mimetype) {
        $this->image_mimetype = $image_mimetype;
    }
    
    public function setCreationTime($dateTime){
        $this->podcast_creationtime = $dateTime;
    }
    public function setSubcribe_counter($subcribe_counter){
        $this->subcribe_counter = $subcribe_counter;
    }
    public function getTimetoStr()
    {
        return $this->podcast_creationtime->format('Y-m-d H:i:s');
    }
}
