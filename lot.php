<?php
require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

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

    if ($is_auth && $_SERVER["REQUEST_METHOD"] === "POST") {

        $required = ["cost"];
        $dict = [
            "cost" => "Текущая цена"
        ];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = "Заполните это поле";
            }
        }

        // проверяем меньше 0 или нет вводимая цена и является ли число целым
        if (!empty($_POST["cost"])) {

            if ($_POST["cost"] <= 0) {
                $errors["cost"] = "Число должно быть больше 0!";
            }

            if (check_price_format($_POST["cost"])) {
                $errors["cost"] = "Число должно быть целым";
            }

            $total_price = $goods[0]["start_price"] + $goods[0]["step"];

            if ($_POST["cost"] < $total_price) {
                $errors["cost"] = "Сумма ставки должна быть больше, чем" . $total_price;
            }
        }

        if (count($errors)) {
            $content = include_template('lot.php', [
                "categories" => $categories,
                "$_POST" => $_POST,
                "errors" => $errors,
                "dict" => $dict
            ]);
        } else {
            $sql = "INSERT INTO bets (price, user_id, lot_id) VALUES (?, ?, ?)";

            $lot_id = db_insert_data($link, $sql, [
                $_POST["cost"],
                $_SESSION["user"]["id"],
                $id
            ]);

            header("Location: lot.php?id=" . $id);
        }
    } else {
        $content = include_template('lot.php', [
            "goods" => $goods,
            "categories" => $categories
        ]);
    }
}

$layout_content = include_template("layout.php", [
    "content" => $content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_auth" => $is_auth,
    "username" => $username
]);

print($layout_content);
