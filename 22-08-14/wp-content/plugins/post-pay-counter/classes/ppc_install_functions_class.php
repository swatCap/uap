<?php

/**
 * @author Stefano Ottolenghi
 * @copyright 2013
 */

class PPC_install_functions {
    
    /**
     * Walks through available blogs (maybe multisite) and calls the real install procedure
     *
     * @access  public
     * @since   2.0
     * @param   $network_wide bool whether network wide activation has been requested
    */
    
    function ppc_install( $network_wide ) {
        global $wpdb;
        
        if( $network_wide ) {
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM ".$wpdb->blogs );
			
            foreach( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::ppc_install_procedure();
			}
            
			restore_current_blog();
			return;
		} 
    	self::ppc_install_procedure();
    }
    
    /**
     * If plugin was activated with a network-wide activation, activate and install it on new blogs when they are created
     *
     * @access  public
     * @since   2.0
     * @param   $blog_id int the id of the newly created blog
     * @param   $user_id int the id of the newly created blog's admin
     * @param   $domain string the domain of the newly created blog's admin
     * @param   $path string the path of the newly created blog's admin
     * @param   $site_id int the site id (usually = 1)
     * @param   $meta array initial site options
    */
    
    function ppc_new_blog_install( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    	if( is_plugin_active_for_network( basename( dirname( dirname( __FILE__ ) ).'/post-pay-counter.php' ) ) ) {
    		switch_to_blog( $blog_id );
    		self::ppc_install_procedure();
    		restore_current_blog();
    	}
    }
    
    /**
     * Adds default settings, current version to the database and assigns default capabilities.
     *
     * @access  public
     * @since   2.0
    */
    
    static function ppc_install_procedure() {
        global $ppc_global_settings, $current_user;
        
        if( ! is_object( $current_user ) ) {
            get_currentuserinfo();
        }
        
        $default_settings = array(
            'general' => array( 
                'userid' => 'general',
                'basic_payment' => 1,
                'basic_payment_value' => 1.5,
                'counting_words' => 1,
                'counting_words_system_zonal' => 0,
                'counting_words_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_words_system_incremental' => 1,
                'counting_words_system_incremental_value' => 0.01,
                'counting_words_threshold_max' => 0,
                'counting_visits' => 0,
                'counting_visits_postmeta' => 1,
                'counting_visits_postmeta_value' => '',
                'counting_visits_system_zonal' => 0,
                'counting_visits_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_visits_system_incremental' => 1,
                'counting_visits_system_incremental_value' => 0.01,
                'counting_visits_threshold_max' => 0,
                'counting_images' => 1,
                'counting_images_system_zonal' => 0,
                'counting_images_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_images_system_incremental' => 1,
                'counting_images_system_incremental_value' => 0.2,
                'counting_images_threshold_min' => 2,
                'counting_images_threshold_max' => 10,
                'counting_images_include_featured' => 1,
                'counting_comments' => 1,
                'counting_comments_system_zonal' => 0,
                'counting_comments_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_comments_system_incremental' => 1,
                'counting_comments_system_incremental_value' => 0.2,
                'counting_comments_threshold_min' => 2,
                'counting_comments_threshold_max' => 10,
                'counting_payment_total_threshold' => 0,
                'counting_payment_only_when_total_threshold' => 0,
                'counting_allowed_post_statuses' => array(
                    'publish' => 1,
                    'future' => 1,
                    'pending' => 0,
                    'private' => 0
                ),
                'counting_exclude_quotations' => 1,
                'can_see_others_general_stats' => 1,
    			'can_see_others_detailed_stats' => 1,
    			'can_see_countings_special_settings' => 0,
                'can_see_options_user_roles' => array(
                    'administrator' => 'administrator'
                ),
                'can_see_stats_user_roles' => array(
                    'administrator' => 'administrator',
                    'editor' => 'editor',
                    'author' => 'author',
                    'contributor' => 'contributor'
                ),
                'counting_allowed_user_roles' => array(
                    'administrator' => 'administrator',
                    'editor' => 'editor',
                    'author' => 'author',
                    'contributor' => 'contributor'
                ),
                'counting_allowed_post_types' => array(
                    'post',
                    'page'
                ),
                'default_stats_time_range_month' => 1,
                'default_stats_time_range_week' => 0,
                'default_stats_time_range_custom' => 0,
                'default_stats_time_range_custom_value' => 100
            ),
            
            'admin' => array( 
                'userid' => $current_user->ID,
                'basic_payment' => 1,
                'basic_payment_value' => 1.5,
                'counting_words' => 1,
                'counting_words_system_zonal' => 0,
                'counting_words_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_words_system_incremental' => 1,
                'counting_words_system_incremental_value' => 0.01,
                'counting_words_threshold_max' => 0,
                'counting_visits' => 0,
                'counting_visits_postmeta' => 1,
                'counting_visits_postmeta_value' => '',
                'counting_visits_system_zonal' => 0,
                'counting_visits_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_visits_system_incremental' => 1,
                'counting_visits_system_incremental_value' => 0.01,
                'counting_visits_threshold_max' => 0,
                'counting_images' => 1,
                'counting_images_system_zonal' => 0,
                'counting_images_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_images_system_incremental' => 1,
                'counting_images_system_incremental_value' => 0.01,
                'counting_images_threshold_min' => 2,
                'counting_images_value' => 0.2,
                'counting_images_threshold_max' => 10,
                'counting_images_include_featured' => 1,
                'counting_comments' => 1,
                'counting_comments_system_zonal' => 0,
                'counting_comments_system_zonal_value' => array(
                    0 => array( 
                        'threshold' => 100,
                        'payment' => 1
                    ),
                    1 => array(
                        'threshold' => 200,
                        'payment' => 2
                    )
                ),
                'counting_comments_system_incremental' => 1,
                'counting_comments_system_incremental_value' => 0.01,
                'counting_comments_threshold_min' => 2,
                'counting_comments_value' => 0.2,
                'counting_comments_threshold_max' => 10,
                'counting_payment_total_threshold' => 0,
                'counting_payment_only_when_total_threshold' => 0,
                'counting_allowed_post_statuses' => array(
                    'publish' => 1,
                    'future' => 1,
                    'pending' => 0,
                    'private' => 0
                ),
                'counting_exclude_quotations' => 1,
                'can_see_others_general_stats' => 1,
    			'can_see_others_detailed_stats' => 1,
    			'can_see_countings_special_settings' => 1
            )
		);
        
		//Only add default settings if not there already
		$general_settings = PPC_general_functions::get_settings( 'general' );
        if( ! is_array( $general_settings ) ) {
			
			//Add option if not available, update it otherwise
            if( get_option( $ppc_global_settings['option_name'] ) === false ) {
                if( ! add_option( $ppc_global_settings['option_name'], $default_settings['general'], '', 'no' ) ) {
					$error = new PPC_Error( 'ppc_add_option_general_error', __( 'Could not add general settings option.', 'ppc' ), array( 
						'option_name' => $ppc_global_settings['option_name'], 
						'old_settings' => $general_settings,
						'default_settings' => $default_settings['general'] 
					) );
					trigger_error( $wp_error->get_error_message(), E_USER_ERROR );
				}
            } else {
                if( ! update_option( $ppc_global_settings['option_name'], $default_settings['general'] ) ) {
					$error = new PPC_Error( 'ppc_update_option_general_error', __( 'Could not update general settings option.', 'ppc' ), array( 
						'option_name' => $ppc_global_settings['option_name'], 
						'old_settings' => $general_settings,
						'default_settings' => $default_settings['general'] 
					) );
					trigger_error( $wp_error->get_error_message(), E_USER_ERROR );
				}
            }
        }
        
        //Grant current user all permissions by personalizing his user (if not already)
        $admin_settings = PPC_general_functions::get_settings( $current_user->ID );
        if( $admin_settings['userid'] == 'general' ) {
            update_user_option( $current_user->ID, $ppc_global_settings['option_name'], $default_settings['admin'] );
        }
        
        PPC_general_functions::manage_cap_allowed_user_roles_plugin_pages( $default_settings['general']['can_see_options_user_roles'], $default_settings['general']['can_see_stats_user_roles'] );
        
        update_option( 'ppc_current_version', $ppc_global_settings['newest_version'] );
    }
}
?>