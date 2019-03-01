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
    <form class="form form--add-lot container form--invalid" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">

            <?php
                $classname = isset($errors["lot-name"]) ? "form__item--invalid" : "";
                $value = $lot["lot-name"] ?? "";
            ?>

            <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $value; ?>" required>
            <span class="form__error">Введите наименование лота</span>
            </div>
            <div class="form__item">
            <label for="category">Категория</label>
            <select id="category" name="category" required>
                <option>Выберите категорию</option>

                <?php foreach ($categories as $category): ?>

                    <option value="<?= $category["alias"]; ?>"> <?= $category['title_category']; ?></option>

                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
            </div>
        </div>

        <?php
            $classname = isset($errors["message"]) ? "form__item--invalid" : "";
            $value = $lot["message"] ?? "";
        ?>

        <div class="form__item form__item--wide <?= $classname; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" required value="<?= $value; ?>"></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <div class="form__item form__item--file"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
            </div>
            <div class="form__input-file">
            <input class="visually-hidden" type="file" name="good_img" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" required>
            <span class="form__error">Введите начальную цену</span>
            </div>
            <div class="form__item form__item--small">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" required>
            <span class="form__error">Введите шаг ставки</span>
            </div>
            <div class="form__item">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" required>
            <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>

        <?php if (isset($errors)): ?>

            <div class="form__errors">
                <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
                <ul>
                    <?php foreach($errors as $error => $value): ?>
                    <li><strong><?= $dict[$error]; ?>: </strong><?= $value; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>

        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
