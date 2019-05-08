<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

$fields = array();

$class  = ' first';
$lang   = JFactory::getLanguage();
$user   = JFactory::getUser();
$groups = $user->getAuthorisedViewLevels();
?>
<?php if (count($this->children[$this->category->id]) > 0) : ?>
	<?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
		<?php // Check whether category access level allows access to subcategories. ?>
		<?php //if (in_array($child->access, $groups)) : ?>
		<?php if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || count($child->getChildren())) :
			if (!isset($this->children[$this->category->id][$id + 1])) : $class = ' last'; endif; ?>
			<?php /*if ($this->maxLevel !== 1) : $borderBottom = ' border-bottom'; endif;*/?>
			<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1): 
				$listFlex = ' d-flex flex-column';
			 endif; ?>
			<li<?php echo ' class="list-group-item'.$listFlex.$class.'"'; ?>>
				<?php $class = ''; ?>
					<?php /*if ($lang->isRtl()) : ?>
					
						<h3 class="page-header item-title" itemprop="name">
							<?php if ($this->params->get('show_cat_num_articles', 1)) : ?>
								<span class="badge badge-info tip hasTooltip" title="<?=JHtml::_('tooltipText', 'COM_CONTENT_NUM_ITEMS_TIP'); ?>">
									<?=$child->getNumItems(true); ?>
								</span>
							<?php endif; ?>
							<a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>"><?=$this->escape($child->title); ?></a>
							<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
								<a href="#category-<?=$child->id; ?>" aria-controls="#category-<?=$child->id; ?>" data-toggle="collapse" data-toggle="button" class="link d-flex justify-content-between py-3" role="button" aria-expanded="false" aria-label="<?=JText::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="check"></span></a>
							<?php endif; ?>
						</h3>
					<?php else : */?>
				<?php if (count($child->getChildren()) !== 0): ?>
					<div class="media flex-wrap">
					<?php endif; ?>
						
						<?php // START-1 вывод категорий с мектами // img + text ?>
						<?php // можно упростить т.к. $child выводит таблицу __categories и проверить с  __contentitem_tag_map 'b.type_alias', 'b.tag_id', 'b.content_item_id'
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query
						    ->select(array('a.id', 'a.published','a.alias','a.level', 'b.type_alias', 'b.tag_id', 'b.content_item_id'))
						    ->from($db->quoteName('#__categories', 'a'))
							->where($db->quoteName('a.id') . '= ' .$child->id ) // id категории = id выводимых категорий в шаблоне
							->where($db->quoteName('a.published') . '= 1') // опубликованные
							->where($db->quoteName('a.level') . '<=4') // вложенность категории 4 ур
						    ->join('RIGHT', $db->quoteName('#__contentitem_tag_map', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.content_item_id') . ')' 
							) // объеденить id категории с id метки категории
						    ->where($db->quoteName('b.type_alias') ."= ".$db->quote('com_content.category')) // что бы выбрать метки только категорий  = com_content.category
						    ->order($db->quoteName('b.content_item_id') . ' ASC '); // сортировка
						$db->setQuery($query);
						$results = $db->loadObjectList();
						foreach($results as $row_category) : endforeach; ?>
						<?php // END-1 поиск категории с мектами. ?>
						<?php if ($this->params->get('show_subcat_desc') == 1) : //показать описание подкатегории ?>
							<?php $img = json_decode($child->params); ?>
							<?php if (!empty($child->description && $img->image)): // если описание и картинка есть
								$colImg = 'col-12 col-lg-5';
								$colDesc = 'col-12 col-lg-7';
							else : 
								$colImg = $colDesc = '12';
							endif; ?>
						<?php if (count($child->getChildren()) !== 0 && $row_category->level > 3 && $this->maxLevel < 4): ?>
							<?php if (!empty($img->image)): ?>
								<div class="img mr-auto mr-lg-3 <?=$colImg;?>" itemprop="image">
									<img src="<?=$img->image;?>" alt="<?=htmlspecialchars($img->image_alt);?>" class="img-fluid"/>
								</div>
							<?php endif ?>
						<?php endif; ?>
								<?php if (count($child->getChildren()) == 0 && $row_category->level > 3 && $this->maxLevel < 4): // нет вложенности и категории больше 3 ?>
							<div class="desc media-body px-0 <?=$colDesc;?>">
								<?php /*<h3 class="page-header item-title"><a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>"><?=$this->escape($child->title); ?></a> */?>
								<h3 class="title" itemprop="name">
										<a href="<?=JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>"><?=$this->escape($child->title); ?></a>
										<?php /*else : ?><?=$this->escape($child->title); */?>
									<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
										<span class="badge badge-info tip hasTooltip" title="<?=JHtml::_('tooltipText', 'COM_CONTENT_NUM_ITEMS_TIP'); ?>"><?=$child->getNumItems(true); ?></span>
									<?php endif; ?>
								</h3>
								<?php //if ($row_category->level !== 4 && $this->maxLevel != 1 && count($child->getChildren()) !== 0 ): ?>
								<?php if ($row_category->level !== 4  && $row_category->level > 3 && $this->maxLevel != 1 && count($child->getChildren()) !== 0): ?>
								<?php if ($child->description) : ?>
									<div class="text" itemprop="description"><?=JHtml::_('content.prepare', $child->description, '', 'com_content.category'); ?></div>
								<?php endif; ?>
							<?php endif; ?>
							</div><?php endif ?>
						<?php endif; ?>
				<?php if (count($child->getChildren()) !== 0): ?>				
				</div>
					<?php endif; ?>
					<?php //if ($row_category->level != 4 && $row_category->level < 5 && $child->getChildren() > 1 ): // start category->lavel > 4 ?>
					<?php if ($this->maxLevel > 1 ) : //категория > 1 ?>
						<div class="lists">
							<a href="#category-<?=$child->id;?>" aria-controls="category-<?=$child->id;?>" data-toggle="collapse" data-toggle="button" class="link d-flex justify-content-between py-3" role="button" aria-expanded="false" aria-label="<?=JText::_('JGLOBAL_EXPAND_CATEGORIES'); ?>">
								<h3 class="title" itemprop="name"><?=$this->escape($child->title); ?></h3>
								<span class="check"></span>
							</a>
							<?php // START-2 вложенности нет, и вывести продукты  $this->maxLevel > max-число ?>
							<?php if (count($child->getChildren()) == false && $this->maxLevel > 1): ?>
								<ul class="list list-prod list-group list-group-flush collapse" id='category-<?=$child->id;?>'>
									<?php // если вложенность категории более 3х , то <ul> нет ?>
									<?php // шаблон tip_list.php ?>
									<?php include 'tip_list.php'; ?>
								</ul>
							<?php endif; ?>
							<?php // END-2 ?>
							<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
								<ul class="list list-group list-group-flush collapse" id="category-<?=$child->id; ?>">
									<?php
									$this->children[$child->id] = $child->getChildren();
									$this->category = $child;
									$this->maxLevel--;
									echo $this->loadTemplate('children');
									$this->category = $child->getParent();
									$this->maxLevel++;
									?>
								</ul>
							<?php endif; ?>
						</div>
					<?php //endif; ?>
					<?php endif; ?>	
				<?php //endif // end category->lavel > 4 ?>
			</li>
		<?php endif; ?>
		<?php //endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
