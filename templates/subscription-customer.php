<?php
/*
 * Template Name: Subscription Customer
 */

get_header();
// Get all customer orders
$currentPage = get_query_var('page');
$aArgs       = [
  'limit'   => 10,
  'orderby' => 'date',
  'order'   => 'DESC',
  'return'  => 'ids',
  'status'  => ['processing', 'completed'],
  'paged'   => $currentPage
];

if (isset($_GET['customer'])) {
    $oFindUser = get_user_by('login', sanitize_text_field($_GET['customer']));
    if (!is_wp_error($oFindUser)) {
        $aArgs['customer'] = $oFindUser->user_email;
    } else {
        $aArgs['customer'] = sanitize_text_field($_GET['customer']);
    }
}

$query   = new WC_Order_Query($aArgs);
$aOrders = $query->get_orders();
$total   = wc_orders_count('processing') + wc_orders_count('completed');

if ($total <= 10) {
    $pages = 0;
} else {
    $pages = ceil($total / 10);
}

?>
    <div id="content" class="site-content" style="max-width: 1400px; margin: 0 auto; margin-top: 40px;
    margin-bottom: 40px">
        <div class="ui category search">
            <form action="<?php the_permalink(); ?>">
                <div class="ui icon input">
                    <input class="prompt" type="text" name="customer" placeholder="Search customer...">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </form>
        </div>
        <?php
        if (empty($aOrders)) :
            echo 'There is no order yet';
        else: ?>
            <div>
                <table class="ui celled padded table">
                    <thead>
                    <tr>
                        <th class="single line">Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($aOrders as $orderID) :
                        $oOrder = wc_get_order($orderID);
                        $oUser = new WP_User($oOrder->get_customer_id());
                        ?>
                        <tr>
                            <td>
                                <h2 class="ui center aligned header"><?php echo '#'.$orderID ?></h2>
                            </td>
                            <td class="single line">
                                <a target="_blank" href="<?php echo esc_url(add_query_arg(['user_id' => $oUser->ID],
                                  admin_url('user-edit.php'))); ?>"><?php echo $oUser->user_login; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $oOrder->get_status(); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="5">
                            <div class="ui right floated pagination menu" style="padding: 0;">
                                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                    <a href="<?php echo add_query_arg(['page' => $i],
                                      get_permalink()); ?>"
                                       class="item <?php echo $i == $currentPage ?
                                         'active' : ''; ?>">
                                        <?php echo esc_attr($i); ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php
get_footer();
