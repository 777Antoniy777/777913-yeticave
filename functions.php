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
 *  @return {string} - установленное время
 */
function get_time () {
    $time_now = strtotime("now"); // время сейчас
    $time_midnight = strtotime("tomorrow midnight"); // время начала следующего дня (полночь)
    $time_interval = $time_midnight - $time_now;

    $hours = floor($time_interval / 3600);
    $minutes = floor(($time_interval % 3600) / 60);

    return $hours . ":" . $minutes; // вывод оставшегося времени до начала следующего дня (полночь)
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

function fetch_data ($con, $query, $data) {
    $result = mysqli_query($con, $query);

    if ($result) {
        // успешное выполнение запроса
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // неуспешное выполнение запроса, показ ошибки
        $error = mysqli_error($con);
        $error_content = include_template("error.php", [
            "error" => $error
        ]);
        // print($error_content);
    }
};
