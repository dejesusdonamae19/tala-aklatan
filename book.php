<?php include 'includes/session.php'; ?>
<?php
  $catid = 0;
  $where = '';
  if(isset($_GET['category'])){
    $catid = $_GET['category'];
    $where = 'WHERE books.category_id = '.$catid;
  }

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Book List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Books</li>
        <li class="active">Book List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-danger btn-flat"><i class="fa fa-plus"></i>Add Books</a>
              <div class="box-tools pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label>Department: </label>
                    <select class="form-control input-sm" id="select_category">
                      <option value="0">ALL</option>
                      <?php
                        $sql = "SELECT * FROM category";
                        $query = $conn->query($sql);
                        while($catrow = $query->fetch_assoc()){
                          $selected = ($catid == $catrow['id']) ? " selected" : "";
                          echo "
                            <option value='".$catrow['id']."' ".$selected.">".$catrow['name']."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Department</th>
                  <th>Code</th>
                  <th>Course Title</th>
                  <th>Author</th>
                   <th>Title</th>
                   <th>Copyright Year</th>
                   <th>No.of Titles</th>
                   <th>No.of Volumes</th>
                   <th>Total No.of Titles</th>
                   <th>Total No.of Volumes</th>
                   <th>Total No.of Titles for the Past Five Years</th>
                  <th>Tools</th>

                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, books.id AS bookid FROM books LEFT JOIN category ON category.id=books.category_id $where";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                     
                      echo "
                        <tr>
                          <td>".$row['name']."</td>
                          <td>".$row['Code']."</td>
                          <td>".$row['Course_Title']."</td>
                          <td>".$row['Author']."</td>
                          <td>".$row['Title']."</td>
                          <td>".$row['Copyright_Year']."</td>
                          <td>".$row['No_of_Titles']."</td>
                          <td>".$row['No_of_Volumes']."</td>
                          <td>".$row['Total_No_of_Titles']."</td>
                          <td>".$row['Total_No_of_Volumes']."</td>
                          <td>".$row['Total_No_of_Titles_for_the_Past_Five_Years']."</td>
                          
                         
                      ";
                    }
                  ?>                          
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/book_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('#select_category').change(function(){
    var value = $(this).val();
    if(value == 0){
      window.location = 'book.php';
    }
    else{
      window.location = 'book.php?category='+value;
    }
  });

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'book_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.bookid').val(response.bookid);
      $('#edit_code').val(response.Code);
      $('#edit_course_title').val(response.Course_Title);
      $('#edit_category').val(response.category_id).html(response.name);
      $('#edit_author').val(response.Author);
      $('#edit_title').val(response.Title);
      $('#edit_copyright_year').val(response.Copyright_Year);
      $('#edit_no_of_titles').val(response.No_of_Titles);
      $('#edit_no_of_volumes').val(response.No_of_Volumes);
      $('#edit_total_no_of_titles').val(response.Total_No_of_Titles);
      $('#edit_total_no_of_volumes').val(response.oTtal_No_of_Volumes);
      $('#edit_total_no_of_titles_for_the_past_five_years').val(response.Total_No_of_Titles_for_the_Past_Five_Years);
      $('#del_book').html(response.Title);
    }
  });
}
</script>
</body>
</html>

 