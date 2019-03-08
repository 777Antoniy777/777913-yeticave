<?php
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// удаляем данные сессии, если пользователь вышел из своего аккаунта
if (isset($_SESSION["user"])) {
    session_unset($_SESSION["user"]);
    header("Location: index.php");
}
