<?php

if ( ! function_exists( 'eltdf_lms_map_lesson_meta' ) ) {
	function eltdf_lms_map_lesson_meta() {
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'lesson',
				'name'  => 'lesson_settings_meta_box',
				'title' => esc_html__( 'Lesson Settings', 'eltdf-lms' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Lesson Description', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for lesson', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Lesson Duration', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for lesson', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_lesson_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Lesson Duration Parameter', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose parameter for lesson duration', 'eltdf-lms' ),
				'default_value' => 'minutes',
				'parent'        => $meta_box,
				'options'       => array(
					''        => esc_html__( 'Default', 'eltdf-lms' ),
					'minutes' => esc_html__( 'Minutes', 'eltdf-lms' ),
					'hours'   => esc_html__( 'Hours', 'eltdf-lms' ),
					'days'    => esc_html__( 'Days', 'eltdf-lms' ),
					'weeks'   => esc_html__( 'Weeks', 'eltdf-lms' ),
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_lesson_free_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Free Lesson', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will set lesson to be free', 'eltdf-lms' ),
				'parent'        => $meta_box,
				'options'       => esmarts_elated_get_yes_no_select_array()
			)
		);
		
		esmarts_elated_add_meta_box_field( array(
			'name'        => 'eltdf_lesson_post_message_meta',
			'type'        => 'textarea',
			'label'       => esc_html__( 'Lesson Post Message', 'eltdf-lms' ),
			'description' => esc_html__( 'Set message that will be displayed after the lesson is completed', 'eltdf-lms' ),
			'parent'      => $meta_box,
			'args'        => array(
				'col_width' => 3
			)
		) );
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_lesson_type_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Lesson Type', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose desired lesson type', 'eltdf-lms' ),
				'parent'        => $meta_box,
				'options'       => array(
					'reading' => esc_html__( 'Reading', 'eltdf-lms' ),
					'video'   => esc_html__( 'Video', 'eltdf-lms' ),
					'audio'   => esc_html__( 'Audio', 'eltdf-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'reading' => '#eltdf_eltdf_video_container, #eltdf_eltdf_audio_container',
						'video'   => '#eltdf_eltdf_audio_container',
						'audio'   => '#eltdf_eltdf_video_container'
					),
					'show'       => array(
						'reading' => '',
						'video'   => '#eltdf_eltdf_video_container',
						'audio'   => '#eltdf_eltdf_audio_container'
					)
				)
			)
		);
		
		//VIDEO TYPE
		$eltdf_video_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'eltdf_video_container',
				'hidden_property' => 'eltdf_lesson_type_meta',
				'hidden_value'    => array( 'reading, audio' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_lesson_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose video type', 'eltdf-lms' ),
				'parent'        => $eltdf_video_container,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'eltdf-lms' ),
					'self'            => esc_html__( 'Self Hosted', 'eltdf-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#eltdf_eltdf_video_self_hosted_container',
						'self'            => '#eltdf_eltdf_video_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#eltdf_eltdf_video_embedded_container',
						'self'            => '#eltdf_eltdf_video_self_hosted_container'
					)
				)
			)
		);
		
		$eltdf_video_embedded_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $eltdf_video_container,
				'name'            => 'eltdf_video_embedded_container',
				'hidden_property' => 'eltdf_lesson_video_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$eltdf_video_self_hosted_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $eltdf_video_container,
				'name'            => 'eltdf_video_self_hosted_container',
				'hidden_property' => 'eltdf_lesson_video_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter Video URL', 'eltdf-lms' ),
				'parent'      => $eltdf_video_embedded_container,
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'eltdf-lms' ),
				'parent'      => $eltdf_video_self_hosted_container,
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter video image', 'eltdf-lms' ),
				'parent'      => $eltdf_video_self_hosted_container,
			)
		);
		
		//AUDIO TYPE
		$eltdf_audio_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'eltdf_audio_container',
				'hidden_property' => 'eltdf_lesson_type_meta',
				'hidden_value'    => array( 'reading, video' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_lesson_audio_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Audio Type', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose audio type', 'eltdf-lms' ),
				'parent'        => $eltdf_audio_container,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Audio Service', 'eltdf-lms' ),
					'self'            => esc_html__( 'Self Hosted', 'eltdf-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#eltdf_eltdf_audio_self_hosted_container',
						'self'            => '#eltdf_eltdf_audio_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#eltdf_eltdf_audio_embedded_container',
						'self'            => '#eltdf_eltdf_audio_self_hosted_container'
					)
				)
			)
		);
		
		$eltdf_audio_embedded_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $eltdf_audio_container,
				'name'            => 'eltdf_audio_embedded_container',
				'hidden_property' => 'eltdf_lesson_audio_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$eltdf_audio_self_hosted_container = esmarts_elated_add_admin_container(
			array(
				'parent'          => $eltdf_audio_container,
				'name'            => 'eltdf_audio_self_hosted_container',
				'hidden_property' => 'eltdf_lesson_audio_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio URL', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter audio URL', 'eltdf-lms' ),
				'parent'      => $eltdf_audio_embedded_container,
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_lesson_audio_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio Link', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter audio link', 'eltdf-lms' ),
				'parent'      => $eltdf_audio_self_hosted_container,
			)
		);
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_lesson_meta', 5 );
}