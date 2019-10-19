# Лабораторна работа №2 по "Веб-програмуванню"
### Робота з веб-формами та вивчення особливостей застосування баз даних у веб-додатку (розробка онлайн щоденника – блогу).

***
#### Виконала: Вознюк Дарина
##### Група: 6.04.122.012.16.1

***

<p align="center"><bold>
	Хід роботи:
	</bold></p>
	

***Завдання <br/>
    Розробити програму на мові PHP, що буде взаємодіяти із базою даних PHP<br/>***
    
    Нижче приведений код програми файлів html, css та php.
    
```html
<!DOCTYPE HTML>
<html>  
<head>
  <link href="style.css" rel="stylesheet">
</head>

<body>
    <form action="action.php" method="post" >
        <div id="values">
            Firstame: <input class="field" type="text" name="name"><br><br>
            Lastname: <input class="field" type="text" name="lastname"><br><br>
        </div>
        <div id="buttons">
            <input class="button" type="submit" name="create" value="Create table">
            <input class="button" type="submit" name="show" value="Show values">
            <input class="button" type="submit" name="insert" value="Insert values">
            <input class="button" type="submit" name="delete" value="Delete table">
        </div>
    </form>
</body>
</html>
```

```css
@CHARSET "UTF-8";

form{
    border:1px black solid;
    background-color:#98FB98;
    width:50%;
    margin-top:50%;
   margin:auto;
}

.field{
    width:95%;
     padding: 0px 10px 10px 10px;
}

#values{
     padding: 10px 10px 10px 10px;
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.button:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
    background-color:#419444;
}


#buttons{
    text-align:center;
    padding: 15px 3px 30px 10px;
}
```
    

```php
<?php
$servername = "localhost";
$username = "che";
$password = "che";
$dbname = "che_db";


if (isset($_POST["create"]))
{
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "CREATE TABLE MyGuests (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(100) NOT NULL,
        lastname VARCHAR(100)
        )";

        $conn->exec($sql);
        echo "Table MyGuests created successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    
    $conn = null;
}

if (isset($_POST["show"]))
{
    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>Id</th><th>Name</th><th>Lastname</th></tr>";

    class TableRows extends RecursiveIteratorIterator {
        function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }
    
        function current() {
            return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
        }
    
        function beginChildren() {
            echo "<tr>";
        }
    
        function endChildren() {
            echo "</tr>" . "\n";
        }
    }    
     
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        $stmt = $conn->prepare("SELECT id, firstname, lastname  FROM MyGuests");
        $stmt->execute();
    
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
}

if (isset($_POST["insert"]))
{ 
    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>Id</th><th>Name</th><th>Lastname</th></tr>";    
    
    class TableRows extends RecursiveIteratorIterator {
        function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }
    
        function current() {
            return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
        }
    
        function beginChildren() {
            echo "<tr>";
        }
    
        function endChildren() {
            echo "</tr>" . "\n";
        }
    }
      
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $name = $_POST['name'];
        $value = $_POST['lastname'];
    
        $sql = "INSERT INTO MyGuests (firstname, lastname) VALUES ('".$name."', '".$value."')";
        $conn->exec($sql);
     
        $stmt = $conn->prepare("SELECT id, firstname, lastname  FROM MyGuests");
        $stmt->execute();
    
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
}

if (isset($_POST["delete"]))
{

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "DROP TABLE MyGuests ";
    
        $conn->exec($sql);
        echo "Table deleted successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    
    $conn = null;
}
?>
```





  ![Результат виконання програми](/Result_7.png)

___

***Завдання 4***

***Проект на GitHub***

Підключення проекту до акаунту на GitHub та дослідження можливостей колаборації Git та Codenvy. 

 
Вигляд проекту на Github:

  ![Вигляд проекту на Github](Git.png)
 
___

***Висновки:***

	Під час виконання лабораторної роботи були вивчені способи обробки даних http-запитів засобами мови PHP та проаналізовані способи взаємодії PHP-скриптів із сервером БД MySQL для розробки веб-додатків. На прикладі власноруч створеного проекту я попрактикувала отримані теоретичні знання. Окрему увагу, я приділила також особливостям роботи з середою розробки на мові PHP та системі контролю версій GitHub.
	Таким чином, мета лабораторної роботи була досягнута.
