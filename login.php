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
    $required = ["email", "password"];
    $dict = [
        "email" => "E-mail",
        "password" => "Пароль"
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = "Заполните это поле";
        }
    }

    // проверяем пароль по хэшу, который ранее был внесен при регистрации
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_assoc($res) : null;

    if (!empty($_POST["password"]) && $user) {

        if (password_verify($_POST["password"], $user["password"])) {
            $_SESSION["user"] = $user;
        } else {
            $errors["password"] = "Неверный пароль";
        }

    }

    // проверяем валиден ли email и есть ли похожий в БД
    if (!empty($_POST["email"])) {

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Введите корректный email";
        }

        else if (!empty($_POST["email"]) && !$user) {
            $errors["email"] = "Такой пользователь не найден";
        }
    }

    if (count($errors)) {
        $content = include_template("login.php", [
            "categories" => $categories,
            "errors" => $errors,
            "dict" => $dict
        ]);
    } else {
        header("Location: index.php");
    }

} else {
    $content = include_template("login.php", [
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
