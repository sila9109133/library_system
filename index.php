<div
<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/LibraryManagementSystem/classes/Book.php';

    $db = new DBconn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"> 
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class = "row">
            <div class = "col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-book" style="color: #B197FC;"></i>
                        Library Management System
                        <button class="btn btn-success btn-md float-right" data-toggle="modal" data-target="#addBook">Add Book</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width = "15%">No.</th>
                                    <th width = "55%">Book Title</th>
                                    <th width = "30%">Manage Book</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            
                            $bookObj = new Book();
                            $books = $bookObj->getAllBooks();
                            $no = 0;
                            foreach($books as $book):
                                   $no++;                         
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td>
                                        <h4><?php echo $book['bookTitle']; ?></h4>
                                        <small>- By <?php echo $book['author']; ?></small>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm editButton" data-toggle="modal" data-target="#addBook" id="<?php echo $book['bookid'];?>"><i class="fa-solid fa-pen-to-square" ></i> Edit Book</button>
                                        <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>     Delete Book</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->


<!-- Modal for adding new book record -->
<div class="modal fade" id="addBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-book"></i> Add New Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addBookForm">
            <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" name="bookTitle"class="form-control" required placeholder="Enter Book Title">
            </div>
            <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" name="bookDesc"class="form-control" required placeholder="Enter Book Title">
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author"class="form-control" required placeholder="Enter Book Author">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addBookBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for editing book details -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-book"></i> Edit Book Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden = "true"> &times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editBookForm">
            <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" name="bookTitle" id= "editBookTitle"  class="form-control" required placeholder="Enter Book Title">
                <input type="hidden" name="updateBookId" id ="bookId">                
            </div>
            <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" name="bookDesc" id = "bookDesc" class="form-control" required placeholder="Enter Book Title">
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" class="form-control" required placeholder="Enter Book Author">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editBookBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for adding new book record -->
<div class="modal fade" id="alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alert!</h1>
        
      </div>
      <div class="modal-body">
       <div class="alert"></div>
      </div>
     
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#addBookBtn').on('click', function(){
           $.post('classes/Book.php', $('form#addBookForm').serialize(), function(data){
                var data = JSON.parse(data);

                if(data.type == 'success'){
                    $('#addBook').modal('hide');
                    $('#alert').modal('show');
                    $('#alert .alert').addClass('alert-success').append(data.message).delay(15000).fadeOut('slow', function(){
                        location.reload();
                    }); 
                }else{
                    $('#addBook').modal('hide');
                    $('#alert').modal('show');
                    $('#alert .alert').addClass('alert-danger').append(data.message).delay(15000).fadeOut('slow', function(){
                        location.reload();
                    });
                }
           });
        });

        $('.editButton').on('click', function(e){

            $('#editBookModal').modal('show');
            $.post('classes/Book.php',{editId: e.target.id}, function(data){
                var data = JSON.parse(data);
                console.log($data);
                $('#editBookTitle').val(data.bookTitle);
                $('#bookDesc').val(data.bookDesc);
                $('#author').val(data.author);
                $('#bookId').val(data.bookId);
                
           });
        });
     });
    
    // });
</script>

</body>
</html>