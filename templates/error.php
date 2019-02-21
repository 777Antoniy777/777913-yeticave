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
    <section class="lot-item container">
        <h2>404 Страница не найдена</h2>
        <p>Данной страницы не существует на сайте.</p>
        <p>Ошибка подключения: <?php= $error ?></p>
    </section>
</main>
