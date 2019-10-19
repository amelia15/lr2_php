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
