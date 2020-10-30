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

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Testcorp\BuyNow\BuyNowPlugin;

?>
    <button id="buyNowButton"
       class="button buy-now buy-now-button"
       style="padding-right: 0.75em;padding-left: 0.75em;margin-left: 8px;background-color: #88336a;color:#fff3e6"
       data-id="<?= get_the_ID() ?>"
    >
        <?php _e('Buy Now', BuyNowPlugin::DOMAIN) ?>
    </button>
<?php
