<?php
$alternate = false;
?>
<div class="wrap">
    <h2><?php _e( 'Pageview Report', 'author-page-views' ); ?></h2>
    <p>
        <?php
        printf( __( 'From the creators of %1$s child themes for the %2$s.', 'author-page-views' ),
            '<a href="http://wpthe.com">\'' . __( 'The Series', 'author-page-views' ) . '\'</a>',
            '<a href = "http://www.shareasale.com/r.cfm?b=346198&u=583533&m=28169&urllink=&afftrack=">' . __( 'Genesis Framework', 'author-page-views' ). '</a>' );
        ?>
    </p>
    <p id="date-range">
        <form method="GET" action="">
            <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
            <label><?php _e( 'Show report from:', 'author-page-views' ); ?></label> <?php self::show_date_dropdown(self::get_date_begin(), 'begin' ); ?>
            <label><?php _e( 'To:', 'author-page-views' ); ?></label> <?php self::show_date_dropdown(self::get_date_end(), 'end' ); ?>
            <input type="submit" class="button" value="Filter" />
        </form>
    </p>
    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 40px">&nbsp;</th>
                <th><?php _e( 'Login', 'author-page-views' ); ?></th>
                <th><?php _e( 'Name', 'author-page-views' ); ?></th>
                <th><?php _e( 'Email', 'author-page-views' ); ?></th>
                <th><?php _e( 'Rate/Thousand', 'author-page-views' ); ?></th>
                <th><?php _e( 'View Count', 'author-page-views' ); ?></th>
                <th><?php _e( 'Payment', 'author-page-views' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width: 40px">&nbsp;</th>
                <th><?php _e( 'Login', 'author-page-views' ); ?></th>
                <th><?php _e( 'Name', 'author-page-views' ); ?></th>
                <th><?php _e( 'Email', 'author-page-views' ); ?></th>
                <th><?php _e( 'Rate/Thousand', 'author-page-views' ); ?></th>
                <th><?php _e( 'View Count', 'author-page-views' ); ?></th>
                <th><?php _e( 'Payment', 'author-page-views' ); ?></th>
            </tr>
        </tfoot>
        <?php foreach ( $author_reports as $author_id => $author_report ) : ?>
        <tr class="<?php echo ($alternate = !$alternate) ? 'alternate' : ''; ?>">
            <td style="width: 40px; padding-bottom: 5px"><?php echo get_avatar( $author_id, 32 ); ?></td>
            <td><a href="<?php echo admin_url( 'user-edit.php?user_id=' . $author_id ); ?>"><?php echo $author_report['login']; ?></a></td>
            <td><?php echo $author_report['name']; ?></td>
            <td><?php echo $author_report['email']; ?></td>
            <td><?php echo $currency . sprintf( '%.2f', $author_report['rate'] ); ?></td>
            <td><?php echo $author_report['count']; ?></td>
            <td><?php echo $currency . sprintf( '%.2f', $author_report['payment'] ); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <a href="<?php echo add_query_arg( 'export_csv', 1 ); ?>">Export CSV</a>
    </p>
</div>