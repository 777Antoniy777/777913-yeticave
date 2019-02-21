<?php
// установка соединения
$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connect = mysqli_real_connect($link, "localhost", "root", "", "yeticave");

// установка кодировки utf-8
mysqli_set_charset($connect, "utf8");
