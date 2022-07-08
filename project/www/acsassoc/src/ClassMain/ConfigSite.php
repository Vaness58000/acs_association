<?php

namespace App\ClassMain;

class ConfigSite
{
    
    private $email;
    private $name;
    private $nb_jour;

    public function __construct()
    {

        $this->email = 'acs@association.fr';
        $this->name = 'AcsAssociation';
        $this->nb_jour = '2';
        
        if(file_exists(dirname(__FILE__) . '/../../config/config.ini')) {
            $file_config = dirname(__FILE__) . '/../../config/config.ini';
            $init = parse_ini_file($file_config, true);
            if(array_key_exists("main", $init)) {
                if(array_key_exists("email", $init["main"])) {
                    $this->email = $init["main"]["email"];
                }
                if(array_key_exists("name", $init["main"])) {
                    $this->name = $init["main"]["name"];
                }
                if(array_key_exists("nb_jour", $init["main"])) {
                    $this->nb_jour = $init["main"]["nb_jour"];
                }
            }
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

    /**
     * Get the value of nb_jour
     */ 
    public function getNb_jour()
    {
        return $this->nb_jour;
    }
}