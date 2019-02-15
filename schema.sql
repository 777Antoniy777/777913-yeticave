-- удаление БД, если она уже была ранее создана
DROP DATABASE IF EXISTS yeticave;
-- создание БД
CREATE DATABASE yeticave;

-- создание таблицы Категории
CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(100) UNIQUE NOT NULL,
  alias CHAR(50) NOT NULL
);

-- создание таблицы Лоты
CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  user_id INT,
  name CHAR(150) NOT NULL,
  description CHAR(255),
  date_create TIMESTAMP,
  date_end TIMESTAMP,
  url CHAR(50) NOT NULL,
  start_price INT NOT NULL,
  step INT NOT NULL
);

-- создание таблицы Пользователи
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(50) NOT NULL,
  email CHAR(50) NOT NULL UNIQUE,
  password CHAR(50) NOT NULL,
  avatar CHAR(20),
  date_registry DATETIME,
  contacts CHAR(70)
);

-- создание таблицы Ставки
CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lot_id INT,
  date_start TIMESTAMP,
  price INT NOT NULL
);
