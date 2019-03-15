<main>
    <nav class="nav">
        <ul class="nav__list container">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $category): ?>

                <li class="promo__item promo__item--<?= htmlspecialchars($category["alias"]); ?>">
                    <a class="promo__link" href="index.php?category=<?= htmlspecialchars($category["alias"]); ?>"><?= htmlspecialchars($category["title_category"]); ?></a>
                </li>

            <?php endforeach; ?>
        </ul>
        </nav>
        <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($search); ?></span>»</h2>
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
                            <h3 class="lot__title"><a class="text-link" href="lot.php?good=<?= htmlspecialchars($id); ?>"><?= htmlspecialchars($good["title_lot"]); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">1</span>
                                    <!--htmlspecialchars() - защита от XSS атак-->
                                    <span class="lot__cost"><?= format_price(htmlspecialchars($good["start_price"])); ?></span>
                                </div>
                                <div class="lot__timer timer timer--finishing">
                                    <!--вывод времени-->
                                    <?= htmlspecialchars(get_time()); ?>
                                </div>
                            </div>
                        </div>
                    </li>

                <?php endforeach; ?>

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
