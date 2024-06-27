<?php


class EEpisode{
    //attributes
    private   $episode_id;
    
    private  $episode_title;
    
    private  $episode_description;
    
    private DateTime $episode_creationtime;
    
    private  $episode_streams;

    private  $podcast_id;

    //mimetype attributes 
    private  $image_mimetype;

    private  $audio_mimetype;

    //bytecode attributes 
    private $image_data;

    private $audio_data;



    //constructor
   
    public function __construct( $episode_title,  $episode_description,  $podcast_id){
    
        $this->episode_title = $episode_title;
        $this->episode_description = $episode_description;
        $this->podcast_id = $podcast_id;     
        $this->setTime();
        $this->episode_streams = 0;
       
        
    }

    //methods
  
    /**
     * Get the value of episode_id
     * 
     * @return $episode_id
     */
    public function getId()   {
        return $this->episode_id;
    }
  
    /**
     * Get the value of episode_title
     * 
     * @return $episode_title
     */
    public function getEpisode_title()   {
        return $this->episode_title;
    }
    /**
     * Get the value of episode_description
     * 
     * @return $episode_description
     */
    public function getEpisode_description()   {
        return $this->episode_description;
    }
    /**
     * Get the value of episode_creationtime
     * 
     * @return $episode_creationtime
     */
    public function getEpisode_creationtime() {
        return $this->episode_creationtime;
    }
    /**
     * Get the value of episode_streams
     * 
     * @return $episode_streams
     */
    public function getEpisode_streams()  {
        return $this->episode_streams;
    }
       /**
     * Get the value of podcast_id
     * 
     * @return $podcast_id
     */
    public function getPodcastId()  {
        return $this->podcast_id;
    }
    /**
     * Set the value of episode_id
     * 
     * @return $episode_id
     */
    
    
    public function getTimetoStr()
    {
        return $this->episode_creationtime->format('Y-m-d H:i:s');
    }

    public function getEncodedImageData(){
        return base64_encode($this->image_data);
    }
    public function getEncodedAudioData(){
        return base64_encode($this->audio_data);
    }
    public function getImageMimeType()  {
        return $this->image_mimetype;
    }
    public function getAudioMimeType()  {
        return $this->audio_mimetype;
    }
    public function getAudioData() {
        return $this->audio_data;
    }
    public function getImageData() {
        return $this->image_data;
    
    }
    public function setEpisodeId($episode_id) {
        $this->episode_id = $episode_id;
    }
    /**
     * Set the value of episode_title
     * 
     * @return $episode_title
     */
    public function setEpisode_title( $episode_title) {
        $this->episode_title = $episode_title;

    }
    /**
     * Set the value of episode_description
     * 
     * @return $episode_description
     */
    public function setEpisode_description( $episode_description) {
        $this->episode_description= $episode_description;

    }
    /**
     * Set the value of episode_creationtime
     * 
     * @return $episode_creationtime
     */
    private function setTime() {
    
        $this->episode_creationtime = new DateTime("now");
    }
    public function setImageData( $image_data) {
        $this->image_data = $image_data;
    }
    public function setAudioData( $audio_data) {
        $this->audio_data = $audio_data;
    }
    public function setImageMimetype( $image_mimetype) {
        $this->image_mimetype = $image_mimetype;
    }
    public function setAudioMimetype( $audio_mimetype) {
        $this->audio_mimetype = $audio_mimetype;
    }
    public function setCreationTime($dateTime){
        $this->episode_creationtime = $dateTime;
    }
    public function setEpisodeStreams($episode_streams){
        $this->episode_streams = $episode_streams;
    }
    
    
    


}

