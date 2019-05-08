<?php

/** @var $this JDocumentHTML */
class WssHeadRender
{
	public function fetchHead( $document )
	{

		// Get line endings
		$lnEnd = $document->_getLineEnd();
		$tab = $document->_getTab();
		$tagEnd = ' />';
		$buffer = '';
		// Generate stylesheet links
		/*foreach ( $document->_styleSheets as $strSrc => $strAttr ) {
			$buffer .= $tab . '<link rel="stylesheet" href="' . $strSrc . '"';

			if ( !is_null( $strAttr['mime'] ) && ( !$document->isHtml5() || $strAttr['mime'] != 'text/css' ) ) {
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}

			if ( !is_null( $strAttr['media'] ) ) {
				$buffer .= ' media="' . $strAttr['media'] . '"';
			}

			if ( $temp = JArrayHelper::toString( $strAttr['attribs'] ) ) {
				$buffer .= ' ' . $temp;
			}

			$buffer .= $tagEnd . $lnEnd;
		}*/

		// Generate stylesheet declarations
		foreach ( $document->_style as $type => $content ) {
			$buffer .= $tab . '<style type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '/*<![CDATA[*/' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '/*]]>*/' . $lnEnd;
			}

			$buffer .= $tab . '</style>' . $lnEnd;
		}

		// Generate script file links
		foreach ( $document->_scripts as $strSrc => $strAttr ) {
			$buffer .= $tab . '<script src="' . $strSrc . '"';
			$defaultMimes = array(
				'text/javascript', 'application/javascript', 'text/x-javascript', 'application/x-javascript'
			);

			if ( !is_null( $strAttr['mime'] ) && ( !$document->isHtml5() || !in_array( $strAttr['mime'], $defaultMimes ) ) ) {
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}

			if ( $strAttr['defer'] ) {
				$buffer .= ' defer="defer"';
			}

			if ( $strAttr['async'] ) {
				$buffer .= ' async="async"';
			}

			$buffer .= '></script>' . $lnEnd;
		}

		// Generate script declarations
		foreach ( $document->_script as $type => $content ) {
			$buffer .= $tab . '<script type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '//]]>' . $lnEnd;
			}

			$buffer .= $tab . '</script>' . $lnEnd;
		}

		// Generate script language declarations.
		if ( count( JText::script() ) ) {
			$buffer .= $tab . '<script type="text/javascript">' . $lnEnd;

			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
			}

			$buffer .= $tab . $tab . '(function() {' . $lnEnd;
			$buffer .= $tab . $tab . $tab . 'Joomla.JText.load(' . json_encode( JText::script() ) . ');' . $lnEnd;
			$buffer .= $tab . $tab . '})();' . $lnEnd;

			if ( $document->_mime != 'text/html' ) {
				$buffer .= $tab . $tab . '//]]>' . $lnEnd;
			}

			$buffer .= $tab . '</script>' . $lnEnd;
		}

		foreach ( $document->_custom as $custom ) {
			$buffer .= $tab . $custom . $lnEnd;
		}

		return $buffer;
	}
}

$document = JFactory::getDocument();
$wssDocument = clone $document;
$document->_scripts = array();
$document->_script = array();
//$document->_styleSheets = array();
$document->_style = array();
$headRenderer = new WssHeadRender();
echo $headRenderer->fetchHead( $wssDocument );