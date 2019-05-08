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

// For B/C we also add the css classes inline. This will be removed in 4.0.
/*
JFactory::getDocument()->addStyleDeclaration('
	.hide { display: none; }
	.table-noheader { border-collapse: collapse; }
	.table-noheader thead { display: none; }
	');
*/
$tableClass = $this->params->get('show_headings') != 1 ? ' table-noheader' : '';
?>
<?php /*вывод статей в категории, но т.к. все категории пусты кроме "catalog",то
проверяем на пустоту статей и выводим свои статьи по меткам(статья <=> категория + метки), 
что бы появлялось, только в пунктах меню (конкретная категория с конечными товарами) делаем проверку перед "<ul>" */   ?>
<?php

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
// ->select(array('a.id', 'a.published','a.alias','a.level', 'b.type_alias', 'b.tag_id', 'b.content_item_id'))
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
	<form action="<?=htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="col-12 form-inline">
		<?php /*if ($this->params->get('filter_field') !== 'hide' || $this->params->get('show_pagination_limit')) : ?>
		<fieldset class="filters btn-toolbar clearfix">
			<legend class="hide"><?=JText::_('COM_CONTENT_FORM_FILTER_LEGEND'); ?></legend>
			<?php if ($this->params->get('filter_field') !== 'hide') : ?>
				<div class="btn-group">
					<?php if ($this->params->get('filter_field') !== 'tag') : ?>
						<label class="filter-search-lbl element-invisible" for="filter-search">
							<?=JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;'; ?>
						</label>
						<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?=JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?=JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" />
						<?php else : ?>
							<select name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();" >
								<option value=""><?=JText::_('JOPTION_SELECT_TAG'); ?></option>
								<?=JHtml::_('select.options', JHtml::_('tag.options', true, true), 'value', 'text', $this->state->get('filter.tag')); ?>
							</select>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ($this->params->get('show_pagination_limit')) : ?>
					<div class="btn-group pull-right">
						<label for="limit" class="element-invisible">
							<?=JText::_('JGLOBAL_DISPLAY_NUM'); ?>
						</label>
						<?php echo $this->pagination->getLimitBox(); ?>
					</div>
				<?php endif; ?>

				<input type="hidden" name="filter_order" value="" />
				<input type="hidden" name="filter_order_Dir" value="" />
				<input type="hidden" name="limitstart" value="" />
				<input type="hidden" name="task" value="" />
			</fieldset>

			<div class="control-group hide pull-right">
				<div class="controls">
					<button type="submit" name="filter_submit" class="btn btn-primary"><?=JText::_('COM_CONTENT_FORM_FILTER_SUBMIT'); ?></button>
				</div>
			</div>

		<?php endif; */?>

<?php // если категория пустая ?>
<?php if (empty($this->items)) : ?>
<?php /*if ($this->params->get('show_no_articles', 1)) : ?>
<p><?=JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
<?php endif; */?>
<ul class="list-prod list-group list-group-flush w-100">
	<?php // шаблон tip_list.php ?>
	<?php include 'tip_list.php'; ?>
</ul>
<?php else : ?>
<?php // если категория НЕ пустая ?>



	<?php  /*
	<table class="category table table-striped table-bordered table-hover<?php echo $tableClass; ?>">
		<caption class="hide"><?=JText::sprintf('COM_CONTENT_CATEGORY_LIST_TABLE_CAPTION', $this->category->title); ?></caption>
		<thead>
			<tr>
				<th scope="col" id="categorylist_header_title">
					<?=JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder, null, 'asc', '', 'adminForm'); ?>
				</th>
				<?php if ($date = $this->params->get('list_show_date')) : ?>
				<th scope="col" id="categorylist_header_date">
				<?php if ($date === 'created') : ?>
					<?=JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.created', $listDirn, $listOrder); ?>
					<?php elseif ($date === 'modified') : ?>
						<?=JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.modified', $listDirn, $listOrder); ?>
						<?php elseif ($date === 'published') : ?>
						<?=JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
					<?php endif; ?>
				</th>
				<?php endif; ?>
					<?php if ($this->params->get('list_show_author')) : ?>
						<th scope="col" id="categorylist_header_author">
							<?=JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
						</th>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_hits')) : ?>
						<th scope="col" id="categorylist_header_hits">
							<?=JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
						</th>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
						<th scope="col" id="categorylist_header_votes">
							<?=JHtml::_('grid.sort', 'COM_CONTENT_VOTES', 'rating_count', $listDirn, $listOrder); ?>
						</th>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
						<th scope="col" id="categorylist_header_ratings">
							<?=JHtml::_('grid.sort', 'COM_CONTENT_RATINGS', 'rating', $listDirn, $listOrder); ?>
						</th>
					<?php endif; ?>
					<?php if ($isEditable) : ?>
						<th scope="col" id="categorylist_header_edit"><?=JText::_('COM_CONTENT_EDIT_ITEM'); ?></th>
					<?php endif; ?>
				</tr>
		</thead>
		<tbody>
 
*/?>

	<?php /*foreach ($this->items as $i => $article) : ?>
			<?php if ($this->items[$i]->state == 0) : ?>
				<tr class="system-unpublished cat-list-row-<?php echo $i; ?>">
					<?php else : ?>
						<tr class="cat-list-row-<?php echo $i; ?>" >
						<?php endif; ?>
						<td class="list-title">
						<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
							<a href="<?=JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>" class="title d-block w-100">
								<?php echo $this->escape($article->title);?>
							</a>
							<?php if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) : ?>
							<?php $associations = ContentHelperAssociation::displayAssociations($article->id); ?>
							<?php foreach ($associations as $association) : ?>
								<?php if ($this->params->get('flags', 1) && $association['language']->image) : ?>
									<?php $flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
									&nbsp;<a href="<?=JRoute::_($association['item']); ?>"><?php echo $flag; ?></a>&nbsp;
									<?php else : ?>
										<?php $class = 'label label-association label-' . $association['language']->sef; ?>
										&nbsp;<a class="<?php echo $class; ?>" href="<?=JRoute::_($association['item']); ?>"><?=strtoupper($association['language']->sef); ?></a>&nbsp;
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php else : ?>
								<?php
								echo $this->escape($article->title) . ' : ';
								$menu   = JFactory::getApplication()->getMenu();
								$active = $menu->getActive();
								$itemId = $active->id;
								$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
								$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)));
								?>
								<a href="<?php echo $link; ?>" class="register">
									<?=JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
								</a>
								<?php if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) : ?>
								<?php $associations = ContentHelperAssociation::displayAssociations($article->id); ?>
								<?php foreach ($associations as $association) : ?>
									<?php if ($this->params->get('flags', 1)) : ?>
										<?php $flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
										&nbsp;<a href="<?=JRoute::_($association['item']); ?>"><?php echo $flag; ?></a>&nbsp;
										<?php else : ?>
											<?php $class = 'label label-association label-' . $association['language']->sef; ?>
											&nbsp;<a class="' . <?php echo $class; ?> . '" href="<?=JRoute::_($association['item']); ?>"><?=strtoupper($association['language']->sef); ?></a>&nbsp;
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ($article->state == 0) : ?>
								<span class="list-published label label-warning">
									<?=JText::_('JUNPUBLISHED'); ?>
								</span>
							<?php endif; ?>
							<?php if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) : ?>
							<span class="list-published label label-warning">
								<?=JText::_('JNOTPUBLISHEDYET'); ?>
							</span>
						<?php endif; ?>
						<?php if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != JFactory::getDbo()->getNullDate()) : ?>
						<span class="list-published label label-warning">
							<?=JText::_('JEXPIRED'); ?>
						</span>
					<?php endif; ?>
					</td>
					<?php if ($this->params->get('list_show_date')) : ?>
						<td headers="categorylist_header_date" class="list-date small">
							<?php
							echo JHtml::_(
								'date', $article->displayDate,
								$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
							); ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_author', 1)) : ?>
						<td headers="categorylist_header_author" class="list-author">
							<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
							<?php $author = $article->author ?>
							<?php $author = $article->created_by_alias ?: $author; ?>
							<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
							<?=JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
							<?php else : ?>
								<?=JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
							<?php endif; ?>
						<?php endif; ?>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_hits', 1)) : ?>
					<td headers="categorylist_header_hits" class="list-hits">
						<span class="badge badge-info">
							<?=JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
						</span>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
					<td headers="categorylist_header_votes" class="list-votes">
						<span class="badge badge-success">
							<?=JText::sprintf('COM_CONTENT_VOTES_COUNT', $article->rating_count); ?>
						</span>
					</td>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
					<td headers="categorylist_header_ratings" class="list-ratings">
						<span class="badge badge-warning">
							<?=JText::sprintf('COM_CONTENT_RATINGS_COUNT', $article->rating); ?>
						</span>
					</td>
				<?php endif; ?>
				<?php if ($isEditable) : ?>
					<td headers="categorylist_header_edit" class="list-edit">
						<?php if ($article->params->get('access-edit')) : ?>
							<?=JHtml::_('icon.edit', $article, $params); ?>
						<?php endif; ?>
					</td>
				<?php endif; ?>
			</tr>
	<?php endforeach; */?>
	<?php 
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query
	->select(array( 'a.tag_id', 'a.content_item_id','b.id','b.alias', 'c.id'))
		->from($db->quoteName('#__contentitem_tag_map', 'a'))
	/*	->where($db->quoteName('a.content_item_id') . '= ' .$article->id )*/
		->where($db->quoteName('a.type_alias') ."= ".$db->quote('com_content.article'))
		->join('INNER', $db->quoteName('#__content', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.content_item_id') . ')')
		->where($db->quoteName('b.state') ."= 1")
		->where($db->quoteName('b.catid') . '=' .$this->category->id)
		->join('INNER', $db->quoteName('#__tags', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.tag_id') . ')')
		->where($db->quoteName('c.level') ."= 2")
		->where($db->quoteName('c.published') ."= 1")
		->order($db->quoteName('c.lft') . ' ASC ');
	$db->setQuery($query);
	$pryf = $db->loadObjectList();?>
	<div class="row">
	<?php foreach ($pryf  as $cool) : ?>
		<?php foreach ($this->category->tags->itemTags as $itemTags) : //все о метках в категории ?>
			<?php if ($itemTags->id == $cool->tag_id): ?>
			<div class="col-12">
				<u><pre><?php print_r($itemTags->title); ?></pre></u>
			
				<?php foreach ($this->items as $article) : ?>
					<?php if ($cool->content_item_id == $article->id ): ?>
						<pre><mark><?php print_r($article->title); ?></mark></pre>
						<?php foreach ($article->jcfields as $field) : ?>
							<?php if ($field->name == 'pdf'): ?>
								<?php $fieldClass[$field->name] == $field->params->get('render_class'); ?>
								<?php $pdf_val = $this->escape($field->rawvalue); ?>
				<div class="flex-shrink-1 ml-auto">
					<a href="<?=$pdf_val;?>" target="_blank" class="<?=$fieldClass['pdf'];?> d-block" download>
						<svg 
						xmlns="http://www.w3.org/2000/svg"
						xmlns:xlink="http://www.w3.org/1999/xlink"
						width="36px" height="37px">
						<g>
						<path class="cls-1"
						d="M32.243,37.000 L13.840,37.000 C11.766,37.000 10.078,35.309 10.078,33.232 L10.078,29.750 L2.815,30.000 C1.263,30.000 -0.000,28.733 -0.000,27.175 L-0.000,16.869 C-0.000,15.312 1.263,14.045 2.815,14.045 L10.078,14.045 L10.078,3.775 C10.078,1.694 11.766,0.000 13.840,0.000 L25.629,0.000 C25.884,0.000 26.128,0.104 26.305,0.289 L35.744,9.260 C35.888,9.411 35.978,9.606 36.000,9.813 L36.000,33.439 C35.893,35.420 34.249,37.000 32.243,37.000 ZM10.506,18.915 C10.194,18.509 9.838,18.245 9.376,18.123 C9.075,18.042 8.118,18.002 7.127,18.002 L4.014,18.002 L3.983,25.971 L6.111,25.971 L6.142,23.043 L7.204,23.043 C7.942,23.043 8.817,23.004 9.206,22.927 C9.492,22.864 9.773,22.736 10.050,22.543 C10.327,22.350 10.618,22.084 10.798,21.745 C10.978,21.406 11.005,20.989 11.005,20.492 C11.005,19.848 10.818,19.322 10.506,18.915 ZM25.861,2.544 L25.861,9.026 L33.072,9.026 L25.861,2.544 ZM34.128,10.910 L24.923,10.910 C24.404,10.910 23.983,10.488 23.983,9.968 L23.983,1.885 L13.840,1.885 C12.801,1.885 11.955,2.732 11.955,3.775 L11.955,14.045 L27.169,14.045 C28.721,14.045 29.983,15.312 29.983,16.869 L29.983,27.175 C29.983,28.733 28.721,30.000 27.169,30.000 L11.955,29.750 L11.955,33.232 C11.955,34.270 12.801,35.115 13.840,35.115 L32.243,35.115 C33.282,35.115 34.128,34.271 34.128,33.234 L34.128,10.910 ZM11.992,18.002 L11.992,26.033 L15.088,26.033 C15.689,26.033 16.295,25.976 16.654,25.862 C17.135,25.708 17.516,25.555 17.798,25.278 C18.173,24.914 18.585,24.438 18.787,23.849 C18.952,23.366 19.035,22.793 19.035,22.126 C19.035,21.368 18.947,20.730 18.771,20.213 C18.595,19.696 18.338,19.259 18.001,18.902 C17.663,18.545 17.008,18.296 16.535,18.156 C16.183,18.053 15.671,18.002 15.000,18.002 L11.992,18.002 ZM25.172,22.344 L25.172,20.974 L21.993,20.943 L21.993,19.434 L26.018,19.371 L26.018,18.002 L19.989,17.971 L19.989,25.971 L21.993,25.971 L21.993,22.312 L25.172,22.344 ZM17.070,22.055 C17.070,22.680 16.890,23.174 16.780,23.537 C16.670,23.899 16.528,24.097 16.353,24.256 C16.179,24.414 15.960,24.526 15.696,24.592 C15.494,24.644 15.697,24.670 15.243,24.670 L14.027,24.670 L14.027,19.371 L14.759,19.371 C15.422,19.371 15.337,19.397 15.564,19.449 C15.869,19.514 16.245,19.641 16.443,19.829 C16.641,20.017 16.795,20.279 16.905,20.613 C17.015,20.948 17.070,21.429 17.070,22.055 ZM8.321,21.541 C8.104,21.626 7.676,21.668 7.034,21.668 L5.986,21.668 L5.986,19.371 L6.929,19.371 C7.516,19.371 7.907,19.389 8.101,19.426 C8.365,19.474 8.583,19.594 8.755,19.785 C8.928,19.977 9.014,20.220 9.014,20.514 C9.014,20.753 8.953,20.963 8.830,21.144 C8.707,21.324 8.538,21.456 8.321,21.541 Z"/>
						</g>
						</svg>
					</a>
				</div>									
							<?php endif ?>
						<?php endforeach; ?>
					<?php endif ?>
				<?php endforeach; ?>					
			</div>
			<?php endif; ?>
		<?php endforeach; ?>	
	<?php endforeach; ?>
</div>
		<!-- </tbody> -->
<!-- 		</table> -->
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
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>

			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
</form>
<?php endif; ?>