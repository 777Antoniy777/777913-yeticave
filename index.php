<?php
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// запрос на получение массива товаров
$sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url, l.date_end FROM categories c
        JOIN lots l ON l.category_id = c.id LIMIT 9";
$goods = db_fetch_data($link, $sql);

// Защита от SQL-инъекций
$search = trim($_GET["search"]) ?? "";

if (!$search) {
    include_template("search.php", ["goods" => []]);
} else {
    $search = "%" . $search . "%";

    // запрос на поиск гифок по имени или описанию
    $sql = "SELECT c.title_category, l.title_lot, l.start_price, l.url FROM categories c
            JOIN lots l ON l.category_id = c.id
            WHERE `title_lot` LIKE ? OR `description` LIKE ?";

    $get_stmt = db_get_prepare_stmt($link, $sql, [$search, $search]);
    mysqli_stmt_execute($get_stmt);

    if ($goods = mysqli_stmt_get_result($get_stmt)) {
        $goods = mysqli_fetch_all($goods, MYSQLI_ASSOC);
        // передаем в шаблон результат выполнения
        $content = include_template("search.php", [
            "goods" => $goods,
            "search" => $search
        ]);

        $layout_content = include_template("layout.php", [
            "content" => $content,
            "page_name" => "YetiCave",
            "categories" => $categories,
            "is_auth" => $is_auth,
            "user_name" => $user_name
        ]);

        print($layout_content);
        exit;

    } else {
        $error = mysqli_error($connect);
        $content = include_template("error.php", [
            "error" => $error
        ]);

        $layout_content = include_template("layout.php", [
            "content" => $content,
            "page_name" => "YetiCave",
            "categories" => $categories,
            "is_auth" => $is_auth,
            "user_name" => $user_name
        ]);

        print($layout_content);
        exit;
    }
}

// index контент
$content = include_template("index.php", [
    "goods" => $goods,
    "categories" => $categories
]);

$layout_content = include_template("layout.php", [
    "content" => $content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

// вывод страницы index.php
print($layout_content);


