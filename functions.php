<?php

/**
 *  функция шаблонизатор
 *  @param {string} $name - имя шаблона,
 *  @param {array} $data - массив данных
 *  @return {string} - html-код с подставленными данными из масива
 */
function include_template ($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
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
function set_time () {
    $time_now = strtotime("now"); // время сейчас
    $time_midnight = strtotime("tomorrow midnight"); // время начала следующего дня (полночь)
    $time_interval = $time_midnight - $time_now;

    $hours = floor($time_interval / 3600);
    $minutes = floor(($time_interval % 3600) / 60); 

    return $hours . ":" . $minutes; // вывод оставшегося времени до начала следующего дня (полночь)
};