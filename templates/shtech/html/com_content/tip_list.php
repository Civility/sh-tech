<?php
defined('_JEXEC') or die;
/*$fieldVal = array();
foreach($this->item->jcfields as $fval) : 
    $fieldVal[$fval->name] = $fval->value; 
endforeach; */
$customFields = FieldsHelper::getFields('com_content.article',$articleitem, true);
?>
<?php // находим материалы с метками и метки с материалами и объеденяем их по id
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
/*	->select(array('a.id','a.title','a.alias','a.state','a.ordering','a.catid', 'b.type_alias', 'b.tag_id', 'b.content_item_id'))*/
->select(array('a.id', 'a.title','a.alias','a.catid', 'b.tag_id'))
	->from($db->quoteName('#__content', 'a'))
	->where($db->quoteName('a.state') ."= 1")
	->join('INNER', $db->quoteName('#__contentitem_tag_map', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.content_item_id') . ')')
	->where($db->quoteName('b.type_alias') ."= ".$db->quote('com_content.article'))
	->order($db->quoteName('a.ordering') . ' ASC ');
$db->setQuery($query);
$result = $db->loadObjectList();

foreach ($customFields as $field) : 
	if ($field->context == 'com_content.article' && $field->id == 14) :
		$fil_pdf_id = $this->escape($field->id); // выводит pdf id=14
	endif; ?>

	<?php if ($field->context == 'com_content.article' && $field->id == 19) :
		$mini_text_id = $this->escape($field->id);  // выводит mini-text' id=19
	endif; ?>

	<?php $fieldClass[$field->name] = $field->params->get('render_class');?>
<?php endforeach; ?>


<?php foreach($result as $row_article) : 
	if ($row_category->tag_id == $row_article->tag_id) : ?>
		<?php //поиск категории alias ?>
		<?php $query = $db->getQuery(true);
		$query = "SELECT alias FROM `#__categories` WHERE `id`='".$row_article->catid."' AND `published`=1";
		$db->setQuery($query);
		$res = $db->loadObjectList();
		foreach($res as $catid): 
			$link = $this->escape($catid->alias).'/'.$this->escape($row_article->alias); ?>
		<?php endforeach;?>

		<?php //поиск значения поля fields_values ?>
		<?php 
		$query = $db->getQuery(true);
		$query = "SELECT * FROM `#__fields_values` WHERE `item_id`='".$row_article->id."'";
		$db->setQuery($query);
		$fieldslist = $db->loadObjectList();
		foreach($fieldslist as $fields_values): ?>
			<?php if ($fields_values->field_id === $fil_pdf_id ): ?>
				<?php $pdf_val = $this->escape($fields_values->value); ?>
			<?php endif;?>
			<?php if ($fields_values->field_id === $mini_text_id ): ?>
				<?php $mini_text_val = $this->escape($fields_values->value); ?>
			<?php endif;?>
		<?php endforeach;?>
	
		<li class="list-group-item">
			<div class="intro-list">
				<div class="flex-grow-1" itemprop="name">
				<a href="<?=$link;?>" class="title d-block w-100" ><?=$this->escape($row_article->title);?></a>
				<?php if ($fields_values->field_id === $mini_text_id ): ?>
					<?php if (isset($mini_text_val) && !empty($mini_text_val)) : ?>
						<p class="<?=$fieldClass['mini-text']; ?>"><?=$mini_text_val;?></p>
					<?php endif;?>
				<?php endif; ?>
				</div>
				<?php if (!empty($pdf_val)): ?>
				<div class="flex-shrink-1 ml-auto">
					<a href="<?=$pdf_val;?>" target="_blank" class="<?=$fieldClass['pdf']; ?> d-block" download="<?=$this->escape($row_article->title);?>">
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
			</div>
		</li>
<?php endif; 
endforeach; ?>