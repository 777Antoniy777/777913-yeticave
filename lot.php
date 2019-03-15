<?php
require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// запрос на проверку актуального id товара
$sql = "SELECT id FROM lots WHERE id = ?";
$good = db_fetch_data($link, $sql, [$_GET["id"]]);

if (isset($_GET["id"]) && $good) {
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

    // отображение цены товара из данных БД
    $total_price = $goods[0]["start_price"];

    // проверка на правильность минимальной ставки
    if (!empty($bets)) {
        $min_step = $bets[0]["price"] + $goods[0]["step"];
    } else {
        $min_step = $goods[0]["start_price"] + $goods[0]["step"];
    }
    if ($is_auth) {
        // проверка на отсутствие блока ставок для пользователей, которые зашли в свой собственный лот
        $sql = "SELECT l.id, l.user_id FROM users u
                JOIN lots l ON l.user_id = u.id
                WHERE l.id = ? AND u.id = ?";

        $lot = db_fetch_data($link, $sql, [$lot_id, $_SESSION["user"]["id"]]);

        // проверка на то, что уже была сделана ставка для лота
        $sql = "SELECT l.id, u.id, b.id FROM users u
                JOIN bets b ON u.id = b.user_id
                JOIN lots l ON l.id = b.lot_id
                WHERE l.id = ? AND u.id = ?";

        $bet = db_fetch_data($link, $sql, [$lot_id, $_SESSION["user"]["id"]]);

        $content = include_template("lot.php", [
            "goods" => $goods,
            "categories" => $categories,
            "bets" => $bets,
            "is_auth" => $is_auth,
            "total_price" => $total_price,
            "min_step" => $min_step,
            "lot" => $lot,
            "bet" => $bet
        ]);
    }
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

    // проверяем поле ставки на ошибки
    if (!empty($_POST["cost"])) {

        // проверяем меньше 0 или нет вводимая цена и является ли число целым
        if ($_POST["cost"] <= 0) {
            $errors["cost"] = "Число должно быть больше 0!";
        }

        // проверяем целое число или нет
        if (check_price_format($_POST["cost"])) {
            $errors["cost"] = "Число должно быть целым";
        }

        // проверяем меньше ли введенное значение минимального значения ставки
        if ($_POST["cost"] >= $min_step) {
            $total_price = $_POST["cost"];

        } else {
            $total_price = $goods[0]["start_price"];
            $errors["cost"] = "Сумма ставки должна быть больше, чем " . $min_step . "&#x20bd;";
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
            "lot_id" => $_POST["lot_id"],
            "lot" => $lot,
            "bet" => $bet
        ]);

    } else {
        // обновление стартовой цены твоара, если была сделана ставка (обновление на гл.стр и на стр.товара)
        $sql = "UPDATE lots SET start_price = '$total_price' WHERE id = ?";
        $start_price = db_insert_data($link, $sql, [$lot_id]);

        $sql = "INSERT INTO bets (price, user_id, lot_id) VALUES (?, ?, ?)";

        $bet_id = db_insert_data($link, $sql, [
            $_POST["cost"],
            $_SESSION["user"]["id"],
            $lot_id
        ]);

        header("Location: lot.php?id=" . $lot_id);
    }
} else {
    if ($is_auth && $good) {

        $content = include_template('lot.php', [
            "goods" => $goods,
            "categories" => $categories,
            "bets" => $bets,
            "lot_id" => $lot_id,
            "is_auth" => $is_auth,
            "total_price" => $total_price,
            "min_step" => $min_step,
            "lot" => $lot,
            "bet" => $bet
        ]);

    } else if (!$is_auth && $good) {

        $content = include_template('lot.php', [
            "goods" => $goods,
            "categories" => $categories,
            "bets" => $bets,
            "lot_id" => $lot_id,
            "is_auth" => $is_auth,
            "total_price" => $total_price,
            "min_step" => $min_step
        ]);

    } else {
        $content = include_template("error.php", []);
    }
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

// !!!!!!!
// Уважаемый наставник, пожалуйста высылайте ссылки на скрины с ошибками, большинство того что вы мне написали у меня отсутствует((
// к сожалению со своим наставником ваши замечания я обговорить не могу, поэтому прошу вас не считать данный комментарий ошибкой, просто по другому я не могу к вам обратиться((
// !!!!!!!
