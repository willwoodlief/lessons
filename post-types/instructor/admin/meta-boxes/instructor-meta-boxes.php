<?php

if ( ! function_exists( 'eltdf_lms_map_instructor_single_meta' ) ) {
	function eltdf_lms_map_instructor_single_meta() {
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'instructor',
				'title' => esc_html__( 'Instructor Info', 'eltdf-lms' ),
				'name'  => 'instructor_meta'
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_instructor_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Instructor List Image', 'eltdf-lms' ),
				'description' => esc_html__( 'Choose an Image for displaying in instructor list. If not uploaded, featured image will be shown.', 'eltdf-lms' ),
				'parent'      => $meta_box
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_instructor_title',
				'type'        => 'text',
				'label'       => esc_html__( 'Title', 'eltdf-lms' ),
				'description' => esc_html__( 'The members\'s title', 'eltdf-lms' ),
				'parent'      => $meta_box
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_instructor_vita',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Brief Vita', 'eltdf-lms' ),
				'description' => esc_html__( 'The members\'s brief vita', 'eltdf-lms' ),
				'parent'      => $meta_box
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_instructor_email',
				'type'        => 'text',
				'label'       => esc_html__( 'Email', 'eltdf-lms' ),
				'description' => esc_html__( 'The members\'s email', 'eltdf-lms' ),
				'parent'      => $meta_box
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_instructor_resume',
				'type'        => 'file',
				'label'       => esc_html__( 'Resume', 'eltdf-lms' ),
				'description' => esc_html__( 'Upload members\'s resume', 'eltdf-lms' ),
				'parent'      => $meta_box
			)
		);
		
		for ( $x = 1; $x < 6; $x ++ ) {
			$social_icon_group = esmarts_elated_add_admin_group(
				array(
					'name'   => 'eltdf_instructor_social_icon_group' . $x,
					'title'  => esc_html__( 'Social Link ', 'eltdf-lms' ) . $x,
					'parent' => $meta_box
				)
			);
			
			$social_row1 = esmarts_elated_add_admin_row(
				array(
					'name'   => 'eltdf_instructor_social_icon_row1' . $x,
					'parent' => $social_icon_group
				)
			);
			
			eSmartsElatedClassIconCollections::get_instance()->getIconsMetaBoxOrOption(
				array(
					'label'            => esc_html__( 'Icon ', 'eltdf-lms' ) . $x,
					'parent'           => $social_row1,
					'name'             => 'eltdf_instructor_social_icon_pack_' . $x,
					'defaul_icon_pack' => '',
					'type'             => 'meta-box',
					'field_type'       => 'simple'
				)
			);
			
			$social_row2 = esmarts_elated_add_admin_row(
				array(
					'name'   => 'eltdf_instructor_social_icon_row2' . $x,
					'parent' => $social_icon_group
				)
			);
			
			esmarts_elated_add_meta_box_field(
				array(
					'type'            => 'textsimple',
					'label'           => esc_html__( 'Link', 'eltdf-lms' ),
					'name'            => 'eltdf_instructor_social_icon_' . $x . '_link',
					'hidden_property' => 'eltdf_instructor_social_icon_pack_' . $x,
					'hidden_value'    => '',
					'parent'          => $social_row2
				)
			);
			
			esmarts_elated_add_meta_box_field(
				array(
					'type'            => 'selectsimple',
					'label'           => esc_html__( 'Target', 'eltdf-lms' ),
					'name'            => 'eltdf_instructor_social_icon_' . $x . '_target',
					'options'         => esmarts_elated_get_link_target_array(),
					'hidden_property' => 'eltdf_instructor_social_icon_' . $x . '_link',
					'hidden_value'    => '',
					'parent'          => $social_row2
				)
			);
		}
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_instructor_single_meta', 46 );
}