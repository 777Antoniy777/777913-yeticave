<?php
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// запрос на получение массива категорий
$sql = "SELECT id, title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// обработка данных из формы и показ страницы с новым лотом по данным этой формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $required = ["lot-name", "category", "message", "lot-rate", "lot-step", "lot-date"];
    $dict = [
        "lot-name" => "Наименование",
        "category" => "Категория",
        "message" => "Описание",
        "good_img" => "Изображение",
        "lot-rate" => "Начальная цена",
        "lot-step" => "Шаг ставки",
        "lot-date" => "Дата окончания торгов"
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Заполните это поле";
        }
    }

    // проверяем существует ли файл изображения товара и если есть, то перемещаем его из временной папки
    if (!empty($_FILES["good_img"]["name"])) {
        $tmp_name = $_FILES["good_img"]["tmp_name"];
        $filepath = __DIR__ . "/";

        $finfo = finfo_open(FILEINFO_MIME_TYPE);       //открываем соединение file_info
        $file_type = finfo_file($finfo, $tmp_name);    //получаем тип файла

        if ($file_type === "image/png" || $file_type === "image/jpeg") {

            if ($file_type === "image/jpeg") {
                $filename = "img/" . uniqid() . ".jpeg";
            }

            if ($file_type === "image/png") {
                $filename = "img/" . uniqid() . ".png";
            }

            move_uploaded_file($tmp_name, $filepath . $filename);
            $_POST["good_img"] = $filename;
        } else {
            $errors["good_img"] = "Загрузите картинку в формате JPG или PNG";
        }
    } else {
        $errors["good_img"] = "Вы не загрузили файл";
    }

    // проверяем меньше 0 или нет вводимая цена и является ли число целым
    if (!empty($_POST["lot-rate"])) {

        if ($_POST["lot-rate"] <= 0) {
            $errors["lot-rate"] = "Число должно быть больше 0!";
        }

        if (check_price_format($_POST["lot-rate"])) {
            $errors["lot-rate"] = "Число должно быть целым";
        }
    }

    // проверяем меньше 0 или нет вводимая ставка и является ли число целым
    if (!empty($_POST["lot-step"])) {

        if ($_POST["lot-step"] <= 0) {
            $errors["lot-step"] = "Число должно быть больше 0!";
        }

        if (check_price_format($_POST["lot-step"])) {
            $errors["lot-step"] = "Число должно быть целым";
        }
    }

    // проверяем формат даты календаря
    if (!empty($_POST["lot-date"])) {
        if (!check_date_format($_POST["lot-date"])) {
            $errors["lot-date"] = "Введите дату в формате ДД.ММ.ГГГГ";
        }

        $time_nextday = strtotime("+1 day");    // следующий день
        $time_interval = strtotime($_POST["lot-date"]);

        if ($time_interval < $time_nextday) {
            $errors["lot-date"] = "Минимальное время публикации лота не должно быть меньше, чем 1 день. Установите другую дату";
        }
    }

    if (count($errors)) {
        $content = include_template('add.php', [
            "categories" => $categories,
            "$_POST" => $_POST,
            "errors" => $errors,
            "dict" => $dict
        ]);
    } else {
        $sql = "INSERT INTO lots (category_id, title_lot, description, date_end, url, start_price, step, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)";

        $date = date_create($_POST["lot-date"]);

        $id = db_insert_data($link, $sql, [
            $_POST["category"],
            $_POST["lot-name"],
            $_POST["message"],
            date_format($date, 'Y-m-d'),
            $_POST["good_img"],
            $_POST["lot-rate"],
            $_POST["lot-step"]
        ]);

        header("Location: lot.php?id=" . $id);
    }
} else {
    $content = include_template('add.php', [
        "categories" => $categories
    ]);
}

if (isset($_SESSION["user"])) {
    $layout_content = include_template("layout.php", [
        "content" => $content,
        "page_name" => "YetiCave",
        "categories" => $categories
    ]);
} else {
    $content = include_template("error.php", [
        "error" => $error
    ]);

    $layout_content = include_template("layout.php", [
        "content" => $content,
        "page_name" => "YetiCave",
        "categories" => $categories
    ]);
}

// вывод страницы index.php
print($layout_content);
