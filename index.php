<?php 
require("data.php");
require("functions.php");

// index контент
$index_content = include_template("index.php", 
    ["goods" => $goods, 
    "categories" => $categories]);

// layout контент
$layout_content = include_template("layout.php", 
    ["content" => $index_content, 
    "page_name" => "YetiCave", 
    "categories" => $categories, 
    "is_auth" => $is_auth, 
    "user_name" => $user_name]);

// вывод страницы index.php 
print($layout_content);


