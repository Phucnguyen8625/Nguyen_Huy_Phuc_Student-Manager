<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Manager_CPT {

	public function init() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
	}

	public function register_cpt() {
		$labels = array(
			'name'                  => _x( 'Sinh viên', 'Post type general name', 'student-manager' ),
			'singular_name'         => _x( 'Sinh viên', 'Post type singular name', 'student-manager' ),
			'menu_name'             => _x( 'Sinh viên', 'Admin Menu text', 'student-manager' ),
			'name_admin_bar'        => _x( 'Sinh viên', 'Add New on Toolbar', 'student-manager' ),
			'add_new'               => __( 'Thêm mới', 'student-manager' ),
			'add_new_item'          => __( 'Thêm sinh viên mới', 'student-manager' ),
			'new_item'              => __( 'Sinh viên mới', 'student-manager' ),
			'edit_item'             => __( 'Sửa sinh viên', 'student-manager' ),
			'view_item'             => __( 'Xem sinh viên', 'student-manager' ),
			'all_items'             => __( 'Tất cả sinh viên', 'student-manager' ),
			'search_items'          => __( 'Tìm kiếm sinh viên', 'student-manager' ),
			'parent_item_colon'     => __( 'Parent Sinh viên:', 'student-manager' ),
			'not_found'             => __( 'Không tìm thấy sinh viên nào.', 'student-manager' ),
			'not_found_in_trash'    => __( 'Không có sinh viên nào trong thùng rác.', 'student-manager' ),
			'featured_image'        => _x( 'Ảnh đại diện sinh viên', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'student-manager' ),
			'set_featured_image'    => _x( 'Đặt ảnh đại diện', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'student-manager' ),
			'remove_featured_image' => _x( 'Xóa ảnh đại diện', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'student-manager' ),
			'use_featured_image'    => _x( 'Sử dụng làm ảnh đại diện', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'student-manager' ),
			'archives'              => _x( 'Lưu trữ sinh viên', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'student-manager' ),
			'insert_into_item'      => _x( 'Chèn vào sinh viên', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'student-manager' ),
			'uploaded_to_this_item' => _x( 'Tải lên sinh viên này', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'student-manager' ),
			'filter_items_list'     => _x( 'Lọc danh sách sinh viên', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'student-manager' ),
			'items_list_navigation' => _x( 'Điều hướng danh sách sinh viên', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'student-manager' ),
			'items_list'            => _x( 'Danh sách sinh viên', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'student-manager' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'sinh-vien' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor' ),
		);

		register_post_type( 'sinh_vien', $args );
	}

	public function add_meta_boxes() {
		add_meta_box(
			'student_info_meta_box',
			__( 'Thông tin sinh viên', 'student-manager' ),
			array( $this, 'render_meta_box' ),
			'sinh_vien',
			'normal',
			'high'
		);
	}

	public function render_meta_box( $post ) {
		// Thêm nonce field để bảo mật
		wp_nonce_field( 'student_manager_save_meta_box_data', 'student_manager_meta_box_nonce' );

		// Lấy dữ liệu đã lưu nếu có
		$mssv       = get_post_meta( $post->ID, '_student_mssv', true );
		$department = get_post_meta( $post->ID, '_student_department', true );
		$dob        = get_post_meta( $post->ID, '_student_dob', true );

		?>
		<table class="form-table">
			<tr>
				<th><label for="student_mssv"><?php _e( 'Mã số sinh viên (MSSV)', 'student-manager' ); ?></label></th>
				<td>
					<input type="text" id="student_mssv" name="student_mssv" value="<?php echo esc_attr( $mssv ); ?>" class="regular-text" required />
				</td>
			</tr>
			<tr>
				<th><label for="student_department"><?php _e( 'Lớp/Chuyên ngành', 'student-manager' ); ?></label></th>
				<td>
					<select id="student_department" name="student_department" required>
						<option value="CNTT" <?php selected( $department, 'CNTT' ); ?>>Công nghệ thông tin</option>
						<option value="Kinh tế" <?php selected( $department, 'Kinh tế' ); ?>>Kinh tế</option>
						<option value="Marketing" <?php selected( $department, 'Marketing' ); ?>>Marketing</option>
						<option value="Khác" <?php selected( $department, 'Khác' ); ?>>Khác</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="student_dob"><?php _e( 'Ngày sinh', 'student-manager' ); ?></label></th>
				<td>
					<input type="date" id="student_dob" name="student_dob" value="<?php echo esc_attr( $dob ); ?>" required />
				</td>
			</tr>
		</table>
		<?php
	}

	public function save_meta_boxes( $post_id ) {
		// Kiểm tra nonce
		if ( ! isset( $_POST['student_manager_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['student_manager_meta_box_nonce'], 'student_manager_save_meta_box_data' ) ) {
			return;
		}

		// Kiểm tra autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Kiểm tra quyền của người dùng
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Lưu MSSV (Sanitize text field)
		if ( isset( $_POST['student_mssv'] ) ) {
			update_post_meta( $post_id, '_student_mssv', sanitize_text_field( $_POST['student_mssv'] ) );
		}

		// Lưu Chuyên ngành (Sanitize text field)
		if ( isset( $_POST['student_department'] ) ) {
			update_post_meta( $post_id, '_student_department', sanitize_text_field( $_POST['student_department'] ) );
		}

		// Lưu Ngày sinh (Sanitize text field vì date là chuỗi)
		if ( isset( $_POST['student_dob'] ) ) {
			update_post_meta( $post_id, '_student_dob', sanitize_text_field( $_POST['student_dob'] ) );
		}
	}
}
