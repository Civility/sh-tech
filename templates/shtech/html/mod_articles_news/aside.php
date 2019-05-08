<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$db = JFactory::getDbo();
$module->note = $db->setQuery("SELECT `note` FROM `#__modules` WHERE `id` = ".$module->id)->loadResult();
?>
<?php //echo $moduleclass_sfx; ?>
<?php foreach ($params->get('catid') as $catid) : ?>
<?php endforeach; ?>
<?php
$db =JFactory::getDBO();
$query = $db->getQuery(true);
$query = "SELECT id, description, params, alias, published  FROM `#__categories` WHERE id='".$catid."' AND `published`>0";
$db->setQuery($query);
$result = $db->loadObjectList();
foreach($result as $row) : ?>
	<?php $img = json_decode($row->params); ?>
		<h4 class="title <?=$params->get('header_class');?>"><a href="<?=$row->alias;?>"><?=trim($module->title);?></a></h4>
	<<?=$params->get('module_tag');?> class="card">
		<div class="img"><a href="<?=$row->alias;?>">
			<img src="<?=$img->image; ?>" alt="<?=htmlspecialchars($img->image_alt); ?>" class='img-fluid w-100'></a>
		</div>
		<div class="text">
			<?php echo JHtml::_('string.truncate', $row->description, htmlspecialchars((int) $module->note), false, false);?>
			<?php if ((int)strlen($row->description) >= (int)$module->note): ?>
			<div class="more">
				<a href="<?=$row->alias;?>"><span class="hellip">&hellip;</span></a>
			</div>
			<?php endif; ?>
		</div>
	</<?=$params->get('module_tag');?>>
<?php endforeach;?>
