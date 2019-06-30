<?php

/**
 * Gère le chargement automatique des classes lorsqu'on les demande !
 */
spl_autoload_register(function ($className) {
    $realPath = 'libraries/classes/';
    $className = strtolower(str_replace('\\', '/', $className));
    require_once($realPath . $className . '.php');
});
