<?php

//Gérer le protocole http: redirections, session, récup de param en GET ou POST
class Http{

    /**
     * Redirige le visiteur vers $url
     * 
     * @param string $url
     * @return void  // return vide
     */
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }


}




?>