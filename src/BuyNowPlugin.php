<?php namespace Testcorp\BuyNow;

use Premmerce\SDK\V2\FileManager\FileManager;
use Testcorp\BuyNow\Admin\Admin;
use Testcorp\BuyNow\Frontend\Frontend;

/**
 * Class BuyNowPlugin
 *
 * @package Testcorp\BuyNow
 */
class BuyNowPlugin {

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

	/**
	 * Fired when the plugin is activated
	 */
	public function activate() {
		// TODO: Implement activate() method.
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate() {
		// TODO: Implement deactivate() method.
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall() {
		// TODO: Implement uninstall() method.
	}
}