<?php

    return

    array(
        "base_url" => "http://localhost/sociales/hybridauth.php",
        "providers" => array(
            "Twitter" => array(
                "enabled" => true,
                "keys" => array(
                    "key" => "",
                    "secret" => ""
                ),
                "includeEmail" => true
            ),
            "Facebook" => array(
                "enabled" => true,
                "keys" => array(
                    "key" => "",
                    "secret" => ""
                ),
                "scope" => "email"    
            )
            
        ),

    )


?>