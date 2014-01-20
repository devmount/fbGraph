<?php if(!defined('IS_CMS')) die();

/**
 * Plugin:   fbGraph
 * @author:  HPdesigner (kontakt[at]devmount[dot]de)
 * @version: v0.1.2014-01-12
 * @license: GPL
 * @see:     “I have the right to do anything,” you say—but not everything is beneficial. “I have the right to do anything”—but I will not be mastered by anything.
 *           - The Bible
 *
 * Plugin created by DEVMOUNT
 * www.devmount.de
 *
**/

class fbGraph extends Plugin {

	public $admin_lang;
	private $cms_lang;

	function getContent($value) {

		global $CMS_CONF;

		$this->cms_lang = new Language(PLUGIN_DIR_REL . 'fbGraph/lang/cms_language_' . $CMS_CONF->get('cmslanguage') . '.txt');

		// get params
		$values = explode('|', $value);

		$pid = $values[0];		// either id as number or name
		$tag = $values[1];		// the specific information - possible values are: 
								// about, category, company_overview, founded, description, is_published, talking_about_count, username, website, were_here_count, id, name, link, likes
		$after = $values[2];	// text displayed after the information

		$file = 'http://graph.facebook.com/' . $pid;

		$graph = json_decode(@file_get_contents($file));

		// check url file
		if ($graph == '') return $this->throwError($this->cms_lang->getLanguageValue('error_file',$pid));

		$info = '';

		switch ($tag) {
			// fb-page tags
			case 'about': $info = $graph->about; break;
			case 'category': $info = $graph->category; break;
			case 'company_overview': $info = $graph->company_overview; break;
			case 'founded': $info = $graph->founded; break;
			case 'description': $info = $graph->description; break;
			case 'is_published': $info = $graph->is_published; break;
			case 'talking_about_count': $info = $graph->talking_about_count; break;
			case 'username': $info = $graph->username; break;
			case 'website': $info = $graph->website; break;
			case 'were_here_count': $info = $graph->were_here_count; break;
			case 'id': $info = $graph->id; break;
			case 'name': $info = $graph->name; break;
			case 'link': $info = $graph->link; break;
			case 'likes': $info = $graph->likes; break;
			// fb-profile tags
			case 'first_name': $info = $graph->first_name; break;
			case 'last_name': $info = $graph->last_name; break;
			case 'gender': $info = $graph->gender; break;
			case 'locale': $info = $graph->locale; break;
			// default
			default: return $this->throwError($this->cms_lang->getLanguageValue('error_tag',$tag)); break;
		}

		// build return content
		$content = '<div class="fbGraph">' . $info;
		if($after != '') $content .= ' ' . $after;
		$content .= '</div>';

		return $content;
	}


	function getConfig() {

		$config = array();
		return $config;
	}  


	function getInfo() {

		global $ADMIN_CONF;

		$this->admin_lang = new Language(PLUGIN_DIR_REL . 'fbGraph/lang/admin_language_' . $ADMIN_CONF->get('language') . '.txt');

		$info = array(
			// plugin name and version
			'<b>fbGraph</b> v0.1.2014-01-12',
			// moziloCMS version
			'2.0',
			// short description, only <span> and <br /> are allowed
			$this->admin_lang->getLanguageValue('description'), 
			// author
			'HPdesigner',
			// documentation url
			'http://www.devmount.de/Develop/Mozilo%20Plugins/fbGraph.html',
			// plugin tag for select box when editing a page, can be emtpy
			array(
				'{fbGraph|id|tag|after}' => $this->admin_lang->getLanguageValue('placeholder'),
			)
		);

		return $info;
	}

	protected function throwError($text) {
		return '<div class="fbGraphError">' . $text . '</div>';
	}

}

?>