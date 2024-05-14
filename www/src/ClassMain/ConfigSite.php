<?php

namespace App\ClassMain;

class ConfigSite
{
    
    private $email;
    private $name;
    private $nb_jour;
    private $nb_prod;
    private $nb_row;

    public function __construct()
    {

        $this->email = 'acs@association.fr';
        $this->name = 'AcsAssociation';
        $this->nb_jour = 2;
        $this->nb_prod = 6;
        $this->nb_row = 10;
        
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
                    $this->nb_jour = (int)$init["main"]["nb_jour"];
                }
                if(array_key_exists("nb_prod", $init["main"])) {
                    $this->nb_prod = (int)$init["main"]["nb_prod"];
                }
                if(array_key_exists("nb_row", $init["main"])) {
                    $this->nb_row = (int)$init["main"]["nb_row"];
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

    /**
     * Get the value of nb_prod
     */ 
    public function getNb_prod()
    {
        return $this->nb_prod;
    }

    /**
     * Get the value of nb_row
     */ 
    public function getNb_row()
    {
        return $this->nb_row;
    }
}