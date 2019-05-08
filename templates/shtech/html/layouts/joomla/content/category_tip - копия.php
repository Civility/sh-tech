<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Note that this layout opens a div with the page class suffix. If you do not use the category children
 * layout you need to close this div either by overriding this file or in your main layout.
 */
$params    = $displayData->params;
$category  = $displayData->get('category');
$extension = $category->extension;
$canEdit   = $params->get('access-edit');
$className = substr($extension, 4);

$dispatcher = JEventDispatcher::getInstance();

$category->text = $category->description;
$dispatcher->trigger('onContentPrepare', array($extension . '.categories', &$category, &$params, 0));
$category->description = $category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($extension . '.categories', &$category, &$params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($extension . '.categories', &$category, &$params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($extension . '.categories', &$category, &$params, 0));
$afterDisplayContent = trim(implode("\n", $results));

/**
 * This will work for the core components but not necessarily for other components
 * that may have different pluralisation rules.
 */
if (substr($className, -1) === 's')
{
	$className = trim($className, 's');
}
$tagsData = $category->tags->itemTags;
?>
<?php if ($params->get('show_page_heading')) : ?>
	<h2 class="page-header">
		<?php echo $displayData->escape($params->get('page_heading')); ?>
	</h2>
<?php endif; ?>
<div class="<?php echo $className .'-category' . $displayData->pageclass_sfx; ?>">
	<div class="intro">
	<?php echo $afterDisplayTitle; ?>
	<?php if ($beforeDisplayContent || $afterDisplayContent || $params->get('show_description', 1) || $params->def('show_description_image', 1)) : ?>
		<?php if (!empty($category->description) && !empty($category->getParams()->get('image'))): // если описание и картинка есть
			$colImg  = 'col-12 col-lg-4';
			$colDesc = 'col-12 col-lg-auto';
		else : 
			$colImg = $colDesc = 'col-12';
		endif ?>
		<?php if ($params->get('show_description_image') && $category->getParams()->get('image')) : ?>

		<div class="img <?=$colImg;?>" itemprop="image">
			<img src="<?php echo $category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" class="img-fluid" />
		</div>
		<?php endif; ?>

		<div class="desc <?=$colDesc;?>">
		<?php if ($params->get('show_category_title', 1)) : ?>
			<h4 class="item-title" itemprop="name">
				<?php echo JHtml::_('content.prepare', $category->title, '', $extension . '.category.title'); ?>
			</h4>
		<?php endif; ?>
	<?php if ($params->get('show_cat_tags', 1)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tip_tags', $tagsData); ?>
	<?php endif; ?>
			<?php echo $beforeDisplayContent; ?>
			<?php if ($params->get('show_description') && $category->description) : ?>
				<div class="text" itemprop="description">
					<?php echo JHtml::_('content.prepare', $category->description, '', $extension . '.category.description'); ?>
				</div>
			<?php endif; ?>
			<?php echo $afterDisplayContent; ?>
		</div>
	<?php endif; ?>
	<?php echo $displayData->loadTemplate($displayData->subtemplatename); ?>
	</div>
		<?php if ($displayData->maxLevel != 0 && $displayData->get('children')) : ?>
		<ul class="category-tip-children list-group list-group-flush">
			<?php if ($params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h4>
					<?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?>
				</h4>
			<?php endif; ?>
			<?php echo $displayData->loadTemplate('children'); ?>
		</ul>
	<?php endif; ?>
</div>


<?php

$db = JFactory::getDbo();
$query = $db->getQuery(true);
	$query = "SELECT `title`,`alias` FROM `#__content` WHERE `catid`='".$category->id."' AND `state`='1' ORDER BY `title` ASC"; 
	// проверка на совпадеине категории и контента 
	$db->setQuery($query);
	$res = $db->loadObjectList(); ?>
<?php $letter=NULL; ?>
<?php foreach($res as $key => $content):
	$ctitle = $content->title;
	$alias = $content->alias;?>
	<?php
	$word = mb_substr($ctitle, 0, 1);
	if($letter!=$word):$letter=$word; ?>	
		<div class="border-bottom">
			<a href="#word-<?=$letter;?>" aria-controls="word-<?=$letter;?>" data-toggle="collapse" data-toggle="button" class="link d-flex justify-content-between py-3" role="button" aria-expanded="false" aria-label="<?=JText::_('JGLOBAL_EXPAND_CATEGORIES'); ?>">
				<div class="text-muted text h3"><?=$letter;?></div>
				<span class="check"></span>
			</a>
		</div>
	<?php endif; ?>
		<ul class="catalog-list list-group list-group-flush collapse" id='word-<?=$letter;?>'>
			<li class="list-group-item">
				<div class="d-flex justify-content-between align-items-center">
					<a href="<?=$category->alias ."/". $alias;?>" class="title d-block w-100"><?=$ctitle;?></a>
				</div>
			</li>
		</ul>
<?php endforeach;

?>