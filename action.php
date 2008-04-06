<?php
/**
 * Blockquote Plugin
 *
 * Allows correctly formatted blockquotes. Action component provides toolbar
 * button.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Tobias Deutsch <tobias@strix.at>
 * @author     Gina Haeussge <osd@foosel.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC'))
	die();

if (!defined('DOKU_PLUGIN'))
	define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
	
require_once (DOKU_PLUGIN . 'action.php');

class action_plugin_blockquote extends DokuWiki_Action_Plugin {
	
	/**
	 * return some info
	 */
	function getInfo() {
		return array (
			'author' => 'Tobias Deutsch',
			'email' => 'tobias@strix.at',
			'date' => '2008-01-26',
			'name' => 'Blockquote Plugin (action component)',
			'desc' => 'Provides an environment for quotes in a semantically correct way using the blockquote XHTML tag. Action component provides toolbar button.',
			'url' => 'http://wiki.foosel.net/snippets/dokuwiki/blockquote',
			
		);
	}

	/**
	 * register the eventhandlers
	 */
	function register(& $controller) {
		$controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'blockquote_button', array ());
	}

	/**
	 * Inserts a toolbar button
	 */
	function blockquote_button(& $event, $param) {
		global $lang;
		global $conf;

		include_once (dirname(__FILE__) . '/lang/en/lang.php');
		@include_once (dirname(__FILE__) . '/lang/' . $conf['lang'] . '/lang.php');
		$event->data[] = array (
			'type' => 'format',
			'title' => $lang['qb_blockquote'],
			'icon' => '../../plugins/blockquote/images/blockquote-icon.png',
			'open' => '<blockquote>',
			'close' => '</blockquote>',
			
		);

		return true;
	}
}