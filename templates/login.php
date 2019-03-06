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
    <form class="form container" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>

        <div class="form__item <?= isset($errors["email"]) ? "form__item--invalid" : ""; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $_POST["email"] ?? ""; ?>">
            <span class="form__error">Введите e-mail</span>
        </div>

        <div class="form__item form__item--last <?= isset($errors["password"]) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $_POST["password"] ?? ""; ?>">
            <span class="form__error">Введите пароль</span>
        </div>

        <?php if (count($errors)): ?>

            <span class="form__error form__error--bottom" style="display: block">Пожалуйста, исправьте ошибки в форме.</span>
            <ul>
                <?php foreach($errors as $error => $value): ?>
                <li><strong><?= $dict[$error]; ?>: </strong><?= $value; ?></li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

        <button type="submit" class="button">Войти</button>
    </form>
</main>
