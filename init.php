<?php
// установка соединения
$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connect = mysqli_real_connect($link, "localhost", "root", "", "yeticave");

// открываем начало сессии
session_start();

// проверка на подключение к БД и получение массива категорий
if (!$link) {
    // неуспешное выполнение запроса, показ ошибки
    $error = mysqli_connect_error();
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

    // вывод страницы index.php при отсутствии данных
    print($layout_content);
    exit;
} else {
    // установка кодировки utf-8
    mysqli_set_charset($link, "utf8");
}
