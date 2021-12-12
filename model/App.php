<?php 
namespace model;

use model\Auth\Environment;

/**THIS IS THE SUPER CLASS FOR ALL CLASSES WITHIN THE APP 
 * - All classes extend this class directly or indirectly 
 * */
class App{
    public $Error;
    public $Success;

    public function __construct()
    {
        (new Environment())->load();//load environment variables from .env file
    }

}