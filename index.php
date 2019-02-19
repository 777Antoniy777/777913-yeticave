<?php
require("data.php");
require("functions.php");
require("config.php");

//
// работа с MySQL из php
$link = mysql_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$con = mysqli_real_connect($link, "localhost", "root", "", "yeticave");

// проверка на подключение к БД
if (!$con) {
    print("Нет связи с сервером " . mysqli_connect_error());
} else {
    print("Все работает");
}

// установка кодировки utf-8
mysqli_set_charset($con, "utf8");

// получение данных из БД
// массив категорий
$get_categories = "SELECT name, alias FROM categories";
$result = mysqli_query($con, $get_categories);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// массив товаров
$get_goods = "SELECT name, alias FROM categories";
mysqli_query($con, $get_categories);

//
// index контент
$index_content = include_template("index.php", [
    "goods" => $goods,
    "categories" => $categories
]);

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


