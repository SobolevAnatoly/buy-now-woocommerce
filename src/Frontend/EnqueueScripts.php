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

namespace Testcorp\BuyNow\Frontend;

defined('ABSPATH') || exit;

class EnqueueScripts
{

    private $fileManager;

    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;

        add_action('wp_enqueue_scripts', function () {

            wp_enqueue_script(
                'buy-now-ajax-frontend',
                $this->fileManager->locateAsset('frontend/js/buy-now-ajax-frontend.js'),
                ['jquery'],
                BN_VERSION,
                true
            );

            wp_localize_script(
                'buy-now-ajax-frontend',
                'buyNowAjax',
                [
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('buy-now-ajax-nonce')
                ]
            );
        }, 99);

    }

}
