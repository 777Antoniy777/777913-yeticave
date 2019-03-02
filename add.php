<?php
require_once("functions.php");
require_once("config.php");

// работа с MySQL из php
require_once("init.php");

// запрос на получение массива категорий
$sql = "SELECT title_category, alias FROM categories";
$categories = db_fetch_data($link, $sql);

// обработка данных из формы и показ страницы с новым лотом по данным этой формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lot = $_POST;

    $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $dict = [
        "lot-name" => "Наименование",
        "category" => "Категория",
        "message" => "Описание",
        "good_img" => "Изображение",
        "lot-rate" => "Начальная цена",
        "lot-step" => "Шаг ставки",
        "lot-date" => "Дата окончания торгов",
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
        $filepath = __DIR__ . "/img/";

        $finfo = finfo_open(FILEINFO_MIME_TYPE);       //открываем соединение file_info
        $file_type = finfo_file($finfo, $tmp_name);    //получаем тип файла

        if ($file_type == "image/png" || $file_type == "image/jpeg") {

            if ($file_type === "image/jpeg") {
                $filename = uniqid() . ".jpeg";
            }

            if ($file_type === "image/png") {
                $filename = uniqid() . ".png";
            }

            move_uploaded_file($tmp_name, $filepath . $filename);
            $lot["good_img"] = $filename;
        } else {
            $errors["good_img"] = "Загрузите картинку в формате JPG или PNG";
        }
    } else {
        $errors["good_img"] = "Вы не загрузили файл";
    }

    if (count($errors)) {
		$content = include_template('add.php', [
            "categories" => $categories,
            "lot" => $lot,
            "errors" => $errors,
            "dict" => $dict
        ]);
	} else {
		$content = include_template('lot.php', [
            'lot' => $lot,
            "categories" => $categories
        ]);

        $sql = "INSERT INTO lots (category_id, title_lot, description, date_end, url, start_price, step, date_create, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 1)";

        $data = db_insert_data($link, $sql, [
            $lot["category"],
            $lot["lot-name"],
            $lot["message"],
            $lot["lot-date"],
            $lot["good_img"],
            $lot["lot-rate"],
            $lot["lot-step"]
        ],

            "Location: lot.php?id="
        );
	}
} else {
	$content = include_template('add.php', [
        "categories" => $categories
    ]);
}

$layout_content = include_template("layout.php", [
    "content" => $content,
    "page_name" => "YetiCave",
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

// вывод страницы index.php
print($layout_content);
