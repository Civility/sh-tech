<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\Registry\Registry;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
?>
<?php if (!empty($displayData)) : ?>
	<ul class="tags inline">
		<?php foreach ($displayData as $i => $tag) : ?>
			<?php $authorised = JFactory::getUser()->getAuthorisedViewLevels();
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query = "SELECT id,title,published FROM `#__tags` WHERE `id`='".$tag->parent_id."' AND `published`=1";
				$db->setQuery($query);
				$res = $db->loadObjectList();
				foreach($res as $tag_parent): endforeach;  ?>
			<?php if (in_array($tag->access, $authorised)) : ?>
				<?php $tagParams = new Registry($tag->params); ?>
				<?php $link_class = $tagParams->get('tag_link_class', 'label label-info'); ?>
				<li class="tag-<?=$tag->tag_id; ?> tag-list<?=$i; ?>" itemprop="keywords">
					<span class="<?=$link_class;?> text-muted"><?=$tag_parent->title ?>: </span>
					<?=$this->escape($tag->title); ?>
				</li>	
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>