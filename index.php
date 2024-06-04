<?php

use Source\Models\User;

require __DIR__ . "/vendor/autoload.php";

$userCreate = false;
/**
 * CREATE USER
 */
if ($userCreate) {
  $user = new User();
  $user->first_name = "Matheus";
  $user->last_name = "Zancanela";
  $user->email = "matheus@teste.com.br";
  $user->password = password_hash("12345", PASSWORD_DEFAULT);

  if ($user->save()) {
    echo "<h2>Usuario cadastrado: {$user->id}</h2>";
  } else {
    echo "<h2>{$user->fail()->getMessage()}</h2>";
  }
}

/**
 * LOAD USER
 */
echo "<h1>User:</h1>";
$user = (new User())->findById(26);
var_dump($user->data());

/**
 * LOGIN EXEMPLO
 */
echo "<h1>Login:</h1>";
$email = "matheus@teste.com.br";
$passwd = "12345";
$login = (new User())->find("email = :e", "e={$email}")->fetch();

if (!$login || !password_verify($passwd, $login->password)) {
  echo "<h2>Login ou senha incorreto!</h2>";
} else {
  echo "<h2>Login efetuado!</h2>";
  var_dump($login->data());
}

/**
 * TEST HASH
 */
echo "<h1>INFO AND IF REHASH</h1>";
var_dump(
  password_get_info($user->password),
  password_needs_rehash($user->password, PASSWORD_DEFAULT),
  password_needs_rehash($user->password, PASSWORD_DEFAULT, ["cost" => 8])
);

$user->password = password_hash($passwd, PASSWORD_DEFAULT);
$user->save();
