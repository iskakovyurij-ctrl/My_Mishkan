<?php session_start();?> 
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Моё Мишкино | Меню</title>
    
    <link rel="stylesheet" href="css/style.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <!-- 1. ШАПКА САЙТА -->
    <header class="site-header">
        <div class="logo-menu">
            <h1><a href="index.html">Моё Мишкино</a></h1>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.html">Главная</a></li>
                    <li><a href="#" class="active">Меню</a></li> 
                    <li><a href="contacts.html">Контакты</a></li>
                </ul>
            </nav>
        </div>

        <div class="mini-auth-panel">
    <div id="authModalTabs" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
        <a href="#" id="loginTab" class="tab-link active">Вход</a>
        <a href="#" id="registerTab" class="tab-link">Регистрация</a>
    </div>

    <!-- Форма будет меняться динамически -->
    <form action="auth.php" method="POST" id="authForm">
        <!-- Скрытое поле для типа действия -->
        <input type="hidden" name="action" value="login" id="formAction"> 
        
        <!-- Контейнер для полей регистрации (скрыт по умолчанию) -->
        <div id="regFields" style="display: none;">
            <input type="text" name="full_name" placeholder="ФИО полностью" required>
            <input type="tel" name="phone" placeholder="+7 (999) 000-00-00" required>
            <input type="email" name="email" placeholder="E-mail" required>
        </div>

        <!-- Общие поля (Логин/Пароль) -->
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="pass" placeholder="Пароль" required>
        
        <button type="submit" id="authSubmitBtn">Войти</button>
    </form>
</div>

    <!-- ОСНОВНОЙ КОНТЕНТ -->
    <main class="content">
        
        <section class="hero" style="text-align: center; padding: 40px 20px;">
            <h1>Разделы сообщества</h1>
            <p>Выберите категорию, чтобы посмотреть информацию или добавить свое объявление.</p>
            
            <div style="margin-top: 30px; display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                <a href="#news" class="btn-readmore">📰 Новости</a>
                <a href="#sell" class="btn-readmore">🚜 Продам излишки</a>
                <a href="#work" class="btn-readmore">💼 Работа</a>
                <a href="#reviews" class="btn-readmore">⭐ Отзывы</a>
            </div>
        </section>

        <!-- БЛОК НОВОСТЕЙ -->
        <section id="news" class="dashboard-widget news">
            <h2>📰 Последние новости</h2>
            <ul class="news-list">
                <li><strong>15.09.26:</strong> Мы обновили ассортимент продукции.</li>
                <li><strong>10.09.26:</strong> Изменились условия доставки по городу.</li>
            </ul>
        </section>

<!-- БЛОК ПРОДАМ ИЗЛИШКИ -->
        <section id="sell" class="dashboard-widget ads">
            <h2>🚜 Продам излишки</h2>
    
            <?php if (isset($_SESSION['currentUser'])): ?>
                <form action="add_item.php" method="POST" class="ad-form">
                    <input type="text" name="title" placeholder="Название товара" required>
                    <input type="number" name="price" placeholder="Цена" required>
                    <button type="submit" class="btn-mini-login">Добавить товар</button>
                </form>
                <hr style="border: 1px dashed #ccc; margin: 15px 0;">
            <?php endif; ?>
            <!-- ... список товаров ... -->
        </section>

        <!-- БЛОК ОТЗЫВЫ (ТОЛЬКО ОДИН РАЗ!) -->
        <section id="reviews" class="dashboard-widget reviews">
            <h2>⭐ Отзывы</h2>
    
            <?php if (isset($_SESSION['currentUser'])): ?>
                <!-- ИСПРАВЛЕНО: убран лишний "/" -->
                <form action="add_review.php" method="POST" class="review-form">
                    <textarea name="text" placeholder="Ваш отзыв..." required></textarea>
                    <button type="submit" class="btn-mini-login">Оставить отзыв</button>
                </form>
                <hr style="border: 1px dashed #ccc; margin: 15px 0;">
            <?php else: ?>
                <p style="color:#e0e0e0;">Чтобы оставить отзыв, пожалуйста, <a href="#" id="openAuthFromMini">авторизуйтесь</a>.</p>
            <?php endif; ?>

            <blockquote class="review-text">
                "Отличное качество саженцев!"
                <cite>- Иван Петров</cite>
            </blockquote>
        </section>

        <!-- БЛОК РАБОТА -->
        <section id="work" class="dashboard-widget jobs">
            <h2>💼 Работа</h2>
            <div class="job-item"><h3>Требуется водитель</h3></div>
            <div class="job-item"><h3>Агроном-консультант</h3></div>
            <a href="#" class="btn-readmore">Разместить вакансию →</a>
        </section>

        <!-- БЛОК ОТЗЫВЫ -->
        <section id="reviews" class="dashboard-widget reviews">
            <h2>⭐ Отзывы</h2>
            
            <!-- Форма отзыва (видит только залогиненный) -->
            <?php if (isset($_SESSION['currentUser'])): ?>
                <form action="/add_review.php" method="POST" class="review-form">
                    <textarea name="text" placeholder="Ваш отзыв..." required></textarea>
                    <button type="submit" class="btn-mini-login">Оставить отзыв</button>
                </form>
                <hr style="border: 1px dashed #ccc; margin: 15px 0;">
            <?php else: ?>
                <p style="color:#e0e0e0;">Чтобы оставить отзыв, пожалуйста, <a href="#" id="openAuthFromMini">авторизуйтесь</a>.</p>
            <?php endif; ?>

            <blockquote class="review-text">
                "Отличное качество саженцев!"
                <cite>- Иван Петров</cite>
            </blockquote>
        </section>
    </main>

    <div id="authModal" class="modal"></div>

    <script src="js/script.js"></script>
</body>
</html>