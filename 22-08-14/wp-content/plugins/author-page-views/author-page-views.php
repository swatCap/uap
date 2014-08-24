<?php

/**
 * Plugin Name: Author Page Views
 * Description: Displays a page view count for each author, based on the pages that author has created
 * Plugin URI: http://wpthe.com/page-views/
 * Version: 1.0
 * Author: Will Anderson
 * Author URI: http://wpthe.com/
 */

class Author_Page_Views {

    const VERSION = '1.0';
    const VIEW_TABLE_NAME = 'post_views';
    const AUTHOR_RATE_KEY = 'rate_per_thousand';
    const CURRENCY = '$';
    const DROPDOWN_YEAR_START = '2000'; // If you really need to select date ranges before this, change this constant

    public static function start() {
        register_activation_hook( __FILE__, array( __CLASS__, 'install' ) );

        // Add the report page
        add_action( 'admin_menu', array( __CLASS__, 'add_menu_pages' ) );

        // Check for requests to increment view
        add_action( 'init', array( __CLASS__, 'increment_view' ) );

        // Add a stylesheet reference to the increment URL if viewing a single page
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'queue_increment_style' ) );

        // Check for a CSV export request
        add_action( 'admin_init', array( __CLASS__, 'maybe_export_csv' ) );

        // If a post's author is changed, update the author stats
        add_action( 'save_post', array( __CLASS__, 'update_post_author' ) );

        // Show individual author stats on author profile pages
        add_action( 'show_user_profile', array( __CLASS__, 'show_single_author_report' ) );
        add_action( 'edit_user_profile', array( __CLASS__, 'show_single_author_report' ) );

        // Save updated author rates
        add_action( 'personal_options_update', array( __CLASS__, 'update_author_rate' ) );
        add_action( 'edit_user_profile_update', array( __CLASS__, 'update_author_rate' ) );
    }

    public static function install() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::VIEW_TABLE_NAME;
        $sql = "CREATE TABLE `$table_name` (
          `view_id` bigint(20) NOT NULL AUTO_INCREMENT,
          `post_id` bigint(20) NOT NULL,
          `post_author` bigint(20) NOT NULL,
          `view_date` date NOT NULL,
          `view_count` int(11) NOT NULL,
          PRIMARY KEY (`view_id`),
          KEY `post_id` (`post_id`),
          KEY `post_author` (`post_author`),
          KEY `view_date` (`view_date`)
        );";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public static function add_menu_pages() {
        add_dashboard_page( __( 'Pageview Report', 'author-page-views' ), __( 'Pageview Report', 'author-page-views' ), 'edit_users', __FILE__, array( __CLASS__, 'report_page' ) );
    }

    public static function queue_increment_style() {
        global $post;
        // Only do something if viewing an individual page or post
        if ( is_single() || is_page() ) {
            wp_enqueue_style( 'author-page-views', add_query_arg( 'viewing-page', $post->ID, home_url() ) );
        }
    }

    public static function increment_view() {
        global $wpdb;
        /**
         * @var $wpdb wpdb
         */

        if ( isset( $_GET['viewing-page'] ) ) {
            $post_id = intval( $_GET['viewing-page'] );
            $post = get_post( $post_id );

            header( 'Content-type: text/css' );
            header( 'Cache-Control: no-cache' );

            $table_name = $wpdb->prefix . self::VIEW_TABLE_NAME;

            // Get the date/time for the beginning of the day for consistency
            $date = date( 'Y-m-d 0:0:0', current_time('timestamp') );

            // Check if a row for this post/day already exists
            $exists = intval( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(view_id) FROM $table_name WHERE post_id = %d and view_date = %s", $post_id, $date ) ) );

            if ( $exists ) {
                // If a row exists, increment it
                $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET view_count = view_count + 1 WHERE post_id = %d and view_date = %s", $post_id, $date ) );
            } else {
                // If a row doesn't exist, insert a new one
                $wpdb->insert( $table_name, array(
                    'post_id' => $post_id,
                    'post_author' => $post->post_author,
                    'view_date' => $date,
                    'view_count' => 1
                ), array( '%d', '%d', '%s', '%d' ) );
            }

            // Make sure nothing else (like caching) has a chance to run
            die();
        }



    }

    public static function update_post_author( $post_id ) {
        global $wpdb;

        /**
         * @var $wpdb wpdb
         */

        $post = get_post( $post_id );
        $post_author = $post->post_author;
        $table_name = $wpdb->prefix . self::VIEW_TABLE_NAME;
        $wpdb->query( $wpdb->prepare( "
        UPDATE `$table_name`
        SET post_author = %d
        WHERE post_id = %d", $post_author, $post_id ) );
    }

    public static function report_page() {
        $args = array();
        $args['date_begin'] = date( 'Y-m-d 0:0:0', self::get_date_begin() );
        $args['date_end'] = date( 'Y-m-d 0:0:0', self::get_date_end() );
        self::show_pageview_report( $args );
    }

    public static function get_date_begin() {
        if ( isset( $_GET['begin_month'] ) && isset( $_GET['begin_day'] ) && isset( $_GET['begin_year'] ) ) {
            $month  = intval( $_GET['begin_month'] );
            $day    = intval( $_GET['begin_day'] );
            $year   = intval( $_GET['begin_year'] );
            return mktime(0, 0, 0, $month, $day, $year );
        }
        return strtotime( '-1 month', self::get_date_end() );
    }

    public static function get_date_end() {
            if ( isset( $_GET['end_month'] ) && isset( $_GET['end_day'] ) && isset( $_GET['end_year'] ) ) {
                $month  = intval( $_GET['end_month'] );
                $day    = intval( $_GET['end_day'] );
                $year   = intval( $_GET['end_year'] );
            } else {
                $current_time = current_time( 'timestamp' );
                $month  = intval( date( 'm', $current_time ) );
                $day    = intval( date( 'd', $current_time ) );
                $year   = intval( date( 'Y', $current_time ) );
            }

            return mktime(0, 0, 0, $month, $day, $year );
        }

    public static function show_date_dropdown( $date, $prefix ) {
        $months = range( 1, 12 );
        $days   = range( 1, 31 );
        $years  = range( self::DROPDOWN_YEAR_START, intval( date( 'Y', $date ) ) + 1 );

        $date_month = date( 'm', $date );
        $date_day   = date( 'd', $date );
        $date_year  = date( 'Y', $date );

        include plugin_dir_path( __FILE__ ) . 'views/date-dropdown.php';
    }

    public static function show_pageview_report( $args = array() ) {

        $author_reports = self::get_author_reports( $args );
        $currency = self::CURRENCY;

        include plugin_dir_path( __FILE__ ) . 'views/admin-report.php';
    }

    public static function get_author_reports( $args = array() ) {
        global $wpdb;

        $table_name = $wpdb->prefix . self::VIEW_TABLE_NAME;

        $current_timestamp = current_time( 'timestamp' );

        $args = wp_parse_args( $args, array(
            'date_begin'    => self::get_date_end(),
            'date_end'      => self::get_date_end(),
            'author'        => null
        ) );

        if ( is_null( $args['date_begin'] ) ) {
            $current_day = mktime( 0, 0, 0, date( 'm', $current_timestamp), date( 'd', $current_timestamp ), date( 'Y', $current_timestamp ) );
            $args['date_begin'] = date( 'Y-m-d 0:0:0', strtotime( '-1 month', $current_day ) );
        }

        $user_args = array();
        if ( is_null( $args['author'] ) ) {
            $authors = get_users( $user_args );
        } else {
            $authors = array( get_userdata( intval( $args['author'] ) ) );
        }

        $author_reports = array();
        foreach ( $authors as $author ) {

            // Only get stats for non-subscribers
            if ( user_can( $author->ID, 'edit_posts' ) ) {
                $author_rate = floatval( get_user_meta( $author->ID, self::AUTHOR_RATE_KEY, true ) );

                $author_views = $wpdb->get_var( $wpdb->prepare( "
                SELECT IFNULL(SUM(view_count),0) FROM $table_name
                WHERE post_author = %d
                    AND view_date >= %s
                    AND view_date <= %s", $author->ID, $args['date_begin'], $args['date_end'] ) );
                $author_reports[$author->ID] = array(
                    'login'     => $author->user_login,
                    'email'     => $author->user_email,
                    'name'      => $author->display_name,
                    'count'     => $author_views,
                    'rate'      => $author_rate,
                    'payment'   => $author_rate * $author_views / 1000.0,
                );
            }
        }

        return $author_reports;
    }

    /**
     * Get the user ID of the profile being viewed
     * @static
     * @return int
     */
    public static function get_profile_user_id() {
        global $current_screen;
        if ( $current_screen->id == 'profile' ) {
            return get_current_user_id();
        } else {
            return intval( $_REQUEST['user_id'] );
        }
    }

    public static function show_single_author_report() {

        $author_id = self::get_profile_user_id();

        // Don't display this for anyone who
        if ( !user_can( $author_id, 'edit_posts' ) ) {
            return;
        }

        $author_rate = floatval( get_user_meta( $author_id, self::AUTHOR_RATE_KEY, true ) );

        $current_time = current_time( 'timestamp' );
        $current_month = mktime( 0, 0, 0, date( 'm', $current_time ), 1, date( 'Y', $current_time ) );

        // Show stats from last two months, plus current month
        $month_stats = array();
        for ( $i = 0; $i < 3; $i++ ) {
            $month = strtotime( "-$i month", $current_month );
            $year = date( 'Y', $month );
            $month_name = date( 'M', $month );
            $days_in_month = date( 't', $month );
            $date_begin = date( "Y-m-1 0:0:0", $month );
            $date_end = date( "Y-m-$days_in_month 0:0:0", $month );

            $report = self::get_author_reports( array(
                'date_begin' => $date_begin,
                'date_end' => $date_end,
                'author' => $author_id,
            ) );
            $month_stats[] = array( 'name' => $month_name, 'year' => $year, 'report' => $report[$author_id] );
        }

        include plugin_dir_path( __FILE__ ) . 'views/single-author-report.php';
    }

    public static function update_author_rate() {
        if ( current_user_can( 'edit_users' ) ) {
            $author_id = self::get_profile_user_id();
            update_user_meta( $author_id, self::AUTHOR_RATE_KEY, floatval( $_POST[self::AUTHOR_RATE_KEY] ) );
        }
    }

    public static function maybe_export_csv() {
        if ( isset( $_GET['page'] ) && plugin_basename( __FILE__) == $_GET['page'] && isset( $_GET['export_csv'] ) ) {
            $args = array(
                'date_begin' => date( 'Y-m-d 0:0:0', self::get_date_begin() ),
                'date_end' => date( 'Y-m-d 0:0:0', self::get_date_end() )
            );
            self::export_csv( $args );
        }
    }

    public static function export_csv( $args = array() ) {
        $author_reports = self::get_author_reports( $args );
        header( 'Content-type: text/csv' );
        header( 'Content-Disposition: attachment; filename=pageview-report-' . date( 'Y-m-d', current_time('timestamp') ) . '.csv' );
        $content = "User ID,Name,Login,Email,Rate/Thousand,View Count,Payment\n";
        foreach ( $author_reports as $author_id => $author_report ) {
            $content .= $author_id . ',' .
            '"' . str_replace( '"', '""', $author_report['name'] ) . '",' .
            '"' . str_replace( '"', '""', $author_report['login'] ) . '",' .
            '"' . str_replace( '"', '""', $author_report['email'] ) . '",' .
            '"' . str_replace( '"', '""', sprintf( '%.2f', $author_report['rate'] ) ) . '",' .
            '"' . str_replace( '"', '""', $author_report['count'] ) . '",' .
            '"' . str_replace( '"', '""', $author_report['payment'] ) . "\",\n";
        }
        echo $content;
        die();
    }
}

Author_Page_Views::start();