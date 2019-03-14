<?php
require_once("functions.php");

// работа с MySQL из php и открытие сессии
require_once("init.php");

// авторизация пользователей и установка timezone
require_once("config.php");

// запрос на получение массива категорий
$sql = "SELECT id, title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// обработка данных из формы и показ страницы с новым лотом по данным этой формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required = ["email", "password", "name", "message"];
    $dict = [
        "email" => "E-mail",
        "password" => "Пароль",
        "name" => "Имя",
        "message" => "Контактные данные",
        "avatar" => "Аватар"
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Заполните это поле";
        }
    }

    // проверяем валиден ли email и есть ли похожий в БД
    if (!empty($_POST["email"])) {

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Введите корректный email";
        }

        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $errors["email"] = "Пользователь с этим email уже зарегистрирован";
        }
    }

    // проверяем существует ли файл изображения товара и если есть, то перемещаем его из временной папки
    if (!empty($_FILES["avatar"]["name"])) {
        $tmp_name = $_FILES["avatar"]["tmp_name"];
        $filepath = __DIR__ . "/";

        $file_type = mime_content_type($tmp_name);

        if ($file_type === "image/png" || $file_type === "image/jpeg") {

            if ($file_type === "image/jpeg") {
                $filename = "img/" . uniqid() . ".jpeg";
            }

            if ($file_type === "image/png") {
                $filename = "img/" . uniqid() . ".png";
            }

            move_uploaded_file($tmp_name, $filepath . $filename);
            $_POST["avatar"] = $filename;
        } else {
            $errors["avatar"] = "Загрузите картинку в формате JPG или PNG";
        }
    }

    if (count($errors)) {
        $content = include_template("sign.php", [
            "categories" => $categories,
            "errors" => $errors,
            "dict" => $dict
        ]);
    } else if (!empty($_POST["avatar"])) {
        $sql = "INSERT INTO users (name, email, password, contacts, avatar)
                VALUES (?, ?, ?, ?, ?)";

        db_insert_data($link, $sql, [
            $_POST["name"],
            $_POST["email"],
            password_hash($_POST["password"], PASSWORD_DEFAULT),
            $_POST["message"],
            $_POST["avatar"]
        ]);

        header("Location: login.php");
        exit();
    } else {
        $sql = "INSERT INTO users (name, email, password, contacts)
                VALUES (?, ?, ?, ?)";

        db_insert_data($link, $sql, [
            $_POST["name"],
            $_POST["email"],
            password_hash($_POST["password"], PASSWORD_DEFAULT),
            $_POST["message"]
        ]);

        header("Location: login.php");
        exit();
    }
} else {
    $content = include_template("sign.php", [
        "categories" => $categories,
        "errors" => $errors
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

// вывод страницы index.php
print($layout_content);

