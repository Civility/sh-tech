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
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="page-header"> <?=$this->escape($this->params->get('page_heading')); ?> </h1>
<?php endif; ?>
<?php if ($this->params->get('page_subheading')) : ?>
	<?php if ($this->params->get('page_subheading')) : ?>
		<h2 class="item-title"><?=$this->escape($this->params->get('page_subheading')); ?></h2>
	<?php endif; ?>
<?php endif; ?>
<div class="articles<?=$this->pageclass_sfx;?>" itemscope itemtype="http://schema.org/NewsArticle">
	<div class="intro">
	<?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<?php if (!empty($this->category->description && $this->category->getParams()->get('image'))): // если описание и картинка есть
			$colImg  = 'col-12 col-lg-4';
			$colDesc = 'col-12 col-lg-auto';
		else : 
			$colImg = $colDesc = 'col-12';
		endif; ?>

		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<div class="img <?=$colImg;?>">
				<img src="<?=$this->category->getParams()->get('image'); ?>" alt="<?=htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" class="img-fluid"/>
			</div>
		<?php endif; ?>	
			<div class="desc <?=$colDesc;?>">
				<?php if ($this->params->get('show_category_title', 1) && $this->params->get('show_category_title')) : ?>
					<h4 class="item-title"><?=$this->category->title; ?></h4>
				<?php endif; ?>
				<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
					<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
					<?=$this->category->tagLayout->render($this->category->tags->itemTags); ?>
				<?php endif; ?>
				<?=$afterDisplayTitle; ?>
				<?=$beforeDisplayContent; ?>
				<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<div class="text">	
					<?=JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
				</div>	
				<?php endif; ?>
			</div>
	<?php endif; ?>
			<?=$afterDisplayContent;?>	
	</div>
	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?=JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	<h4 class="item-title"><?=JText::_('ALREADY_DONE'); ?></h4>
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="list-group list-group-flush mb-4">
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="article list-<?=$leadingcount; ?><?=$item->state == 0 ? ' system-unpublished' : null; ?>"
					itemscope itemtype="http://schema.org/NewsArticle">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div><!-- end items-leading -->
	<?php endif; ?>

	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
			<?php if ($rowcount === 1) : ?>
				<?php $row = $counter / $this->columns; ?>
				<div class="row col-<?=(int) $this->columns; ?> <?='row-' . $row; ?> row-fluid">
			<?php endif; ?>
			<div class="col-<?=round(12 / $this->columns); ?>">
				<div class="item column-<?=$rowcount; ?><?=$item->state == 0 ? ' system-unpublished' : null; ?>"
					itemscope itemtype="http://schema.org/NewsArticle">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<!-- end item -->
				<?php $counter++; ?>
			</div><!-- end span -->
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>
				</div><!-- end row -->
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more">
			<?=$this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3 class="title h4"><?=JText::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
			<?php endif; ?>
			<?=$this->loadTemplate('children'); ?> </div>
	<?php endif; ?>
	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<?php //echo $this->pagination->getPagesCounter(); ?>
			<?php endif; ?>
			<?=$this->pagination->getPagesLinks(); ?>
	<?php endif; ?>
</div>
