<?php
/**
Template Name: Manage Lien He
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
                                <div class="col-sm-8"><h2>Employee <b>Details</b></h2></div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  	<th>Stt</th>
                                  	<th>Số Điện Thoại</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Tour muốn đăng ký</th>
                                  <th>Thời Gian Khởi Hành Dự Kiến</th>
                                    <th>Trạng Thái (checked là duyệt)</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                              	<form method="post">
                                  <input type="hidden" name="frmQuanLy" value="frmQuanLy" />
                              	<?php
                                global $wpdb;
                                // Select all data from the table
                                $results = $wpdb->get_results("SELECT * FROM DANGKYTOUR", ARRAY_A);

                                // Check if there are any results
                                if ($results)
                                {
                                  	$index = 1;
                                    // Loop through each row of results
                                    foreach ($results as $row) {
                                ?>
                              	<tr>
                                  	<td><?php echo $index ?></td>
                                  	<input name="<?php echo "row".$index."_phone"; ?>" value="<?php echo $row['phone']; ?>" type="hidden" />
                                  	<td><?php echo $row['phone']; ?></td>
                                    <td><input name="<?php echo "row".$index."_name"; ?>" type="text" value="<?php echo $row['name']; ?>" /></td>
                                    <td><input name="<?php echo "row".$index."_email"; ?>" type="text" value="<?php echo $row['email']; ?>" /></td>
                                    <td><input name="<?php echo "row".$index."_message"; ?>" type="text" value="<?php echo $row['message']; ?>" /></td>
                                    <td><input name="<?php echo "row".$index."_thoigiankhoihanh";?>" type="date" value="<?php echo $row['thoigiankhoihanh'];?>" /></td>
                                  	<td>
                                      <?php if($row['trangthai'] == 0) { ?>
                                      	<input type="checkbox" name="<?php echo "row".$index."_trangthai"; ?>" value="0" />
                                      <?php } else { ?>
										<input type="checkbox" name="<?php echo "row".$index."_trangthai"; ?>" value="1" checked />
                                      <?php } ?>
                                  	</td>
                                </tr>
                              	<?php
                                      $index++;
                                    }
                                ?>
                                  <input type="hidden" name="totalRow" value="<?php echo --$index; ?>" />
                                <?php
                                } else {
                                    echo "No data found in the table.";
                                }
                                ?>
                                 <tr>
                                  	<td></td>
                                  	<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="submit" type="submit" title="submit" style="border: 2px solid #007bff; border-radius: 5px;">Lưu dữ liệu</button>
                                    </td>
                                </tr>
                              </form>
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