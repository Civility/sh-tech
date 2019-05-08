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

JHtml::_('behavior.caption');

$app      = JFactory::getApplication();
$menu     = $app->getMenu();
$active   = $menu->getActive();
$menuname = $active->title;
$menualias= $active->alias;

$db       = JFactory::getDBO();
$query    = "SELECT `title`,`alias` FROM `#__menu` WHERE `parent_id` = $active->id AND `level`=2 AND `published`=1";
$db->setQuery($query);
$rows     = $db->loadObjectList();
$subTitle = $this->escape($rows[0]->title);
$subAlias = $this->escape($rows[0]->alias);

$dispatcher = JEventDispatcher::getInstance();

$this->category->text = $this->category->description;
$dispatcher->trigger('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));
?>
<div class="articles<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
<?php if ($this->params->get('show_category_title', 1) || $this->params->get('show_description', 1) || $this->params->get('show_description_image', 1) ): ?>

	<div class="intro">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<div class="img mr-auto mr-lg-3 col-12 col-lg-5">
			<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
		</div>
		<?php endif; ?>
		<div class="desc col-12 col-lg-7">
			<?php if ($this->params->get('show_category_title')) : ?>
				<h3 class="item-title"><?php echo $this->category->title; ?></h3>
			<?php endif; ?>

			<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
				<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
				<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
			<?php endif; ?>
				<?php //echo $afterDisplayTitle; ?>
				<?php echo $beforeDisplayContent; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<div class="text">	
					<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
				</div>
			<?php endif; ?>		
		</div>
		<?php echo $afterDisplayContent;?>
	</div>
<?php endif; ?>	

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

<?php if ($this->params->get('show_category_title', 1) && $this->params->get('page_subheading')) : ?>
	<h2 class="page-header"> <?php echo $this->escape($this->params->get('page_subheading')); ?></h2>
<?php endif; ?>

<?php if (!empty(JModuleHelper::getModules('archive'))) : //проверка на вывод модуля?>	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#subSobytia" aria-controls="subSobytia" aria-expanded="false" aria-label="navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php if ($this->params->get('show_page_heading')) : ?>
			<div class="active">
				<h2 class="page-header"><?php echo $this->escape($this->params->get('page_heading')); ?></h2>
			</div>
		<?php endif; ?>
		<div class="sub-sobytia collapse navbar-collapse" id="subSobytia">
			<?=JHtml::_('content.prepare', '{loadposition archive}'); ?>
		</div>
	</nav>
	<?php echo $this->loadTemplate('preview'); ?>
	<?php else: ?>

	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="active">
			<h2 class="page-header"><?php echo $this->escape($this->params->get('page_heading')); ?></h2>
		</div>
	<?php endif; ?>
	<?php echo $this->loadTemplate('art'); ?>
<?php endif; ?>

</div>