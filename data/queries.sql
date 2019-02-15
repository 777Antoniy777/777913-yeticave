-- запросы
-- запрос на получение всех категорий
SELECT name FROM category;

-- запрос на получение самых новых, открытых лотов
SELECT name, start_price, url, step, date_create FROM category
ORDER BY date_create DESC;

-- запрос на получение лота по его id и его название категории
SELECT name, c.name, l.start_price, l.url, l.step, l.date_create FROM category c WHERE l.id = 1
JOIN lots l ON l.category_id = c.id

-- запрос на обновление названия лота по его id
UPDATE lots SET name = "2018 Rossignol District Snowboard" WHERE id = 1;

-- запрос на получение списка самых свежих ставок для лота по его идентификатору
SELECT b.id, l.price FROM bets b
JOIN lots l ON b.lot_id = l.id
ORDER BY price DESC;
