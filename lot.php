<?php
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // запрос на получение массива товаров
    $sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url, l.description, l.step, l.date_end FROM categories c
            JOIN lots l ON l.category_id = c.id
            WHERE l.id = ?";

    $goods = db_fetch_data($link, $sql, [$id]);

    $content = include_template("lot.php", [
        "goods" => $goods,
        "categories" => $categories
    ]);
}

$layout_content = include_template("layout.php", [
    "content" => $content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_session" => $is_session,
    "username" => $username
]);

print($layout_content);
