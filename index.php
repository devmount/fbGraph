<?php

/**
 * moziloCMS Plugin: fbGraph
 *
 * Reads the facebook graph and returns specific information
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_MoziloPlugins
 * @author   HPdesigner <kontakt@devmount.de>
 * @license  GPL v3
 * @version  GIT: v0.1.2014-01-12
 * @link     https://github.com/devmount/fbGraph
 * @link     http://devmount.de/Develop/Mozilo%20Plugins/fbGraph.html
 * @see      “I have the right to do anything,” you say
 *           — but not everything is beneficial.
 *           “I have the right to do anything”
 *           — but I will not be mastered by anything.
 *            - The Bible
 *
 * Plugin created by DEVMOUNT
 * www.devmount.de
 *
 */

// only allow moziloCMS environment
if (!defined('IS_CMS')) {
    die();
}

/**
 * fbGraph Class
 *
 * @category PHP
 * @package  PHP_MoziloPlugins
 * @author   HPdesigner <kontakt@devmount.de>
 * @license  GPL v3
 * @link     https://github.com/devmount/fbGraph
 */
class fbGraph extends Plugin
{
    private $_admin_lang;
    private $_cms_lang;

    // plugin information
    const PLUGIN_AUTHOR  = 'HPdesigner';
    const PLUGIN_DOCU
        = 'http://devmount.de/Develop/moziloCMS/Plugins/fbGraph.html';
    const PLUGIN_TITLE   = 'fbGraph';
    const PLUGIN_VERSION = 'v0.1.2014-01-12';
    const MOZILO_VERSION = '2.0';
    private $_plugin_tags = array(
        '1' => '{fbGraph|id|tag|after}',
    );

    /**
     * creates plugin content
     *
     * @param string $value Parameter divided by '|'
     *
     * @return string HTML output
     */
    function getContent($value)
    {
        global $CMS_CONF;

        $this->_cms_lang = new Language(
            $this->PLUGIN_SELF_DIR
            . 'lang/cms_language_'
            . $CMS_CONF->get('cmslanguage')
            . '.txt'
        );

        /**
         * get params
         * $pid either id as number or name
         * $tag the specific information - possible values are:
         *      about, category, company_overview, founded, description,
         *      is_published, talking_about_count, username, website,
         *      were_here_count, id, name, link, likes
         * $after text displayed after the information
         */
        list($pid, $tag, $after)
            = $this->makeUserParaArray($value, false, '|');

        $file = 'http://graph.facebook.com/' . $pid;

        $graph = json_decode(@file_get_contents($file));

        // check url file
        if ($graph == '') {
            return $this->throwError(
                $this->_cms_lang->getLanguageValue('error_file', $pid)
            );
        }

        $info = '';

        switch ($tag) {
        // fb-page tags
        case 'about':
            $info = $graph->about;
            break;

        case 'category':
            $info = $graph->category;
            break;

        case 'company_overview':
            $info = $graph->company_overview;
            break;

        case 'founded':
            $info = $graph->founded;
            break;

        case 'description':
            $info = $graph->description;
            break;

        case 'is_published':
            $info = $graph->is_published;
            break;

        case 'talking_about_count':
            $info = $graph->talking_about_count;
            break;

        case 'username':
            $info = $graph->username;
            break;

        case 'website':
            $info = $graph->website;
            break;

        case 'were_here_count':
            $info = $graph->were_here_count;
            break;

        case 'id':
            $info = $graph->id;
            break;

        case 'name':
            $info = $graph->name;
            break;

        case 'link':
            $info = $graph->link;
            break;

        case 'likes':
            $info = $graph->likes;
            break;

        // fb-profile tags
        case 'first_name':
            $info = $graph->first_name;
            break;

        case 'last_name':
            $info = $graph->last_name;
            break;

        case 'gender':
            $info = $graph->gender;
            break;

        case 'locale':
            $info = $graph->locale;
            break;

        // default
        default:
            return $this->throwError(
                $this->_cms_lang->getLanguageValue('error_tag', $tag)
            );
            break;
        }

        // build return content
        $content = '<div class="fbGraph">' . $info;
        if ($after != '') {
            $content .= ' ' . $after;
        }
        $content .= '</div>';

        return $content;
    }

    /**
     * sets backend configuration elements and template
     *
     * @return Array configuration
     */
    function getConfig()
    {
        $config = array();
        return $config;
    }

    /**
     * sets backend plugin information
     *
     * @return Array information
     */
    function getInfo()
    {
        global $ADMIN_CONF;
        $this->_admin_lang = new Language(
            $this->PLUGIN_SELF_DIR
            . 'lang/admin_language_'
            . $ADMIN_CONF->get('language')
            . '.txt'
        );

        // build plugin tags
        $tags = array();
        foreach ($this->_plugin_tags as $key => $tag) {
            $tags[$tag] = $this->_admin_lang->getLanguageValue('tag_' . $key);
        }

        $info = array(
            '<b>' . self::PLUGIN_TITLE . '</b> ' . self::PLUGIN_VERSION,
            self::MOZILO_VERSION,
            $this->_admin_lang->getLanguageValue(
                'description',
                htmlspecialchars($this->_plugin_tags['1'])
            ),
            self::PLUGIN_AUTHOR,
            self::PLUGIN_DOCU,
            $tags
        );

        return $info;
    }

    /**
     * throws styled error message
     *
     * @param string $text Content of error message
     *
     * @return string HTML content
     */
    protected function throwError($text)
    {
        return '<div class="' . self::PLUGIN_TITLE . 'Error">'
            . '<div>' . $this->_cms_lang->getLanguageValue('error') . '</div>'
            . '<span>' . $text. '</span>'
            . '</div>';
    }

}

?>