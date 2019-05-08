<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
$db = JFactory::getDbo();
$module->note = $db->setQuery("SELECT `note` FROM `#__modules` WHERE `id` = ".$module->id)->loadResult();

defined('_JEXEC') or die;
$input  = JFactory::getApplication()->input;
$option = $input->getCmd('option');
$view   = $input->getCmd('view');
$id     = $input->getInt('id');

foreach ($list as $item) : ?>
<div<?php if ($id == $item->id && $view == 'category' && $option == 'com_content') echo ' class="active"'; if($levelup == 0) : echo ' class="item col-12 col-lg-4"'; endif;?>> <?php $levelup = $item->level - $startLevel - 1;?>
	<h<?=$params->get('item_heading') + $levelup; ?> class="<?=$params->get('header_class'); ?>">
		<a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?=$item->title; ?>
			<?php if ($params->get('numitems')) : ?>
				(<?=$item->numitems; ?>)
			<?php endif; ?>
		</a>
	</h<?=$params->get('item_heading') + $levelup; ?>>
<?php
$params->loadString($item->params);
$image = $params->get('image');
$image_alt = $params->get('image_alt');
 if (empty($image_alt)) $alt = $item->title; else $alt = $image_alt;?>
	<div class="desc-body">

			<?php if (!empty($image)) : ?>
			<a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>" class="img">
				<div class="bg-catalog img-fluid" style="background-image:url('<?=$image;?>')" alt="<?=htmlspecialchars($alt);?>" title="<?=htmlspecialchars($alt);?>"></div>
			</a>
			<?php endif; ?>		

		<?php if ($params->get('show_description', 0)) : ?>
		<div class="desc">

				<div class="text">
					<?php $itemdesc = JHtml::_('content.prepare',$item->description,$item->getParams(),'mod_articles_categories.content');?>
					<?=JHtml::_('string.truncate',$itemdesc,(int)$module->note, false, false); ?>
				</div>
				<?php if ((int)strlen($itemdesc) >= (int)$module->note): ?>
				<div class="more">
					<a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>"><span class="hellip">&hellip;</span></a>
				</div>					
				<?php endif ?>							

		</div>
		<?php endif; ?>
	</div>
		<?php if ($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0)
			|| ($params->get('maxlevel') >= ($item->level - $startLevel)))
			&& count($item->getChildren())) : ?>
			<?='<ul>'; ?>
			<?php $temp = $list; ?>
			<?php $list = $item->getChildren(); ?>
			<?php require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default') . '_items'); ?>
			<?php $list = $temp; ?>
			<?='</ul>'; ?>
		<?php endif; ?>
</div>
<?php endforeach; ?>