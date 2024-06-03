<?php


class EEpisode{
    //attributes
    private  int $episode_id;
    
    private string $episode_title;
    
    private string $episode_description;
    
    private DateTime $episode_creationtime;
    
    private int $episode_streams;

    private int $podcast_id;

    //mimetype attributes 
    private string $image_mimetype;

    private string $audio_mimetype;

    //bytecode attributes 
    private $image_data;

    private $audio_data;



    //constructor
   
    public function __construct(string $episode_title, string $episode_description, int $podcast_id){
    
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
    public function getEpisodeId() : int {
        return $this->episode_id;
    }
  
    /**
     * Get the value of episode_title
     * 
     * @return $episode_title
     */
    public function getEpisode_title() : string {
        return $this->episode_title;
    }
    /**
     * Get the value of episode_description
     * 
     * @return $episode_description
     */
    public function getEpisode_description() : string {
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
    public function getEpisode_streams() : int {
        return $this->episode_streams;
    }
       /**
     * Get the value of podcast_id
     * 
     * @return $podcast_id
     */
    public function getPodcastId() : int {
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
    public function getImageMimeType() : string {
        return $this->image_mimetype;
    }
    public function getAudioMimeType() : string {
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
    public function setEpisode_title(string $episode_title) {
        $this->episode_title = $episode_title;

    }
    /**
     * Set the value of episode_description
     * 
     * @return $episode_description
     */
    public function setEpisode_description(string $episode_description) {
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
    public function setImageData(string $image_data) {
        $this->image_data = $image_data;
    }
    public function setAudioData(string $audio_data) {
        $this->audio_data = $audio_data;
    }
    public function setImageMimetype(string $image_mimetype) {
        $this->image_mimetype = $image_mimetype;
    }
    public function setAudioMimetype(string $audio_mimetype) {
        $this->audio_mimetype = $audio_mimetype;
    }
    public function setCreationTime($dateTime){
        $this->episode_creationtime = $dateTime;
    }
    
    


}

