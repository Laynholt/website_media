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

      if(isset($_GET['exit']))
      {
          session_destroy();
          header('Location: index.php');
          exit;
      }

      if(!isset($_SESSION['id']))
          header("Location: autor.php");
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
          <h1>Личный кабинет</h1>
      </div>

      <div class="style-text", style="opacity: 0.75;">
          <?php 
            if(isset($_SESSION['login']))
            {
              echo "<p style=\"font-size:25px;\">Здравствуйте, ".$_SESSION['login']."</p>";
          ?>
              <div class="info">
                      <?php
                          include "connect.php";
                          $quer = "SELECT * FROM пользователи WHERE `Номер пользователя` = ".$_SESSION['id'];
                          $checkUsers = mysqli_query($conn,$quer)or die("Ошибка запроса поиска" . mysqli_error($conn));
                          $row = mysqli_fetch_assoc($checkUsers);
                          echo "Ваше имя: ".$row['Имя пользователя']."<br>
                          Ваш логин: ".$row['Логин']."<br>
                          Ваш e-mail: </td><td>".$row['Почта']."<br>";
                      ?>
                      <form method="POST">
                          <input type="submit" name="edit" value="Редактировать">
                      </form>
              </div>
          <?php 
              echo "<form metod = \"get\"><input type=\"submit\" name=\"exit\" value=\"Выход\"><br></form>";
            }
          ?>

          <center><strong><i>Здесь Вы можете посмотреть свою корзину или историю покупок</i></strong></center>
          <form method="POST">
            <center><table>
              <tr>
                <td><input type="submit" name="basket" value="Корзина"><br></td>
                <td><input type="submit" name="history" value="История"><br></td>
              </tr>
            </table></center>
          </form>

      </div>
      <div class="style-text", style="opacity: 0.75;">
          <?php 
              if(isset($_POST['edit']))
              {
                  include "connect.php";
                  $quer = "SELECT * FROM пользователи WHERE `Номер пользователя` = ".$_SESSION['id'];
                  $checkUsers = mysqli_query($conn,$quer)or die("Ошибка запроса" . mysqli_error($conn));
                  $row = mysqli_fetch_assoc($checkUsers);
          ?>
              <form method="POST">
              <table>
              <tr><td>Имя:</td><td><input type="text" name="name" value="<? echo $row['Имя пользователя']; ?>"></td></tr>
              <tr><td>E-mail:</td><td><input type="email" name="email" value="<? echo $row['Почта']; ?>"></td></tr>
              <tr><td>Логин:</td><td><input type="text" name="login" value="<? echo $row['Логин']; ?>"></td></tr>
              <tr><td><b>Для изменения введите пароль </b></td><td><td/>
              <tr><td><input type="password" name="pass" ></td></tr>
              
              </table>
              <br><input type="submit" name="update" value="Изменить"><br><br>
            </form>
          <?php
          }
          ?>
      </div>
      <?php
          if(isset($_POST['update']))
          {
              if($_POST['pass']==$row['Пароль'])
              {
                $quer = 'UPDATE пользователи SET `Имя пользователя` = \''.$_POST['name'].'\', Почта = \''.$_POST['email'].'\', Логин =\''.$_POST['login'].'\' WHERE `Номер пользователя` = '.$_SESSION['id'];
                $result = mysqli_query($conn,$quer)or die("Ошибка запроса" . mysqli_error($conn));
                echo "<center><strong><i>Данные изменены!</i></strong></center>";
                header('Refresh: 1; URL = account.php');
              }
              else 
              {
                echo "<center><strong><i>Неверный пароль</i></strong></center>";
                header('Refresh: 1; URL = account.php');
              }
          }
      ?>
      <div class="style-text", style="opacity: 0.75;">
          <?php
              if(isset($_POST['basket'])){
              if(!empty($_SESSION['basket']))
              {
                  echo "<center><table border = \"1\"><tr><th>Исполнитель</th><th>Альбом</th><th>Жанр</th></tr>";  
                  foreach ($_SESSION['basket'] as $key => $value) 
                  {
                    $quer = "SELECT исполнители.`Имя исполнителя`, альбомы.`Название альбома`, жанры.`Название жанра` FROM альбомы INNER JOIN исполнители ON (альбомы.`Номер исполнителя` = исполнители.`Номер исполнителя`) INNER JOIN жанры ON (альбомы.`Номер жанра` = жанры.`Номер жанра`) WHERE `Номер альбома` = '".$value."'";
                    $res = mysqli_query($conn,$quer)or die("Ошибка запроса поиска" . mysqli_error($conn));
                    $r = mysqli_fetch_assoc($res);

                    echo "<tr><td>".$r['Имя исполнителя']."</td>
                        <td>".$r['Название альбома']."</td>
                        <td>".$r['Название жанра']."</td></tr>";
                    }
                    echo "</table></center>
                        <form method=\"POST\"><input type=\"submit\" name=\"buy\" value=\"Купить\">
                        <input type=\"submit\" name=\"x\" value=\"Закрыть\">

                        </form>";
                  }
                  else echo "<center><strong><i>Корзина пуста</i></strong></center>";
              }
              elseif(isset($_POST['history']))
              {
                  $quer = "SELECT COUNT(*) FROM корзина WHERE `Номер пользователя` = ".$_SESSION['id'] ;
                  $result = mysqli_query($conn,$quer)or die("Ошибка запроса истории 1" . mysqli_error($conn));
                  $row = mysqli_fetch_row($result);

                  echo "<center><strong><i>Ваша история покупок</i></strong></center>";
                  echo "<form metod = \"GET\">";
                  if($row[0] > 0)
                  {
                      $quer = 'SELECT `корзина`.*, `альбомы`.`Название альбома`, `исполнители`.`Имя исполнителя` FROM `корзина` INNER JOIN `альбомы` ON (`корзина`.`Номер альбома` = `альбомы`.`Номер альбома`) INNER JOIN `исполнители` ON (`альбомы`.`Номер исполнителя` = `исполнители`.`Номер исполнителя`) WHERE `корзина`.`Номер пользователя` = '.$_SESSION['id'];

                      $result = mysqli_query($conn,$quer)or die("Ошибка запроса истории 2" . mysqli_error($conn));
                      echo "<center><table border = \"1\"><tr><th>Исполнитель</th><th>Альбом</th></tr>";        
                      while ($r = mysqli_fetch_assoc($result))
                      {
                          echo "<tr><td>".$r['Имя исполнителя']."</td>
                          <td>".$r['Название альбома']."</td></tr>";
                      }
                      echo "</table></center>";
                  }   
                  else echo "<center><strong><i>У вас нет покупок</i></strong></center>";
              }
              elseif(isset($_POST['buy']))
              {
                  foreach ($_SESSION['basket'] as $key => $value){

                      $add = "INSERT INTO корзина (`Номер пользователя`, `Номер альбома`) VALUES ('".$_SESSION['id']."','".$value."')";  
                      $add = mysqli_query($conn,$add)or die("Ошибка запроса добавления" . mysqli_error($conn));
                  }

                  echo "<center><strong><i>Покупка успешно завершина!</i></strong></center>";
                  unset($_SESSION['basket']);
                  header('Refresh: 0; URL = account.php');         
              }
          ?>
      </div>
  </div>

</div>
</body>
</html>