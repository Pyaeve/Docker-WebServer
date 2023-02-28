<?php

    class Auth{

        protected static $allow = ['Facebook','Twitter','Google'];

        protected static function issetRequest(){

            if(isset($_GET['login'])){

                if(in_array($_GET['login'], self::$allow)){

                    return true;

                }

            }
            
            return false;

        }

        protected static function getUserAuth(){

            if(self::issetRequest()){

                $service = $_GET['login'];

                $hybridAuth = new Hybrid_Auth(__DIR__.'\config.php');

                $adapter = $hyridauth->authenticate($service);

                $userProfile = $adapter->getUserProfile();

                var_dump($userProfile);

                die(); 

            }

        }

    }

?>