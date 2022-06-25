<?php 
function clear($string)
{
    $string = trim($string);   
    $string = stripslashes($string); 
    $string = strip_tags($string); 
    $string = htmlspecialchars($string);
    return $string;
}

function checkSize($string,$min,$max)
{
    $result = (mb_strlen($string) > $min && mb_strlen($string) <= $max);
    return $result;
}

function autor($login,$pass)
{
    include "connect.php";
    session_start();
    $login = mysqli_real_escape_string($conn,$login);  // поле в каркасе
    $pass = mysqli_real_escape_string($conn,$pass);    // поле в каркасе
    clear($login); 
    clear($pass);
    unset($_SESSION['message']);

    $quer = 'SELECT COUNT(*) FROM пользователи WHERE `Логин` LIKE \''.$login.'\'' ;
    $checkUsers = mysqli_query($conn,$quer)or die("Ошибка авторизации" . mysqli_error($conn));
    $row = mysqli_fetch_row($checkUsers);
    if($row[0] > 0)
    {
        $quer = 'SELECT * FROM пользователи WHERE `Логин` LIKE \''.$login.'\'' ;
        $user = mysqli_query($conn,$quer) or die("Ошибка " . mysqli_error($conn));
        $users = mysqli_fetch_assoc($user);
        if(($users['Пароль'] == clear($pass)))
        {
            $_SESSION['login'] = $login;
            $_SESSION['pass'] = $pass;
            $_SESSION['id'] = $users['Номер пользователя'];
            
            $_SESSION['message'] = '<center><strong><i>Здравстуйте, '.$login.'</i></strong></center>';
            header('Refresh: 1; URL = account.php');
        }
        else
        {
            $_SESSION['message'] = '<center><strong><i>Был введен неверный пароль</i></strong></center>';
            header('Refresh: 1; URL = autor.php');
        }
    }
    else
    {
        $_SESSION['message'] = '<center><strong><i>Пользователь не найден</i></strong></center>';
        header('Refresh: 1; URL = autor.php');
    }

}

function reg($name,$login,$pass,$email)
{
    clear($name);
    clear($email);
    clear($login);
    clear($pass);
    unset($_SESSION['message']);

    if(!checkSize($name, 2, 20))
        $_SESSION['message'] = "<center><strong><i>Имя некорректно</i></strong></center>";
        
    elseif(!checkSize($login, 1, 20))
        $_SESSION['message'] = "<center><strong><i>Логин должен иметь длинну не больше 20 и не меньше 1 символов</i></strong></center>";
        
    elseif(!checkSize($pass, 1, 18))
        $_SESSION['message'] = "<center><strong><i>Пароль должен иметь длинну не больше 18 и не меньше 1 символов</i></strong></center>";

    else
    {
        include "connect.php" ;

        $quer = 'SELECT COUNT(*) FROM пользователи WHERE `Логин` LIKE \''.$login.'\'' ;
        $checkUsers = mysqli_query($conn,$quer)or die("Ошибка авторизации" . mysqli_error($conn));
        $row = mysqli_fetch_row($checkUsers);

        if($row[0] > 0)
        {
            $_SESSION['message'] = "<center><i>Пользователь с данным логином уже существует</i></center>";
        }
        else
        {
            $insert = "INSERT INTO `пользователи` (`Номер пользователя`, `Имя пользователя`, `Логин`, `Пароль`, `Почта`) VALUES (NULL, '".$name."', '".$login."', '".$pass."', '".$email."')";
            
            $insert = mysqli_query($conn, $insert) or die("Ошибка добавления данных " . mysqli_error($conn));
            
            $_SESSION['message'] = "<center><strong><i>Пользователь добавлен</i></strong></center>";
        }

        header('Refresh: 3; URL = index.php');
    }  
}

function print_store($req){
    include "connect.php";
    $req = mysqli_query($conn,$req) or die("Ошибка запроса". mysqli_error($conn));
    session_start();
    echo "<form metod = \"GET\">";
    if($req){
        echo "<center><table border = \"1\"><tr><th>Исполнитель</th><th>Альбом</th><th>Жанр</th></tr>";
        while ($r = mysqli_fetch_assoc($req)){
            echo "<tr><td>".$r['Имя исполнителя']."</td>
                    <td>".$r['Название альбома']."</td>
                    <td>".$r['Название жанра']."</td>
                    <td><input type=\"checkbox\" name=\"choices[]\" value = \"".$r['Номер альбома']."\"></td>
                    </tr>";
        }
        echo "</table></center>
        <b>Чтобы добавить в корзину - поставьте рядом с нужной позицией галочку</b><br><br><input type=\"submit\" name=\"add\" value=\"Добавить\"></form>";
        if(!empty($_GET['add'])){
            if(!empty($_GET['choices']))
            {
                if(isset($_SESSION['id']))
                {
                    $_SESSION['basket'] = $_GET['choices'];
                    echo "Добавлено<br><br>";                  
                }
                else
                    echo "К сожалению вы не зарегистрированы<b> <a href=\"autor.php\">Авторизуйтесь</a> или <a href=\"reg.php\">зарегистрируйтесь</a> на сайте и возвращайтесь<br><br>";
            }
            else echo "<b>Ничего не выбрано :(</b>";
        }   
    }
}

?>