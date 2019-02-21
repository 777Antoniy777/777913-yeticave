<?php
require("data.php");
require_once("functions.php");
require("config.php");

// работа с MySQL из php
require_once("init.php");

// проверка на подключение к БД и получение массива категорий
if (!$connect) {
    // неуспешное выполнение запроса, показ ошибки
    $error = mysqli_connect_error();
    $error_content = include_template("error.php", [
        "categories" => $categories,
        "error" => $error
    ]);
} else {
    // запрос на получение массива категорий
    $get_categories = "SELECT name, alias FROM categories";
    $result_categories = mysqli_query($connect, $get_categories);

    if ($result_categories) {
        // успешное выполнение запроса
        $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($connect);
        $error_content = include_template("error.php", [
            "categories" => $categories,
            "error" => $error
        ]);
    }

    // запрос на получение массива товаров
    $get_goods = "SELECT l.name, c.name, l.start_price, l.url FROM categories c
                  JOIN lots l ON l.category_id = c.id LIMIT 9";
    $result_goods = mysqli_query($connect, $get_goods);

    if ($result_goods) {
        // успешное выполнение запроса
        $goods = mysqli_fetch_all($result_goods, MYSQLI_ASSOC);

        // index контент
        $index_content = include_template("index.php", [
            "goods" => $goods,
            "categories" => $categories
        ]);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($connect);
        $error_content = include_template("error.php", [
            "categories" => $categories,
            "error" => $error
        ]);
    }

    // Защита от SQL-инъекций
    $search = trim($_GET["q"]) ?? "";

    if (!strlen($search)) {
        include_template("search.php", [$goods => []]);
    } else {
        $search = "%" . $search . "%";

        // запрос на поиск гифок по имени или описанию
		$get_search = "SELECT l.name, c.name, l.start_price, l.url FROM categories c
                       JOIN lots l ON l.category_id = c.id
                       WHERE `title` LIKE ? OR `description` LIKE ?";

        $get_stmt = db_get_prepare_stmt($connect, $get_search, $search);
        mysqli_stmt_execute($get_stmt);

        if ($goods = mysqli_stmt_get_result($get_stmt)) {
            $goods = mysqli_fetch_all($goods, MYSQLI_ASSOC);
            // передаем в шаблон результат выполнения
            $content = include_template("search.php", ["goods" => $goods]);
        } else {
            $error = mysqli_error($connect);
            $content = include_template("error.php", [
                "categories" => $categories,
                "error" => $error
            ]);
        }
    }
}

// // массив товаров
// $get_goods = "SELECT l.name, c.name, l.start_price, l.url FROM categories c
//               JOIN lots l ON l.category_id = c.id";
// mysqli_query($connect, $get_goods);

//
// index контент
// $index_content = include_template("index.php", [
//     "goods" => $goods,
//     "categories" => $categories
// ]);

// layout контент
$layout_content = include_template("layout.php", [
    "content" => $index_content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

// вывод страницы index.php
print($layout_content);


