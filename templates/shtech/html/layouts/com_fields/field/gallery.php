<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (!key_exists('field', $displayData))
{
	return;
}

$field = $displayData['field'];
$label = JText::_($field->label);
$value = $field->value;
$showLabel = $field->params->get('showlabel');
$labelClass = $field->params->get('label_render_class');
$renderClass = $field->params->get('render_class');

if ($value == '')
{
	return;
}

?>
<?php if ($showLabel == 1) : ?>
	<span class="field-label <?=$labelClass; ?>"><?php echo htmlentities($label, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>: </span>
<?php endif; ?>
<figure role="group" class="gallery">
<?php
foreach (json_decode($field->rawvalue) as $key => $fvalue) :
	$i = 0;
	foreach ($fvalue as $f) :
		$gallerys[$key][$i]=$f;
		$i++;
	endforeach;
endforeach;
foreach ($gallerys as $gallery) : 
$img = $i--; ?>
		<figure class="gallery-fill">
		<?php if (isset($gallery[0]) && !empty($gallery[0]) && isset($gallery[1]) && !empty($gallery[1]) && isset($gallery[2]) && !empty($gallery[2])) : ?>	
			<a href="<?=$gallery[1]?>">
				<img src="<?php echo $gallery[0] ?>" alt="<?php echo $gallery[2] ?>" class="img-fluid">
			</a>
		<?php elseif (!empty($gallery[0])) : ?>
			<a href="<?=$gallery[0]?>">
				<img src="<?php echo $gallery[0] ?>" 
				<?php if (isset($gallery[2]) && !empty($gallery[2])) :?>
					alt="<?php echo $gallery[2] ?>" 
				<?php else: ?>
					alt="images_<?=$img; ?>" 
				<?php endif; ?>
				class="img-fluid">
			</a>		
		<?php endif;
		if (isset($gallery[2]) && !empty($gallery[2])) : 
			echo '<figcaption>'.$gallery[2].'</figcaption>';
		endif; ?>		
		</figure>


<?php endforeach; ?>
</figure>

