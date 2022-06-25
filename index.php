<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <title>Медиатека</title>

    <?php
      include 'stuff.php';
      session_start();
      unset($_SESSION['message']);
    ?>

  </head>
<body>

<div class="img-bg" style="background-image: url(img/bg1.jpg);background-repeat: no-repeat;" data-img-width="6240" data-img-height="3512">

  <div class="navigation">
      <div class="nav">
          <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="release.php">Релизы</a></li>
            <li><a href="random.php">Рандом</a></li>
            <li><a href="store.php">Магазин</a></li>
            <li><a href="contact.php">Контакты</a></li>

            <?php
                if(isset($_SESSION['login']))
                {
            ?>
                    <li style="float:right"><a class="active-sign-in" href="account.php">Личный кабинет</a></li>
            <?php
                }
                else
                {
            ?>
                    <li style="float:right"><a class="active-sign-up" href="reg.php">Зарегистрироваться</a></li>
                    <li style="float:right"><a class="active-sign-in" href="autor.php">Войти</a></li>
            <?php
                }
            ?>

          </ul>
      </div>
  </div>

  <div class="main">
      <div class="style-header">
          <h1>Медиатека</h1>
      </div>

      <div class="style-text", style="opacity: 0.75;">
          <h2>О сайте</h2>
          <p>На данном сайте Вы сможете найти любимого исполнителя, просмотеть выпущенные им альбомы, а также приобрести понравившиеся композиции.</p>
          <p>А если хотите найти что-нибудь новенькое, то в разделе "Релизы" Вы надёте свежие треки!</p>
      </div>
  </div>

</div>
</body>
</html>