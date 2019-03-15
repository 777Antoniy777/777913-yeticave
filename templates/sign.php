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
    <form class="form container" action="sign.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>

        <div class="form__item <?= isset($errors["email"]) ? "form__item--invalid" : ""; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= !empty($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ""; ?>" required>
            <span class="form__error">Введите e-mail</span>
        </div>

        <div class="form__item <?= isset($errors["password"]) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= !empty($_POST["password"]) ? htmlspecialchars($_POST["password"]) : ""; ?>" required>
            <span class="form__error">Введите пароль</span>
        </div>

        <div class="form__item <?= isset($errors["name"]) ? "form__item--invalid" : ""; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= !empty($_POST["name"]) ? htmlspecialchars($_POST["name"]) : ""; ?>" required>
            <span class="form__error">Введите имя</span>
        </div>

        <div class="form__item <?= isset($errors["message"]) ? "form__item--invalid" : ""; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?= !empty($_POST["message"]) ? htmlspecialchars($_POST["message"]) : ""; ?></textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>

        <div class="form__item form__item--file form__item--last">
            <label>Аватар</label>
            <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
            </div>
            <div class="form__input-file">
            <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
            </div>
        </div>

        <?php if (count($errors)): ?>

            <span class="form__error form__error--bottom" style="display: inline">Пожалуйста, исправьте ошибки в форме.</span>
            <ul>
                <?php foreach($errors as $error => $value): ?>
                <li><strong><?= $dict[$error]; ?>: </strong><?= $value; ?></li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
