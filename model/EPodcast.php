<?php

class EPodcast{

    //attributes 

    /**
    * @var int|null $podcast_id The ID of the podcast. Auto-incremented by the database.
    */
    private int $podcast_id;

    private string $podcast_name;

    private string $podcast_description;

    private string $category_id;

    private int $user_id;

    private int $subcribe_counter;

    private string $image_mimetype;

    private $image_data;

    private DateTime $podcast_creationtime;

    //constructor

    public function __construct($podcast_name, $podcast_description, $user_id, $category_id)
    {
        $this->podcast_name = $podcast_name;
        $this->podcast_description = $podcast_description;
        $this->user_id = $user_id;
        $this->category_id = $category_id;
        $this->subcribe_counter = 0;
        $this->image_mimetype = "image/jpeg";
        $this->image_data = "";
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

    public function getPodcastCategory(){
        return $this->category_id;
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
        $this->category_id = $podcast_category;
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

    public function setImageData(string $image_data) {
        $this->image_data = $image_data;
    }
    
    public function setImageMimetype(string $image_mimetype) {
        $this->image_mimetype = $image_mimetype;
    }
    
    public function setCreationTime($dateTime){
        $this->podcast_creationtime = $dateTime;
    }

}
