-- удаление БД, если она уже была ранее создана
DROP DATABASE [IF EXISTS] yeticave;
-- создание БД
CREATE DATABASE yeticave;

-- создание таблицы Категории
CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(100) UNIQUE NOT NULL,
  alias CHAR(50) NOT NULL
);

INSERT INTO categories (name) VALUES ("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное");

-- создание таблицы Лоты
CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  user_id INT,
  name CHAR(150) NOT NULL,
  description CHAR(255),
  date_finish TIMESTAMP,
  url CHAR(50) NOT NULL,
  price INT NOT NULL,
  step INT NOT NULL
);

INSERT INTO lots (category_id, name, description, date, url, price, step)
VALUES
  (1, "2014 Rossignol District Snowboard", "2014 Rossignol District Snowboard", "...", "...", 10999, 1000),
  (2, "2014 Rossignol District Snowboard", "2014 Rossignol District Snowboard", "...", "...", 10999, 1000);

-- создание таблицы Пользователи
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(50) NOT NULL,
  email CHAR(50) NOT NULL UNIQUE,
  password CHAR(50) NOT NULL,
  avatar CHAR(20),
  date DATETIME NOT NULL,
  contacts CHAR(50)
);

-- создание таблицы Ставки
CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lot_id INT,
  date TIMESTAMP NOT NULL,
  price INT NOT NULL
);
