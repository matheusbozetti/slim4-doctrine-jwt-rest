<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
