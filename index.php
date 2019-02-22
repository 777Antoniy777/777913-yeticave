<?php
// require("data.php");
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// проверка на подключение к БД и получение массива категорий
if (!$link) {
    // неуспешное выполнение запроса, показ ошибки
    $error = mysqli_connect_error();
    $error_content = include_template("error.php", [
        "error" => $error
    ]);
} else {
    // запрос на получение массива категорий
    $sql = "SELECT title_category, alias FROM categories";
    $result = mysqli_query($link, $sql);

    if ($result) {
        // успешное выполнение запроса
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // var_dump($categories);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($link);
        $error_content = include_template("error.php", [
            "error" => $error
        ]);
        // print($error_content);
    }

    // fetch_data($link, $sql, $categories);

    // запрос на получение массива товаров
    $sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url FROM categories c
                  JOIN lots l ON l.category_id = c.id LIMIT 9";
    // fetch_data($link, $sql);
    $result = mysqli_query($link, $sql);

    if ($result) {
        // успешное выполнение запроса
        $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // var_dump($goods);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($link);
        $error_content = include_template("error.php", [
            "error" => $error
        ]);
        // print($error_content);
    }

    // Защита от SQL-инъекций
    $search = trim($_GET["search"]) ?? "";

    if (!$search) {
        include_template("search.php", ["goods" => []]);
    } else {
        $search = "%" . $search . "%";

        // запрос на поиск гифок по имени или описанию
		$sql = "SELECT l.name, l.title_lot, l.start_price, l.url FROM categories c
                       JOIN lots l ON l.category_id = c.id
                       WHERE `title_lot` LIKE ? OR `description` LIKE ?";

        $get_stmt = db_get_prepare_stmt($link, $sql, $search, $search);
        mysqli_stmt_execute($get_stmt);

        if ($goods = mysqli_stmt_get_result($get_stmt)) {
            $goods = mysqli_fetch_all($goods, MYSQLI_ASSOC);
            // передаем в шаблон результат выполнения
            $content = include_template("search.php", ["goods" => $goods]);
        } else {
            $error = mysqli_error($connect);
            $content = include_template("error.php", [
                "error" => $error
            ]);
        }
    }
}

// index контент
$index_content = include_template("index.php", [
    "goods" => $goods,
    "categories" => $categories
]);

// layout контент
// if (!$link) {
//     $layout_content = include_template("layout.php", [
//         "content" => $error_content,
//         "page_name" => "YetiCave",
//         "is_auth" => $is_auth,
//         "user_name" => $user_name
//     ]);
// } else {
//     $layout_content = include_template("layout.php", [
//         "content" => $index_content,
//         "page_name" => "YetiCave",
//         "categories" => $categories,
//         "is_auth" => $is_auth,
//         "user_name" => $user_name
//     ]);
// }

$layout_content = include_template("layout.php", [
    "content" => $index_content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

// вывод страницы index.php
print($layout_content);


