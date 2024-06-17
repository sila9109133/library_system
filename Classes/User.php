<?php
class DBconn {
    private $host = 'localhost';
    private $db_name = 'db_library';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class User  {
    private $conn;
    private $table_name = "user";

    public $id;
    public $user_name;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $this->user_name = $username;
        $this->password = $password;

        $query = "SELECT id, user_name, password FROM " . $this->table_name . " WHERE user_name = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->user_name);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->user_name = $row['user_name'];
                return true;
            }
        }
        return false;
    }

    public function createUser($post){
        $first_name = $post['first_name'];
        $last_name = $post['last_name'];
        $user_name = $post['user_name'];

        $sql = "INSERT INTO books(first_name, last_name, user_name) VALUES('$first_name', '$last_name', '$user_name')";
        $result = $this->conn->query($sql);

        if($result){
            return json_encode(array('type' => 'success', 'message' => 'User saved successfully.'));
        }else{
            return json_encode(array('type' => 'fail', 'message' => 'Unable to save User.'));
        }

    }
}

class LoginController {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function attemptLogin($username, $password) {
        if ($this->user->login($username, $password)) {
            echo "Login successful!";
        } else {
            echo "Login failed!";
        }
    }
}

if (isset($_POST['bookTitle'])){
    $saveBook = $book->saveBook($_POST);
    echo $saveBook;
}
if(isset($_POST['editId'])){
    $editBook = $book->editBook($_POST['editID']);
    echo $editBook;
}


// Usage
$dbconn = new DBconn();
$conn = $dbconn->getConnection();

$user = new User($conn);
$loginController = new LoginController($user);

$loginController->attemptLogin('username', 'password'); // replace with actual username and password
?>