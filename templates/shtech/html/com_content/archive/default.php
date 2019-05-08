<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.caption');

?>
<?php if ($this->params->get('show_category_title', 1) && $this->params->get('page_subheading')) : ?>
	<h2 class="page-header"> <?=$this->escape($this->params->get('page_subheading')); ?></h2>
<?php endif; ?>
<div class="articles<?=$this->pageclass_sfx; ?>">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#subSobytia" aria-controls="subSobytia" aria-expanded="false" aria-label="navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php if ($this->params->get('show_page_heading')) : ?>
			<div class="active">
				<h2 class="page-header border-bottom"><?=$this->escape($this->params->get('page_heading')); ?></h2>
			</div>
		<?php endif; ?>	
		<div class="sub-sobytia collapse navbar-collapse" id="subSobytia">
			<?=JHtml::_('content.prepare', '{loadposition archive}'); ?>
		</div>
</nav>
	<?=$this->loadTemplate('items'); ?>
</div>