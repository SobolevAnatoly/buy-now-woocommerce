<?php
/**
 * Copyright (c) 2020 Anatolii S.
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

use Testcorp\BuyNow\BuyNowPlugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div class="wrap">
    <h2><?php _e('List of Buy Now orders', BuyNowPlugin::DOMAIN) ?></h2>
    <div id="posts-orders">
        <div id="post-body-content">
            <div class="meta-box-sortables ui-sortable">
                <form method="post">
                    <?php
                    $orders_obj->prepare_items();
                    $orders_obj->display();
                    ?>
                </form>
            </div>
        </div>
        <br class="clear">
    </div>
</div>