<?php

if ( ! function_exists( 'eltdf_lms_rating_posts_types' ) ) {
	function eltdf_lms_rating_posts_types() {
		$post_types = apply_filters( 'eltdf_lms_rating_post_types', array() );
		
		return $post_types;
	}
}

if ( ! function_exists( 'eltdf_lms_comment_additional_title_field' ) ) {
	function eltdf_lms_comment_additional_title_field( $textarea ) {
		$post_types = eltdf_lms_rating_posts_types();
		
		if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
			foreach ( $post_types as $post_type ) {
				if ( is_singular( $post_type ) ) {
					$textarea = eltdf_lms_get_module_template_part( 'reviews/templates/title-field' );
					$textarea .= eltdf_lms_get_module_template_part( 'reviews/templates/text-field' );
					$textarea .= eltdf_lms_get_module_template_part( 'reviews/templates/stars-field' );
				}
			}
		}
		
		return $textarea;
	}
	
	add_filter( 'esmarts_elated_filter_comment_form_textarea_field', 'eltdf_lms_comment_additional_title_field', 10, 1 );
}

if ( ! function_exists( 'eltdf_lms_extend_comment_edit_metafields' ) ) {
	function eltdf_lms_extend_comment_edit_metafields( $comment_id ) {
		if ( ( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) ) {
			return;
		}
		
		if ( ( isset( $_POST['eltdf_comment_title'] ) ) && ( $_POST['eltdf_comment_title'] != '' ) ):
			$title = wp_filter_nohtml_kses( $_POST['eltdf_comment_title'] );
			update_comment_meta( $comment_id, 'eltdf_comment_title', $title );
		else :
			delete_comment_meta( $comment_id, 'eltdf_comment_title' );
		endif;
		
		if ( ( isset( $_POST['eltdf_rating'] ) ) && ( $_POST['eltdf_rating'] != '' ) ):
			$rating = wp_filter_nohtml_kses( $_POST['eltdf_rating'] );
			update_comment_meta( $comment_id, 'eltdf_rating', $rating );
		else :
			delete_comment_meta( $comment_id, 'eltdf_rating' );
		endif;
	}
	
	add_action( 'edit_comment', 'eltdf_lms_extend_comment_edit_metafields' );
}

if ( ! function_exists( 'eltdf_lms_extend_comment_add_meta_box' ) ) {
	function eltdf_lms_extend_comment_add_meta_box() {
		add_meta_box( 'title', esc_html__( 'Comment - Reviews', 'eltdf-lms' ), 'eltdf_lms_extend_comment_meta_box', 'comment', 'normal', 'high' );
	}
	
	add_action( 'add_meta_boxes_comment', 'eltdf_lms_extend_comment_add_meta_box' );
}

if ( ! function_exists( 'eltdf_lms_extend_comment_meta_box' ) ) {
	function eltdf_lms_extend_comment_meta_box( $comment ) {
		$post_types = eltdf_lms_rating_posts_types();
		
		if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
			foreach ( $post_types as $post_type ) {
				if ( $comment->post_type == $post_type ) {
					$title  = get_comment_meta( $comment->comment_ID, 'eltdf_comment_title', true );
					$rating = get_comment_meta( $comment->comment_ID, 'eltdf_rating', true );
					wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
					?>
					<p>
						<label for="title"><?php esc_html_e( 'Comment Title', 'eltdf-lms' ); ?></label>
						<input type="text" name="eltdf_comment_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
					</p>
					<p>
						<label for="rating"><?php esc_html_e( 'Rating', 'eltdf-lms' ); ?>: </label>
						<span class="commentratingbox">
							<?php
							for ( $i = 1; $i <= 5; $i ++ ) {
								echo '<span class="commentrating"><input type="radio" name="eltdf_rating" id="rating" value="' . $i . '"';
								if ( $rating == $i ) { echo ' checked="checked"'; }
								echo ' />' . $i . ' </span>';
							}
							?>
						</span>
					</p>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'eltdf_lms_save_comment_meta_data' ) ) {
	function eltdf_lms_save_comment_meta_data( $comment_id ) {
		
		if ( ( isset( $_POST['eltdf_comment_title'] ) ) && ( $_POST['eltdf_comment_title'] != '' ) ) {
			$title = wp_filter_nohtml_kses( $_POST['eltdf_comment_title'] );
			add_comment_meta( $comment_id, 'eltdf_comment_title', $title );
		}
		
		if ( ( isset( $_POST['eltdf_rating'] ) ) && ( $_POST['eltdf_rating'] != '' ) ) {
			$rating = wp_filter_nohtml_kses( $_POST['eltdf_rating'] );
			add_comment_meta( $comment_id, 'eltdf_rating', $rating );
		}
	}
	
	add_action( 'comment_post', 'eltdf_lms_save_comment_meta_data' );
}

if ( ! function_exists( 'eltdf_lms_verify_comment_meta_data' ) ) {
	function eltdf_lms_verify_comment_meta_data( $commentdata ) {
		$post_types = eltdf_lms_rating_posts_types();
		
		if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
			foreach ( $post_types as $post_type ) {
				if ( is_singular( $post_type ) ) {
					if ( ! isset( $_POST['eltdf_rating'] ) ) {
						wp_die( esc_html__( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.', 'eltdf-lms' ) );
					}
				}
			}
		}
		
		return $commentdata;
	}
	
	add_filter( 'preprocess_comment', 'eltdf_lms_verify_comment_meta_data' );
}

if ( ! function_exists( 'eltdf_lms_override_comments_callback' ) ) {
	function eltdf_lms_override_comments_callback( $args ) {
		$post_types = eltdf_lms_rating_posts_types();
		
		if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
			foreach ( $post_types as $post_type ) {
				if ( is_singular( $post_type ) ) {
					$args['callback'] = 'eltdf_lms_reviews';
				}
			}
		}
		
		return $args;
	}
	
	add_filter( 'esmarts_elated_filter_comments_callback', 'eltdf_lms_override_comments_callback' );
}

if ( ! function_exists( 'eltdf_lms_reviews' ) ) {
	function eltdf_lms_reviews( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		global $post;
		
		$is_pingback_comment = $comment->comment_type == 'pingback';
		$is_author_comment   = $post->post_author == $comment->user_id;
		
		$comment_class = 'eltdf-comment clearfix';
		
		if ( $is_author_comment ) {
			$comment_class .= ' eltdf-post-author-comment';
		}
		$review_rating = get_comment_meta( $comment->comment_ID, 'eltdf_rating', true );
		$review_title  = get_comment_meta( $comment->comment_ID, 'eltdf_comment_title', true );
		?>
		<li>
		<div class="<?php echo esc_attr( $comment_class ); ?>">
			<?php if ( ! $is_pingback_comment ) { ?>
				<div class="eltdf-comment-image"> <?php echo esmarts_elated_kses_img( get_avatar( $comment, 'thumbnail' ) ); ?> </div>
			<?php } ?>
			<div class="eltdf-comment-text">
				<div class="eltdf-comment-info">
					<h5 class="eltdf-comment-name vcard">
						<?php echo wp_kses_post( get_comment_author_link() ); ?>
					</h5>
					<div class="eltdf-review-rating">
						<span class="eltdf-rating-inner">
							<?php for ( $i = 1; $i <= $review_rating; $i ++ ) { ?>
								<i class="fa fa-star" aria-hidden="true"></i>
							<?php } ?>
						</span>
					</div>
				</div>
				<?php if ( ! $is_pingback_comment ) { ?>
					<div class="eltdf-text-holder" id="comment-<?php comment_ID(); ?>">
						<div class="eltdf-review-title">
							<span><?php echo esc_html( $review_title ); ?></span>
						</div>
						<?php comment_text(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php //li tag will be closed by WordPress after looping through child elements ?>
		<?php
	}
}