<?php
/**
 * Plugin Name:     WP CLI: Loop CSV
 * Plugin URI:      https://anthonyskelton.com
 * Description:     Loop through a CSV File using WP CLI
 * Author:          Anthony Skelton
 * Author URI:      https://anthonyskelton.com
 * Text Domain:     ajs-csv-to-cli
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Ajs_Csv_To_Cli
 */

class AJS_CSV_TO_CLI {

	/**
	 * parsed import file
	 * @var array
	 */
	public $csv = null;

	/**
	 * import file
	 * @var string
	 */
	public $file = null;
	

	/**
	 * Runs the loop through the csv file rows
	 *
	 * @param $args
	 * @param $assoc_args
	 *
	 * @return bool
	 */
	public function run( $args, $assoc_args ): bool {

		if ( isset( $args[0] ) ) {
			$this->file = $args[0];
		} else {
			return WP_CLI::error( 'file not specified!' );
		}

		$this->_read();

		// Loop Through the rows of the file
		while ( ( $row = fgetcsv( $this->file ) ) !== false ) {
			
			/**
			 * ADD CUSTOM LOGIC FOR EACH ROW HERE
			 */
			

		}

		// Close the file
		fclose( $this->file );

		return true;
	}


	/**
	 * read import file
	 * @access private
	 * @return bool true on success
	 */
	private function _read() {

		$this->_open();

		if ( ! $this->csv = fgetcsv( $this->file ) ) {

			return WP_CLI::error( 'unable to read file ' . $this->file . ', check formatting!' );

		}

		WP_CLI::success( 'file ' . $this->file . ' read...' );

		return true;

	}

	/**
	 * open import file
	 * @access private
	 * @return bool true on success
	 */
	private function _open() {

		$this->_exists();

		if ( ! $this->file = fopen( $this->file, 'r' ) ) {

			return WP_CLI::error( 'unable to open file ' . $this->file . ', check permissions!' );

		}

		WP_CLI::success( 'file ' . $this->file . ' opened...' );

		return true;

	}

	/**
	 * Check if import file exists
	 * @access private
	 * @return bool true on success
	 */
	private function _exists() {

		if ( ! file_exists( $this->file ) ) {

			return WP_CLI::error( 'file ' . $this->file . ' does not exist!' );

		}

		WP_CLI::success( 'file ' . $this->file . ' exists...' );

		return true;

	}

}

/**
 * Registers our command when cli get's initialized.
 *
 * @since  1.0.0
 * @author Scott Anderson
 */
function ajs_cli_register_commands() {
	WP_CLI::add_command( 'loop-csv', 'AJS_CSV_TO_CLI' );
}

add_action( 'cli_init', 'ajs_cli_register_commands' );
