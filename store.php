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
          <h1>Магазин</h1>
      </div>

      <div class="style-text", style="opacity: 0.75;">
        <form method="post">
          <label for="filter">Выберите фильтр: </label>
          <select name="filter">
              <option value="Без Фильтра">Без Фильтра</option>
              <optgroup label="По алфавиту">
                <option value="По алфавиту [исполнители]">По алфавиту [исполнители]</option>
                <option value="По алфавиту [альбомы]">По алфавиту [альбомы]</option>
                <option value="По алфавиту [жанры]">По алфавиту [жанры]</option>
              </optgroup>
            <optgroup label="По Жанрам">
              <?php 
                  include "connect.php";
                  $exposition = array();
                  $quer = "SELECT distinct `Название жанра` FROM жанры";
                  $result = mysqli_query($conn, $quer) or die("Ошибка " . mysqli_error($conn));
                  if ($result){
                      while($rows = mysqli_fetch_assoc($result)) {
                          $exposition[] = array_values($rows);
                      }   
                  }
                  
                  foreach ($exposition as $arr){
                      foreach ($arr as $value){
                          echo '<option value="'.$value.'">'.$value.'</option>';
                      }
                  }
              ?>
              
            </optgroup>
          </select> 
          <input type="submit" name="filtrate" value = "Фильтровать">
        </form>

        <?php 
            if(isset($_POST["filtrate"])){
                $filter=$_POST['filter'];

                if($filter == "Без Фильтра"){
                    $filter_type = "";
                }
                elseif ($filter == "По алфавиту [исполнители]") {
                    $filter_type = "ORDER BY исполнители.`Имя исполнителя` ASC"; 
                }
                elseif ($filter == "По алфавиту [альбомы]") {
                    $filter_type = "ORDER BY альбомы.`Название альбома` ASC"; 
                }
                elseif ($filter == "По алфавиту [жанры]") {
                    $filter_type = "ORDER BY жанры.`Название жанра` ASC"; 
                }
                else{
                    include "connect.php";
                    $quer = "SELECT жанры.`Номер жанра` FROM жанры WHERE `Название жанра` LIKE '".$filter."'";
                    $checkUsers = mysqli_query($conn,$quer)or die("Ошибка запроса" . mysqli_error($conn));
                    $row = mysqli_fetch_assoc($checkUsers);

                    $filter_type = "WHERE альбомы.`Номер жанра` = ".$row['Номер жанра'];
                }

                $req = "SELECT исполнители.`Имя исполнителя`, жанры.`Название жанра`, альбомы.`Название альбома`, альбомы.`Номер альбома` FROM альбомы INNER JOIN исполнители ON (альбомы.`Номер исполнителя` = исполнители.`Номер исполнителя`) INNER JOIN жанры ON (альбомы.`Номер жанра` = жанры.`Номер жанра`) ".$filter_type;
                print_store($req);
            }
            else
            {
                $req = "SELECT исполнители.`Имя исполнителя`, жанры.`Название жанра`, альбомы.`Название альбома`, альбомы.`Номер альбома` FROM альбомы INNER JOIN исполнители ON (альбомы.`Номер исполнителя` = исполнители.`Номер исполнителя`) INNER JOIN жанры ON (альбомы.`Номер жанра` = жанры.`Номер жанра`)";
                print_store($req);
            }
        ?>
      </div>
  </div>

</div>
</body>
</html>