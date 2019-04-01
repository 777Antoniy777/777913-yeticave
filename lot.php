<?php
require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// запрос на получение массива ставок
// $sql = "SELECT b.price, b.date_start, b.id, u.name FROM bets b
//         JOIN users u ON b.user_id = u.id
//         ORDER BY b.date_start DESC
//         WHERE b.lot_id = ?";

// $bets = db_fetch_data($link, $sql, [$lot_id]);

if (isset($_GET["id"])) {
    $lot_id = $_GET["id"];

    // запрос на получение массива ставок
    $sql = "SELECT b.price, b.date_start, b.id, u.name FROM bets b
    JOIN users u ON b.user_id = u.id
    WHERE b.lot_id = ?
    ORDER BY b.date_start DESC";

    $bets = db_fetch_data($link, $sql, [$lot_id]);

    // запрос на получение массива товаров
    $sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url, l.description, l.step, l.date_end FROM categories c
            JOIN lots l ON l.category_id = c.id
            WHERE l.id = ?";

    $goods = db_fetch_data($link, $sql, [$lot_id]);

    // проверка на правильность цены
    if (!empty($bets)) {
        $total_price = $goods[0]["start_price"] + $bets[0]["price"];
    } else {
        $total_price = $goods[0]["start_price"];
    }

    // проверка на правильность минимальной ставки
    if (!empty($bets)) {
        $min_step = $goods[0]["start_price"] + $bets[0]["price"] + $goods[0]["step"];
    } else {
        $min_step = $goods[0]["start_price"] + $goods[0]["step"];
    }

    $content = include_template("lot.php", [
        "goods" => $goods,
        "categories" => $categories,
        "bets" => $bets,
        "is_auth" => $is_auth,
        "total_price" => $total_price,
        "min_step" => $min_step
    ]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lot_id = $_POST["lot_id"];

    // запрос на получение массива ставок
    $sql = "SELECT b.price, b.date_start, b.id, u.name FROM bets b
    JOIN users u ON b.user_id = u.id
    WHERE b.lot_id = ?
    ORDER BY b.date_start DESC";

    $bets = db_fetch_data($link, $sql, [$_POST["lot_id"]]);

    // запрос на получение массива товаров
    $sql = "SELECT l.title_lot, c.title_category, l.start_price, l.url, l.description, l.step, l.date_end FROM categories c
            JOIN lots l ON l.category_id = c.id
            WHERE l.id = ?";

    $goods = db_fetch_data($link, $sql, [$lot_id]);

    $required = ["cost"];
    $dict = [
        "cost" => "Ваша ставка"
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
            $errors["cost"] = "Сумма ставки должна быть больше, чем " . $total_price . "&#x20bd;";
        }
    }
    if (count($errors)) {

        $content = include_template('lot.php', [
            "categories" => $categories,
            "goods" => $goods,
            "bets" => $bets,
            "is_auth" => $is_auth,
            "total_price" => $total_price,
            "min_step" => $min_step,
            "errors" => $errors,
            "dict" => $dict,
            "lot_id" => $_POST["lot_id"]
        ]);

    } else {
        $sql = "INSERT INTO bets (price, user_id, lot_id) VALUES (?, ?, ?)";

        $bet_id = db_insert_data($link, $sql, [
            $_POST["cost"],
            $_SESSION["user"]["id"],
            $lot_id
        ]);

        header("Location: lot.php?id=" . $lot_id);

    }
} else {
    $content = include_template('lot.php', [
        "goods" => $goods,
        "categories" => $categories,
        "bets" => $bets,
        "lot_id" => $lot_id,
        "is_auth" => $is_auth,
        "total_price" => $total_price,
        "min_step" => $min_step
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


print($layout_content);
