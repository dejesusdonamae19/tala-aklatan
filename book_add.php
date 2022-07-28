<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$code = $_POST['code'];
		$course_title = $_POST['course_title'];
		$category = $_POST['category'];
		$author = $_POST['author'];
		$title = $_POST['title'];
		$copyright_year = $_POST['copyright_year'];
		$no_of_titles = $_POST['no_of_titles'];
		$no_of_volumes = $_POST['no_of_volumes'];
		$total_no_of_titles = $_POST['total_no_of_titles'];
		$total_no_of_volumes = $_POST['total_no_of_volumes'];
		$total_no_of_titles_for_the_past_five_years = $_POST['total_no_of_titles_for_the_past_five_years'];




		$sql = "INSERT INTO books (Code, Category_id, Course_Title, Author, Title, Copyright_Year, No_of_Titles, No_of_Volumes, Total_No_of_Titles, Total_No_of_Volumes, Total_No_of_Titles_for_the_Past_Five_Years) VALUES ('$code', '$category', '$course_title', '$author', '$title', $copyright_year, $no_of_titles, $no_of_volumes, $total_no_of_titles, $total_no_of_volumes, $total_no_of_titles_for_the_past_five_years)";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Book added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: book.php');

?>