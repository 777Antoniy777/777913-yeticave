<main>
    <nav class="nav">
        <ul class="nav__list container">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $category): ?>

                <li class="promo__item promo__item--<?= $category["alias"]; ?>">
                    <a class="promo__link" href="index.php?category=<?= $category["alias"]; ?>"><?= $category["title_category"]; ?></a>
                </li>

            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($goods as $id => $good): ?>

            <h2><?= $good["title_lot"]; ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?= $good["url"]; ?>" width="730" height="548" alt="<?= $good["title_lot"]; ?>">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $good["title_category"]; ?></span></p>
                    <p class="lot-item__description"><?= $good["description"]; ?></p>
                </div>
                <div class="lot-item__right">
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            10:54
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= format_price(htmlspecialchars($good["start_price"])); ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= $good["step"]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </section>
</main>
