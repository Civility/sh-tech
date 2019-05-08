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
$app = JFactory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();
$menuName = $active->title;
$menuAlias = $active->alias;
$parentId = $active->tree[0];
$parentTitle = $menu->getItem($parentId)->title;
$parentLink = $menu->getItem($parentId)->alias;
?>
<div class="archive<?php echo $this->pageclass_sfx; ?>">
<?php /*
<form id="adminForm" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-inline row">
	<fieldset class="filters col-lg-2 col-12">
	<div class="filter-search d-flex flex-column">
		<?php if ($this->params->get('filter_field') !== 'hide') : ?>
		<label class="filter-search-lbl element-invisible" for="filter-search"><?php echo JText::_('COM_CONTENT_TITLE_FILTER_LABEL') . '&#160;'; ?></label>
		<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->filter); ?>" class="inputbox span2" onchange="document.getElementById('adminForm').submit();" placeholder="<?php echo JText::_('COM_CONTENT_TITLE_FILTER_LABEL'); ?>" />
		<?php endif; ?>

		<?php echo $this->form->monthField; ?>
		<?php echo $this->form->yearField; ?>
		<?php echo $this->form->limitField; ?>

		<button type="submit" class="btn btn-primary" style="vertical-align: top;"><?php echo JText::_('JGLOBAL_FILTER_BUTTON'); ?></button>
		<input type="hidden" name="view" value="archive" />
		<input type="hidden" name="option" value="com_content" />
		<input type="hidden" name="limitstart" value="0" />
	</div>
	<br />
	</fieldset>
	<?php echo $this->loadTemplate('items'); ?>
</form>
*/ ?>
<?php echo JHtml::_('content.prepare', '{loadposition archive}'); ?>
<?php if ($this->params->get('show_page_heading') && !empty($parentTitle)) : ?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-0 text-uppercase">
		  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#page-header" aria-controls="page-header" aria-expanded="false" aria-label="Активный заголовок">
   			 <span class="navbar-toggler-icon"></span>
		  </button>
		<div class="collapse navbar-collapse" id="page-header">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="<?=$parentLink;?>" class="nav-link p-0 mr-3">
						<h2 class="page-header text-muted"><?=$parentTitle;?></h2>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?=$parentLink.'/'.$menuAlias;?>" class="nav-link p-0 ml-3">
						<h2 class="page-header border-bottom">
						<?php if ($this->params->get('show_page_heading') == 0):
							echo $this->escape($this->category->title);
							else: 
							 echo $this->escape($this->params->get('page_heading')); 
							endif; ?>
						</h2>
					</a>
				</li>
			</ul>
		</div>
	</nav>
		<?php else: ?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light px-0 text-uppercase">
				<div class="navbar-collapse">
					<ul class="navbar-nav">
						<li class="nav-item">
							<h2 class="page-header border-bottom"><?php echo $this->escape($this->params->get('page_heading')); ?></h2>
						</li>
					</ul>
				</div>
			</nav>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) && $this->params->get('page_subheading')) : ?>
		<h2 class="page-header"> <?php echo $this->escape($this->params->get('page_subheading')); ?></h2>
	<?php endif; ?>
</div>