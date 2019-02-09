<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $alias => $category): ?>

                <li class="promo__item promo__item--<?= $alias; ?>">
                    <a class="promo__link" href="index.php?category=<?= $alias; ?>"><?= $category; ?></a>
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
                        <img src="<?= $good["url"]; ?>" width="350" height="260" alt="<?= $good["designation"]; ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $good["category"]; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="index.php?good=<?= $id; ?>"><?= htmlspecialchars($good["designation"]); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?= htmlspecialchars(1); ?></span>
                                <span class="lot__cost"><?= format_price(htmlspecialchars($good["price"])); ?></span>
                            </div>
                            <div class="lot__timer timer">
                                12:23
                            </div>
                        </div>
                    </div>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>
</main>