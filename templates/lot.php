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

            <?php if (isset($_SESSION["user"])): ?>

                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= get_time($good["date_end"]); ?>
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
                    <form class="lot-item__form" action="lot.php" method="post">
                        <p class="lot-item__form-item form__item <?= isset($errors["cost"]) ? "form__item--invalid" : ""; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" value="<?= $_POST["cost"] ?? ""; ?>" placeholder="12 000">
                            <span class="form__error">Введите наименование лота</span>
                        </p>

                        <?php if (isset($errors)): ?>

                            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
                            <ul>
                                <?php foreach($errors as $error => $value): ?>
                                <li><strong><?= $dict[$error]; ?>: </strong><?= $value; ?></li>
                                <?php endforeach; ?>
                            </ul>

                        <?php endif; ?>

                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>

            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                <tr class="history__item">
                    <td class="history__name">Иван</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">5 минут назад</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Константин</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">20 минут назад</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Евгений</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">Час назад</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Игорь</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 08:21</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Енакентий</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 13:20</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Семён</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 12:20</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Илья</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 10:20</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Енакентий</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 13:20</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Семён</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 12:20</td>
                </tr>
                <tr class="history__item">
                    <td class="history__name">Илья</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">19.03.17 в 10:20</td>
                </tr>
                </table>
            </div>
        </div>
        </div>
    </section>
</main>
