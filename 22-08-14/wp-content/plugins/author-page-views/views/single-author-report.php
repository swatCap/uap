<h3><?php _e( 'Author Pageviews', 'author-page-views' ); ?></h3>
<table class="form-table">

        <tr>
                    <th><label for="<?php self::AUTHOR_RATE_KEY; ?>"><?php  _e( 'Rate', 'author-page-views' ); ?></label></th>
                    <td>
                        <?php if ( current_user_can( 'edit_users' ) ) { ?>
                            <?php echo self::CURRENCY; ?>
                            <input type="text" name="<?php echo self::AUTHOR_RATE_KEY; ?>" id="<?php echo self::AUTHOR_RATE_KEY; ?>" value="<?php printf( '%.2f', $author_rate ); ?>" />
                            <span class="description"><?php _e( 'per thousand pageviews', 'author-page-views' ); ?></span>
                        <?php } else { ?>
                                <?php printf( __( '%s%.2f per thousand pageviews', 'author-page-views' ), self::CURRENCY, $author_rate ); ?></span>
                        <?php } ?>
                    </td>
                </tr>
    <tr>
        <?php foreach ( $month_stats as $month ) { ?>
            <tr>
                <th><?php echo $month['name'] . ', ' . $month['year']; ?></th>
                <td>
                    <?php printf( '%d', $month['report']['count'] ); ?>
                    <?php if ( date( 'M', current_time( 'timestamp' ) ) == $month['name'] ) { ?>
                        <span class="description"><?php printf( ' (%s%.2f)', self::CURRENCY, $month['report']['payment'] ); ?></span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tr>
</table>