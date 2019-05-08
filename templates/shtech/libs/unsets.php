<?php 
defined('_JEXEC') or die;
// get html head data
/*$head = $doc->getHeadData();
// remove deprecated meta-data (html5)
unset($head['metaTags']['http-equiv']);
unset($head['metaTags']['standard']['title']);
unset($head['metaTags']['standard']['rights']);
unset($head['metaTags']['standard']['language']);

// remove core js
$dontInclude = array(
	'/media/jui/js/jquery-noconflict.js',
	'/media/jui/js/jquery-migrate.js',
	'/media/jui/js/jquery-migrate.min.js',
	'/media/jui/js/bootstrap.js',
	'/media/jui/js/jquery.min.js',
	'/media/system/js/core-uncompressed.js',
	'/media/system/js/tabs-state.js',
	'/media/system/js/mootools-core.js',
	'/media/system/js/mootools-more.js',
	'/media/system/js/caption.js',
	'/media/jui/js/bootstrap.min.js',
	'/media/system/js/mootools-core-uncompressed.js',
	'/media/system/js/mootools-core-uncompressed.js',
);

foreach ($doc->_scripts as $key => $script) {
	if (in_array($key, $dontInclude)) {
		unset($doc->_scripts[ $key ]);
	}
}*/
// $this->_scripts = array();
// unset($this->_script['text/javascript']);

// JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery.min.js']);
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery-noconflict.js']);
unset($doc->_scripts[JURI::root(true). '/media/jui/js/bootstrap.min.js']);
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery-migrate.min.js']);
// unset($doc->_scripts[JURI::root(true). '/media/system/js/caption.js']);
?>
<?php
/*
  JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery.min.js']);
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery-noconflict.js']);
unset($doc->_scripts[JURI::root(true). '/media/jui/js/jquery-migrate.min.js']);
  JHtml::_('bootstrap.tooltip');
$doc = JFactory::getDocument();
unset($doc->_scripts[JURI::root(true). '/media/jui/js/bootstrap.min.js']);
*/
?>