<?php
include "../vendor/autoload.php";

$larvatar = new \Renfordt\Larvatar\Larvatar();
echo $larvatar->GenerateLarvatar(['Jannik', 'Renfordt']);