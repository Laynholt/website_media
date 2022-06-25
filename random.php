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
          <h1>Случайный альбом</h1>
      </div>

      <div class="style-content", style="opacity: 0.75;">
          <?php
              include "connect.php";
              $quer = "SELECT COUNT(*) FROM альбомы";
              $max_elem = mysqli_query($conn,$quer) or die("Ошибка запроса". mysqli_error($conn));
              $num = mysqli_fetch_assoc($max_elem);

              if ($max_elem > 0)
              {
                  $random_album = rand(1, $num['COUNT(*)']);
                  

                  $quer = "SELECT исполнители.`Имя исполнителя`, альбомы.`Название альбома`, альбомы.`Описание`, альбомы.`Обложка`, жанры.`Название жанра` FROM альбомы INNER JOIN исполнители ON (альбомы.`Номер исполнителя` = исполнители.`Номер исполнителя`) INNER JOIN жанры ON (альбомы.`Номер жанра` = жанры.`Номер жанра`) WHERE альбомы.`Номер альбома` = ".$random_album;

                  $res = mysqli_query($conn,$quer) or die("Ошибка запроса". mysqli_error($conn));
                  $r = mysqli_fetch_assoc($res);
                  if($r)
                  {
                      echo "<center><table>";
                      echo "<tr align=\"center\"><td><strong>"."Альбом: ".$r['Название альбома']."<br> Исполнитель: ".$r['Имя исполнителя']."<br> Жанр: ".$r['Название жанра']."<br><img src = \"img/albums/".$r['Обложка']."\" width=\"200\" height=\"200\"><br><b></strong></td></tr>";
                      echo"</tr></table></center>";
                  }
              }
          ?>
      </div>
  </div>

</div>
</body>
</html>