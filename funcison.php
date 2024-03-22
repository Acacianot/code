<?php
function kiemTraEmail($table_name, $email) {
	global $wpdb;
	
	// Select all data from the table
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE email like '%$email'", ARRAY_A);

	// Check if there are any results
	
	if ($results)
	{
		// Loop through each row of results
		foreach ($results as $row) {
			// Access individual columns using associative array keys
			echo "Phone 1: " . $row['phone'] . "<br>";
			echo "Name 2: " . $row['name'] . "<br>";
			echo "Email 3: " . $row['email'] . "<br>";
			echo "Content: " . $row['message'] . "<br>";
			echo "Content: " . $row['thoigiankhoihanh'] . "<br>";
			// Add more columns as needed
			echo "<br>";
		}
	} else {
		echo "No data found in the table.";
	}
	
	
	return $results;
}

function layDuLieu($table_name) {
	global $wpdb;
	
	// Select all data from the table
	$results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

	// Check if there are any results
	/*
	if ($results)
	{
		// Loop through each row of results
		foreach ($results as $row) {
			// Access individual columns using associative array keys
			echo "Name 1: " . $row['name'] . "<br>";
			echo "Email 2: " . $row['email'] . "<br>";
			echo "Content: " . $row['message'] . "<br>";
			// Add more columns as needed
			echo "<br>";
		}
	} else {
		echo "No data found in the table.";
	}
	*/
	
	return $results;
}

function themDuLieu($table_name, $params) {
	global $wpdb;
	
	$query = "INSERT INTO {$table_name}(phone, name, email, message, thoigiankhoihanh) VALUES('{$params['phone']}','{$params['name']}','{$params['email']}','{$params['message']}','{$params['thoigiankhoihanh']}')"; 
	echo 'Insert query: ' . $query;
	
	if($wpdb->query($query)){
		return true;
	} else {
		return false;
	}
}

if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['my_form'])) {
	// Add code to save the form data to the database
  	global $wpdb;
	
	/*create table if not exists*/
    $table_name = 'DANGKYTOUR';

    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
	$phone = $_POST["phone"];
	$name = $_POST["name"];
	$email =$_POST["email"];
	$message =$_POST["message"];
	$thoigiankhoihanh =$_POST['thoigiankhoihanh'];
    $params = $_POST;
		
	$queryResult = themDuLieu($table_name, $params);
	if($queryResult) {
		layDuLieu($table_name);
		header ("Location: https://qduy.cnttq12.com/da-nhap-du-lieu-thanh-cong/");
	} else {
	header ("Location: https://qduy.cnttq12.com/nhap-du-lieu-that-bai/");
	}
	
	exit;
} 

if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['form_kt'])) {
	global $wpdb;
	
	/*kiem tra so dien thoai ton tai*/ 
	$table_name = 'DANGKYTOUR';
	$email = $_POST['email'];
	kiemTraEmail($table_name, $email);
	/*
	//$query = "Select * From {$table_name} where email = '{$params['email']}')";
	
	$results = $wpdb->get_results("Select * from {$table_name} where email = '{$_POST['email']}'", ARRAY_A);
	
	if(count($results) != 1) {
		echo "Email khong ton tai!";
	} else {
		echo "Name: " . $results[0]['name'] . "<br>";
		echo "Email: " . $results[0]['email'] . "<br>"; 
		echo "Content: " . $results[0]['message'] . "<br>";
	}
	*/
	exit;
}

if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['layDanhSachLienHe'])) {
	$table_name = 'DANGKYTOUR';
	$arr_lienhe = layDuLieu($table_name);
	
	if ($arr_lienhe)
	{
		// Loop through each row of results
		foreach ($arr_lienhe as $row) {
			// Access individual columns using associative array keys
			echo "phone: " . $row['phone'] . "<br>";
			echo "Name: " . $row['name'] . "<br>";
			echo "Email: " . $row['email'] . "<br>";
			echo "Content: " . $row['message'] . "<br>";
			echo "Content: " . $row['thoigiankhoihanh'] . "<br>";
			// Add more columns as needed
			echo "<br>";
		}
	}
	exit;
	
}

if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['frmQuanLy'])) {
	global $wpdb;
	
	$table_name = 'DANGKYTOUR';
	$totalRows = $_POST["totalRow"];
	
	for($index = 1; $index <= $totalRows; $index++) {
		$phone = $_POST['row'.$index.'_phone'];
		$name = $_POST['row'.$index.'_name'];
		$email = $_POST['row'.$index.'_email'];
		$message = $_POST['row'.$index.'_message'];
		$thoigiandukien = $_POST['row'.$index.'thoigiankhoihanh'];
		$trangthai = 0;
		
		if(isset($_POST['row'.$index.'_trangthai'])){
			$trangthai = 1;
		}
			
		$sqlUpdate = "UPDATE {$table_name} SET name = '{$name}', email = '{$email}', message = '{$message}', thoigiankhoihanh = '{$thoigiankhoihanh}', trangthai = {$trangthai} WHERE phone = '{$phone}'";
		$wpdb->query($sqlUpdate);
	}
	
 	header ("Location: https://qduy.cnttq12.com/quan-ly-lien-he/");
	exit;
}





function on_data_save($data) {

  // Kiểm tra dữ liệu đầu vào
  if (empty($data) || !is_array($data)) {
    return false;
  }

  // Lấy tên bảng từ dữ liệu
  $table_name = $data['DANGKYTOUR'];

  // Xử lý dữ liệu
  $data_to_save = array();
  foreach ($data as $key => $value) {
    if ($key != 'DANGKYTOUR') {
      $data_to_save[$key] = sanitize_text_field($value);
    }
  }

  // Chuẩn bị truy vấn SQL
  $sql = "INSERT INTO $table_name (";
  $columns = array();
  $values = array();
  foreach ($data_to_save as $key => $value) {
    $columns[] = $key;
    $values[] = "'$value'";
  }
  $sql .= implode('stt, phone, email, name, message, thoigiankhoihanh trangthai', $columns) . ") VALUES (" . implode('stt, phone, email, name, message, thoigiankhoihanh,  trangthai ', $values) . ")";

  // Thực thi truy vấn
  global $wpdb;
  $wpdb->query($sql);

  // Kiểm tra kết quả
  if ($wpdb->last_error) {
    return false;
  } else {
    // Gọi function để xử lý event
    do_action('on_data_saved', $data);
    return true;
  }
}
?>