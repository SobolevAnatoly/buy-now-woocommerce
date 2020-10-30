<?php namespace Testcorp\BuyNow;

use Premmerce\SDK\V2\FileManager\FileManager;
use Testcorp\BuyNow\Admin\Admin;
use Testcorp\BuyNow\Frontend\Frontend;
use Testcorp\BuyNow\Frontend\AjaxHandlers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class BuyNowPlugin
 *
 * @package Testcorp\BuyNow
 */
class BuyNowPlugin {

    const DOMAIN = 'buy-now-woocommerce';

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * BuyNowPlugin constructor.
	 *
     * @param string $mainFile
	 */
    public function __construct($mainFile) {
        $this->fileManager = new FileManager($mainFile);

        add_action('plugins_loaded', [ $this, 'loadTextDomain' ]);

        new AjaxHandlers();

	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->fileManager );
		} else {
			new Frontend( $this->fileManager );
		}

	}

    /**
     * Load plugin translations
     */
    public function loadTextDomain()
    {
        $name = $this->fileManager->getPluginName();
        load_plugin_textdomain('buy-now-woocommerce', false, $name . '/languages/');
    }

}