<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';
// commented out because newer version of symphony projs will alwasy return to TRUE
// if (method_exists(Dotenv::class, 'bootEnv')) {
//     (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
// }
(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

