<?php

class Http
{
    /**
     * Redirige le visiteur vers $uri
     *
     * @param string $uri
     *
     * @return void
     */
    public static function redirect(string $uri): void
    {
        header("Location: $uri");
        exit();
    }
}
