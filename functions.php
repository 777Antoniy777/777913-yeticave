<?php
/**
 *  функция шаблонизатор
 *  @param {string} $name - имя шаблона,
 *  @param {array} $data - массив данных
 *  @return {string} - html-код с подставленными данными из масива
 */
function include_template ($name, $data) {
    $name = 'templates/' . $name;

    if (!is_readable($name)) {
        return null;
    }

    ob_start();
    extract($data);
    require $name;

    return ob_get_clean();
};

/**
 *  функция для форматирования цены
 *  @param {integer} $price - изначальная цена
 *  @return {string} - отформатированная цена
 */
function format_price ($price) {
    ceil($price); // округляем значение до целого

    return number_format($price, 0, ".", " ") . "&#x20bd;"; // ф-ция форматирует число по заданным арг.
};

/**
 *  функция для показа оставшегося времени до начала следующего дня (полночь)
 *
 *  @param $date_end - дата окончания выставления лота
 *
 *  @return {string} - установленное время
 */
function get_time ($date_end) {
    $time_now = strtotime("now");       // время сейчас
    $time_end = strtotime($date_end);   // время окончания выставления лота
    $time_interval = $time_end - $time_now;

    $hours = floor(($time_interval / 3600));
    $minutes = floor(($time_interval % 3600) / 60);

    if ($time_end < $time_now) {
        return "00" . ":" . "00"; // вывод времени если срок лота истек
    } else {
        return $hours . ":" . $minutes; // вывод времени до окончания выставления лота
    }
};

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt ($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
};

/**
 * проверяет успешно ли было соединение или нет. если нет, то добавляет шаблон об ошибке
 *
 * @param $link - соединение к БД
 * @param $sql - запрос из БД для получения данных
 * @param $data {array} - запрос из БД для получения данных
 *
 * @return {array} - двумерный массив с нужными данными
 */
function db_fetch_data ($link, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);

    if ($res = mysqli_stmt_get_result($stmt)) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($link);
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
    }
}

/**
 * добавление новой записи в БД
 *
 * @param $link - соединение к БД
 * @param $sql - запрос из БД для получения данных
 * @param $data {array} - запрос для внесения данных в БД
 *
 * @return {int} - начение поля AUTO_INCREMENT, которое было затронуто предыдущим запросом
 */
function db_insert_data ($link, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($link, $sql, $data);

    if ($result = mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($link);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($link);
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
    }
}

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 *
 * @param string $date - строка с датой
 *
 * @return bool
 */
function check_date_format ($date) {
    $regexp = '/^\s*(3[01]|[12][0-9]|0?[1-9])\.(1[012]|0?[1-9])\.((?:19|20)\d{2})\s*$/';

    if (preg_match($regexp, $date, $parts) && count($parts) === 4) {
        // return checkdate($parts[2], $parts[1], $parts[3]);
        return true;
    }

    return false;
}

/**
 * Проверяет, что переданная цена и ставка являются целыми числами
 *
 * @param string $data - данные из массива $_POST
 *
 * @return bool
 */
function check_price_format ($data) {
    $regexp = '/[0-9]+[.,]/m';

    if (preg_match($regexp, $data)) {
        return true;
    }

    return false;
}

/**
 * Открывает блок со ставками и нет
 *
 * @param string $auth - данные из массива $_SESSION
 *
 * @return bool
 */
function show_bets ($auth) {
    if ($auth) {
        return true;
    }

    return false;
}
