<main>
    <nav class="nav">
        <ul class="nav__list container">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $alias => $category): ?>

                <li class="promo__item promo__item--<?= $alias; ?>">
                    <a class="promo__link" href="index.php?category=<?= $alias; ?>"><?= $category; ?></a>
                </li>

            <?php endforeach; ?>
        </ul>
        </nav>
        <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span>Union</span>»</h2>
            <ul class="lots__list">
                <!--заполните этот список из массива с товарами-->
                <?php foreach ($goods as $id => $good): ?>

                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= $good["url"]; ?>" width="350" height="260" alt="<?= $good["title"]; ?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= $good["category"]; ?></span>
                            <!--htmlspecialchars() - защита от XSS атак-->
                            <h3 class="lot__title"><a class="text-link" href="index.php?good=<?= $id; ?>"><?= htmlspecialchars($good["title"]); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">1</span>
                                    <!--htmlspecialchars() - защита от XSS атак-->
                                    <span class="lot__cost"><?= format_price(htmlspecialchars($good["start_price"])); ?></span>
                                </div>
                                <div class="lot__timer timer timer--finishing">
                                    <!--вывод времени-->
                                    <?= get_time(); ?>
                                </div>
                            </div>
                        </div>
                    </li>

                <?php endforeach; ?>
                
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-2.jpg" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                <span class="lot__category">Доски и лыжи</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">12 ставок</span>
                    <span class="lot__cost">15 999<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer timer--finishing">
                    00:54:12
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-3.jpg" width="350" height="260" alt="Крепления">
                </div>
                <div class="lot__info">
                <span class="lot__category">Крепления</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Крепления Union Contact Pro 2015 года размер
                    L/XL</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">7 ставок</span>
                    <span class="lot__cost">8 000<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                    10:54:12
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-4.jpg" width="350" height="260" alt="Ботинки">
                </div>
                <div class="lot__info">
                <span class="lot__category">Ботинки</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Ботинки для сноуборда DC Mutiny Charocal</a>
                </h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">12 ставок</span>
                    <span class="lot__cost">10 999<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer timer--finishing">
                    00:12:03
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-5.jpg" width="350" height="260" alt="Куртка">
                </div>
                <div class="lot__info">
                <span class="lot__category">Одежда</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">12 ставок</span>
                    <span class="lot__cost">10 999<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                    00:12:03
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-6.jpg" width="350" height="260" alt="Маска">
                </div>
                <div class="lot__info">
                <span class="lot__category">Разное</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Маска Oakley Canopy</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost">5 500<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                    07:13:34
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-4.jpg" width="350" height="260" alt="Ботинки">
                </div>
                <div class="lot__info">
                <span class="lot__category">Ботинки</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Ботинки для сноуборда DC Mutiny Charocal</a>
                </h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">12 ставок</span>
                    <span class="lot__cost">10 999<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer timer--finishing">
                    00:12:03
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-5.jpg" width="350" height="260" alt="Куртка">
                </div>
                <div class="lot__info">
                <span class="lot__category">Одежда</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">12 ставок</span>
                    <span class="lot__cost">10 999<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                    00:12:03
                    </div>
                </div>
                </div>
            </li>
            <li class="lots__item lot">
                <div class="lot__image">
                <img src="img/lot-6.jpg" width="350" height="260" alt="Маска">
                </div>
                <div class="lot__info">
                <span class="lot__category">Разное</span>
                <h3 class="lot__title"><a class="text-link" href="lot.html">Маска Oakley Canopy</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost">5 500<b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                    07:13:34
                    </div>
                </div>
                </div>
            </li>
            </ul>
        </section>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
            <li class="pagination-item pagination-item-active"><a>1</a></li>
            <li class="pagination-item"><a href="#">2</a></li>
            <li class="pagination-item"><a href="#">3</a></li>
            <li class="pagination-item"><a href="#">4</a></li>
            <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
    </div>
</main>
