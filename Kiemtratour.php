<?php
/**
Template Name: Kiem Tra Lien He
 */

if(flatsome_option('pages_template') != 'default') {

	// Get default template from theme options.
	get_template_part('page', flatsome_option('pages_template'));
	return;

} else {

get_header();
do_action( 'flatsome_before_page' ); ?>
<div id="content" class="content-area page-wrapper" role="main">
	<div class="row row-main">
		<div class="large-12 col">
			<div class="col-inner">

				<?php if(get_theme_mod('default_title', 0)){ ?>
				<header class="entry-header">
					<h1 class="entry-title mb uppercase"><?php the_title(); ?></h1>
				</header>
				<?php } ?>

				<div class="container-lg">
                  <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-8"><h2>Kiểm Tra <b>Tour</b></h2></div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Thêm dòng</button>
                                </div>
                            </div>
                        </div>
                      	<form method="get">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" required="">
                            <input type="submit" value="Nhập">
                        </form>
                      	<table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Stt</th>
                              <th>Tên</th>
                              <th>Email</th>
                              <th>Tour muốn đăng ký</th>
                              <th>Số điện thoại</th>
                              <th>Thời gian khởi hành dự kiến</th>
                              <th>Trang thái (checked = đã duyệt)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                if(isset($_GET['phone'])) {
                                  global $wpdb;
                                  $phone = $_GET['phone'];
                                  // Select all data from the table
                                  $results = $wpdb->get_results("SELECT * FROM DANGKYTOUR WHERE phone like '%$phone%'", ARRAY_A);

                                  // Check if there are any results
                                  if ($results)
                                  {
                                    $index = 1;
                                    // Loop through each row of results
                                    foreach ($results as $row) {
                            ?>
                                      <tr>
                                        <td><?php echo $index ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['message']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td disabled><?php echo $row['thoigiankhoihanh']; ?></td>
                                        <?php if ($row['trangthai'] == 0) { ?>
                                        	<td><input type="checkbox" id="checkbox1" name="trangthai[]" value="0" disabled>
</td>
                                        <?php } else if ($row['trangthai'] == 1) { ?>
                                        	<td><input type="checkbox" id="checkbox2" name="trangthai[]" value="1" checked disabled>
</td>
                                        <?php } ?>
                                      </tr>

                            <?php
                                      $index++;
                                    }
                                  } else {
                                    echo "No data found in the table.";
                                  }
                                }
                            ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
              	</div>
              
			</div>
		</div>
	</div>
</div>

<?php
do_action( 'flatsome_after_page' );
get_footer();

}

?>