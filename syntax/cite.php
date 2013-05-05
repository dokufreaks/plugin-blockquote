<?php
/**
 * Blockquote Plugin
 *
 * Allows correctly formatted blockquotes
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Gina Haeussge <osd@foosel.net>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once (DOKU_PLUGIN . 'syntax.php');

class syntax_plugin_blockquote_cite extends DokuWiki_Syntax_Plugin {

    function getType() {
        return 'formatting';
    }

    function getPType() {
        return 'normal';
    }

    function getAllowedTypes() {
        return array (
            'substition',
            'formatting',
        );
    }

    function getSort() {
        return 123;
    }

    function accepts($mode) {
        if ($mode == substr(get_class($this), 7))
            return true;
        return parent :: accepts($mode);
    }

    function connectTo($mode) {
        $this->Lexer->addEntryPattern('<cite>(?=.*?</cite>)', $mode, 'plugin_blockquote_cite');
    }

    function postConnect() {
        $this->Lexer->addExitPattern('</cite>', 'plugin_blockquote_cite');
    }

    function handle($match, $state, $pos, & $handler) {

        switch ($state) {

            case DOKU_LEXER_ENTER :
                return array (
                    $state,
                    ''
                );

            case DOKU_LEXER_UNMATCHED :
                return array (
                    $state,
                    $match
                );

            default :
                return array (
                    $state,
                    ''
                );
        }
    }

    function render($mode, & $renderer, $indata) {
        if ($mode == 'xhtml') {

            list ($state, $data) = $indata;

            switch ($state) {
                case DOKU_LEXER_ENTER :
                    $renderer->doc .= '<cite class="blockquote-plugin">';
                    break;

                case DOKU_LEXER_UNMATCHED :
                    $renderer->doc .= $renderer->_xmlEntities($data);
                    break;

                case DOKU_LEXER_EXIT :
                    $renderer->doc .= "\n</cite>";
                    break;
            }
            return true;
        }

        // unsupported $mode
        return false;
    }
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
