<?php

require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

$content = include_template("error.php", []);

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// запрос на получение массива товаров
$sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url, l.date_end FROM categories c
        JOIN lots l ON l.category_id = c.id LIMIT 9";

if ($goods = db_fetch_data($link, $sql)) {
    $goods = db_fetch_data($link, $sql);
}

if ($goods) {
    $content = include_template("index.php", [
        "goods" => $goods,
        "categories" => $categories
    ]);
}

if ($is_auth) {
    $layout_content = include_template("layout.php", [
        "content" => $content,
        "page_name" => "YetiCave",
        "categories" => $categories,
        "is_auth" => $is_auth,
        "username" => $username
    ]);
} else {
    $layout_content = include_template("layout.php", [
        "content" => $content,
        "page_name" => "YetiCave",
        "categories" => $categories,
        "is_auth" => $is_auth
    ]);
}

// вывод страницы index.php
print($layout_content);


