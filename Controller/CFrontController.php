<?php
/**
 * Class that calls the controllers and methods written in the URL
 
 */
class CFrontController{
    
    /**
     * This function is responsible for managing the path and calling the corresponding controller and method
     * @param string $path
     */
    public function run($url){
        $result = explode("/", $url);       
        
        array_shift($result);           // vengono rimossi i 
        array_shift($result);          // primi due elementi della url 

        if($result[0]=="" || $result[0]=="index.php"){
            
            CHome::homePage();
            return;
        }

        $controller = "C" . $result[0];
        $directory = "Controller";
        $scanDir = scandir($directory);

        if(in_array($controller . ".php", $scanDir)){

            if(isset($result[1])){

                $method = $result[1];

                if(method_exists($controller, $method)){
                        
                        $params = array_slice($result, 2); // Get optional parameters
                        call_user_func_array([$controller, $method], $params);      

                }else{
                    /**
                     * If the method does not exist, the 404 page is displayed
                     */
                    $view = new VHome();
                    $view->show404();
                }
            }
            
        }else{
            /**
             * If the controller does not exist, the 404 page is displayed
             */
            $view = new VHome();
            $view->show404();
        }
    }
}



    