<?php
class ECategory{

    //attributes 

    private $category_name;

    private static $allowed_category = [];

    public function __construct($category_name)
    {
        $this->category_name = $category_name;
    }

    //methods

    /**
     * Get the value of category_name
     *
     * @return $category_name
     */

    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * Set the value of category_name
     *
     * @param $category_name
     */

    public function setCategoryName($category_name)
    {   
        if (in_array($category_name, self::$allowed_category))
        {
            $this->category_name = $category_name;
        }
        else 
        {
            throw new Exception("Invalid Category");
        }
        
    }
 
}

















