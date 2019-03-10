<?php
require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

// удаляем данные сессии, если пользователь вышел из своего аккаунта
if ($is_auth) {
    session_unset($_SESSION["user"]);
    header("Location: index.php");
}
