<?php
// проверка идет ли сейчас сессия или нет и подстановка имени зарегистрированного пользователя
$is_auth = !empty($_SESSION["user"]);

if ($is_auth) {
    $username = $_SESSION["user"]["name"];
}

// Таймзона моего города и местная локаль
date_default_timezone_set("Asia/Omsk");
setlocale(LC_ALL, "ru_RU");
