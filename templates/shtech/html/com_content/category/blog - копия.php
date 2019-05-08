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
?>
<?php echo JHtml::_('content.prepare', '{loadposition archive}'); ?>

<div class="articles<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
<?php if ($this->params->get('show_category_title', 1) || $this->params->get('show_description', 1) || $this->params->get('show_description_image', 1) ): ?>
	<div class="media flex-wrap">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<div class="img mr-auto mr-lg-3 col-12 px-0 col-lg-5">
			<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
		</div>
		<?php endif; ?>
	
		<div class="desc media-body col-12 px-0 col-lg-7">
			<?php if ($this->params->get('show_category_title')) : ?>
				<h3 class="item-title mt-0 text-uppercase mb-4"><?php echo $this->category->title; ?></h3>
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

<?php if (!empty($subTitle)) : ?>

	<nav class="navbar navbar-expand-lg navbar-light bg-light px-0 text-uppercase">
		  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#page-header" aria-controls="page-header" aria-expanded="false" aria-label="Активный заголовок">
   			 <span class="navbar-toggler-icon"></span>
		  </button>
		<div class="collapse navbar-collapse" id="page-header">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="<?=$menualias;?>" class="nav-link p-0 mr-3">
						<h2 class="page-header border-bottom">
							<?php if ($this->params->get('show_page_heading') == 0):
								echo $this->escape($this->category->title);
							else: 
								echo $this->escape($this->params->get('page_heading'));
							endif; ?>
						</h2>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?=$menualias.'/'.$subAlias?>" class="nav-link p-0 ml-3">
						<h2 class="page-header text-muted"><?=$subTitle;?></h2>
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

	<?php echo $this->loadTemplate('preview'); ?> 