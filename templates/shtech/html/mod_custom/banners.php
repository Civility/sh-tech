<?php defined('_JEXEC') or die; 
$menu = $app->getMenu();
$input = JFactory::getApplication()->input;
//$menuname = $menu->getActive()->title;
$menuname = JFactory::getDocument()->title;
//$menualias = $menu->getActive()->alias;
//$urls    =  $input->getInt('Itemid');
$id    =  $input->getInt('id');
$catid    =  $input->get('view');
$menuid = $menu->getActive()->id;
?>

<div class='<?=$catid.'-'.$id ?> <?=$moduleclass_sfx; ?>'>
	<?php if ($menuid != 114) : ?>
		<h2 class="rubric"><?=$menuname?></h2>
	<?php else :?>
		<?=$module->content; ?>
		<div id="map"></div>
	<?php endif?>
</div>