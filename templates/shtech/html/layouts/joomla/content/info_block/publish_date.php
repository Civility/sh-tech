<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
?>
			<dd class="published">
				<time datetime="<?=JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished"><?=JText::sprintf( JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC')));?></time>
			</dd>