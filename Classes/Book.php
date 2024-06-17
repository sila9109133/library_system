<?php
    include $_SERVER['DOCUMENT_ROOT'].'/LibrarySys/utility/DBConn.php';


    class Book{
        public $conn;
        private $allowedRoles = ['admin', 'librarian','user'];

        public function __construct(){
            $db = new DBConn();
            $this->conn = $db->conn;
        }

        public function saveBook($post){
            $bookTitle = $post['bookTitle'];
            $bookDesc = $post['bookDesc'];
            $author = $post['author'];

            $sql = "INSERT INTO books(bookTitle, bookDesc, author) VALUES('$bookTitle', '$bookDesc', '$author')";
            $result = $this->conn->query($sql);

            if($result){
                return json_encode(array('type' => 'success', 'message' => 'Book detail saved successfully.'));
            }else{
                return json_encode(array('type' => 'fail', 'message' => 'Unable to save book details.'));
            }
        }

        public function getAllBooks(){
            $sql = "SELECT * FROM books";
            $result = $this->conn->query($sql);
            $books = array();
            if($result->num_rows > 0){
                while($rows = $result->fetch_assoc()){
                    $books[]= $rows;
                }
                return $books;
            }
        }

        public function editBook($editId){
                $sql = "SELECT * FROM books WHERE bookId = $editId";
                $result = $this->conn->query($sql);
                $books = array();

                if($result->num_rows > 0){
                    while($rows = $result->fetch_assoc()){
                        $data['bookId'] = $rows['bookId'];
                        $data['bookTitle'] = $rows['bookTitle'];
                        $data['bookDesc'] = $rows['bookDec'];
                        $data['author'] = $rows['author'];
                    }
                 return json_encode($data);
                }   
            }
    }
    $book = new Book();

    if (isset($_POST['bookTitle'])){
        $saveBook = $book->saveBook($_POST);
        echo $saveBook;
    }
    if(isset($_POST['editId'])){
        $editBook = $book->editBook($_POST['editID']);
        echo $editBook;
    }
    
?>