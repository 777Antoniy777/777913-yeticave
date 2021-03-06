<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $category): ?>

                <li class="promo__item promo__item--<?= htmlspecialchars($category["alias"]); ?>">
                    <a class="promo__link" href="index.php?category=<?= htmlspecialchars($category["alias"]); ?>"><?= htmlspecialchars($category["title_category"]); ?></a>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($goods as $id => $good): ?>

                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($good["url"]); ?>" width="350" height="260" alt="<?= htmlspecialchars($good["title_lot"]); ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($good["title_category"]); ?></span>
                        <!--htmlspecialchars() - защита от XSS атак-->
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($id + 1); ?>"><?= htmlspecialchars($good["title_lot"]); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">1</span>
                                <!--htmlspecialchars() - защита от XSS атак-->
                                <span class="lot__cost"><?= format_price(htmlspecialchars($good["start_price"])); ?></span>
                            </div>
                            <div class="lot__timer timer">
                                <!--вывод времени-->
                                <?= htmlspecialchars(get_time($good["date_end"])); ?>
                            </div>
                        </div>
                    </div>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>
</main>
