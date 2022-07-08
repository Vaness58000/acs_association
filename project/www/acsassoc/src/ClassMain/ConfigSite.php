<?php

namespace App\ClassMain;

class ConfigSite
{
    
    private $email;
    private $name;

    public function __construct()
    {

        $this->email = 'acs@association.fr';
        $this->name = 'AcsAssociation';
        
        if(file_exists(dirname(__FILE__) . '/../../config/config.ini')) {
            $file_config = dirname(__FILE__) . '/../../config/config.ini';
            $init = parse_ini_file($file_config, true);
            $this->email = $init["main"]["email"];
            $this->name = $init["main"]["name"];
        }
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}