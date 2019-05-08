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
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
// Create some shortcuts.
$params    = &$this->item->params;
$n         = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
	foreach ($this->items as $article)
	{

		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}

$tableClass = $this->params->get('show_headings') != 1 ? ' table-noheader' : '';
?>
<?php /*вывод статей в категории, но т.к. все категории пусты кроме "catalog",то
проверяем на пустоту статей и выводим свои статьи по меткам(статья <=> категория + метки), 
что бы появлялось, только в пунктах меню (конкретная категория с конечными товарами) делаем проверку перед "<ul>" */   ?>
<?php

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query

->select(array('a.alias','b.tag_id'))
->from($db->quoteName('#__categories', 'a'))
->where($db->quoteName('a.id') . '= ' .$this->category->id )
->where($db->quoteName('a.published') . '= 1') 
->where($db->quoteName('a.level') . '<=4') 
->join('RIGHT', $db->quoteName('#__contentitem_tag_map', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.content_item_id') . ')' 
) 
->where($db->quoteName('b.type_alias') ."= ".$db->quote('com_content.category'))
->order($db->quoteName('b.content_item_id') . ' ASC '); 
$db->setQuery($query);
$results = $db->loadObjectList();
?>

<?php foreach($results as $row_category) :  ; endforeach; ?>

<?php if (!empty($row_category)): ?>
<div class="col-12">

<?php // если категория пустая ?>
<?php if (empty($this->items)) : ?>
	<ul class="list-prod list-group list-group-flush w-100">
	<?php // шаблон tip_list.php ?>
		<?php include 'tip_list.php'; ?>
	</ul>
<?php else : ?>
	<?php if ($this->category->id == 8): ?>
	<?php //include 'tip_alphabet.php'; ?>
	<?php echo $this->loadTemplate('alphabet'); ?>
	<?php endif; ?>
<?php endif; ?>
		<?php // Code to add a link to submit an article. ?>
		<?php if ($this->category->getParams()->get('access-create')) : ?>
			<?=JHtml::_('icon.create', $this->category, $this->category->params); ?>
		<?php endif; ?>
	<?php // Add pagination links ?>
	<?php if (!empty($this->items)) : ?>
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right">
					<?=$this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
			<?=$this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
</div>
<?php endif; ?>