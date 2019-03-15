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
    <section class="lot-item container">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($goods as $id => $good): ?>

            <h2><?= htmlspecialchars($good["title_lot"]); ?></h2>
            <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= htmlspecialchars($good["url"]); ?>" width="730" height="548" alt="<?= htmlspecialchars($good["title_lot"]); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= htmlspecialchars($good["title_category"]); ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars($good["description"]); ?></p>
            </div>
            <div class="lot-item__right">

                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= htmlspecialchars(get_time($good["date_end"])); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>

                            <span class="lot-item__cost">
                                <?= format_price(htmlspecialchars($total_price)); ?>
                            </span>

                        </div>
                        <div class="lot-item__min-cost">

                            Мин. ставка <span><?= htmlspecialchars($min_step); ?></span>

                        </div>
                    </div>

            <?php if ($is_auth && strtotime("now") < strtotime($goods[$id]["date_end"]) && !$lot && !$bet): ?>

                    <form class="lot-item__form" action="lot.php?id=<?= htmlspecialchars($lot_id); ?>" method="post">
                        <input type="hidden" name="lot_id" value="<?= htmlspecialchars($lot_id); ?>">
                        <p class="lot-item__form-item form__item <?= isset($errors["cost"]) ? "form__item--invalid" : ""; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" value="<?= !empty($_POST["cost"]) ? htmlspecialchars($_POST["cost"]) : ""; ?>" placeholder="<?= htmlspecialchars($min_step) ?>">

                            <?php if (isset($errors)): ?>

                                <?php foreach($errors as $error => $value): ?>
                                <span class="form__error"><strong><?= $dict[$error]; ?>: </strong><?= $value; ?></span>
                                <?php endforeach; ?>

                            <?php endif; ?>
                        </p>

                        <button type="submit" class="button">Сделать ставку</button>
                    </form>

            <?php endif; ?>

                </div>

        <?php endforeach; ?>

            <div class="history">

                    <h3>История ставок (<span><?= htmlspecialchars(count($bets)); ?></span>)</h3>
                    <table class="history__list">

                <?php foreach ($bets as $id => $bet): ?>

                    <tr class="history__item">
                        <td class="history__name"><?= htmlspecialchars($bet["name"]); ?></td>
                        <td class="history__price"><?= htmlspecialchars($bet["price"]); ?></td>
                        <td class="history__time"><?= htmlspecialchars(date("d.m.Y в H:m:s", strtotime($bet["date_start"]))); ?></td>
                    </tr>

                <?php endforeach; ?>

                </table>
            </div>
        </div>
        </div>
    </section>
</main>
