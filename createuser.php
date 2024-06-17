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
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <a class="navbar-brand" href="#">Library Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="http://localhost/LibrarySys/welcome.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/LibrarySys/createuser.php">Create User </a>
      </li>
        </div>
      </li>
    </ul>
  </div>
</nav>
<div class="container m-5 p-4">
<form>
  <div class="mb-3">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="firstname" name="first_name" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="last_name" id="lastname">
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">UserName</label>
    <input type="text" class="form-control" name="user_name" id="username">
  </div>
  <select class="form-select" aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="librarian">Librarian</option>
  <option value="staff">Staff</option>
  <option value="student">Student</option>
</select>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
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