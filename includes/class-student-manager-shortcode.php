<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Student_Manager_Shortcode {

	public function init() {
		add_shortcode( 'danh_sach_sinh_vien', array( $this, 'render_shortcode' ) );
	}

	public function render_shortcode( $atts ) {
		// Query danh sách sinh viên
		$args = array(
			'post_type'      => 'sinh_vien',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);
		$query = new WP_Query( $args );

		ob_start();

		if ( $query->have_posts() ) {
			?>
			<div class="student-manager-container">
				<table class="student-table">
					<thead>
						<tr>
							<th><?php _e( 'STT', 'student-manager' ); ?></th>
							<th><?php _e( 'MSSV', 'student-manager' ); ?></th>
							<th><?php _e( 'Họ tên', 'student-manager' ); ?></th>
							<th><?php _e( 'Lớp/Chuyên ngành', 'student-manager' ); ?></th>
							<th><?php _e( 'Ngày sinh', 'student-manager' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$stt = 1;
						while ( $query->have_posts() ) {
							$query->the_post();
							$mssv       = get_post_meta( get_the_ID(), '_student_mssv', true );
							$department = get_post_meta( get_the_ID(), '_student_department', true );
							$dob        = get_post_meta( get_the_ID(), '_student_dob', true );

							// Format date nếu có
							if ( ! empty( $dob ) ) {
								$dob = date_i18n( get_option( 'date_format' ), strtotime( $dob ) );
							}
							?>
							<tr>
								<td><?php echo esc_html( $stt ); ?></td>
								<td><?php echo esc_html( $mssv ); ?></td>
								<td><strong><?php the_title(); ?></strong></td>
								<td><?php echo esc_html( $department ); ?></td>
								<td><?php echo esc_html( $dob ); ?></td>
							</tr>
							<?php
							$stt++;
						}
						wp_reset_postdata();
						?>
					</tbody>
				</table>
			</div>
			<?php
		} else {
			echo '<p>' . __( 'Chưa có sinh viên nào.', 'student-manager' ) . '</p>';
		}

		return ob_get_clean();
	}
}
