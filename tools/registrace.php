<?php

include __DIR__ . "/../vendor/nette/security/src/Security/Passwords.php";



$db = new PDO('mysql:host=localhost;dbname=byyou;charset=utf8', 'root', '');
$name = "lol";//Sem napište jméno uživatele
$pswd = "ahoj";//Sem napište heslo uživatele

$hash = array( 0 => '$2y$05$tadytotomusibyt22znaku', 'cost' => "05", 1=>"05", 'salt' => "tadytotomusibyt22znakudlouhe", 2 => "tadytotomusibyt22znakudlouhe");

$pswd = \Nette\Security\Passwords::hash($pswd, $hash);

$sql = "INSERT INTO byyou.users (username, password) VALUES (:name,:password)";
$q = $db->prepare($sql);
$q->execute(array(':name'=>$name,':password'=>$pswd));

