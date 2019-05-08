<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
?>

<?=(isset($moduleclass_sfx) ? null : '<div class="'.$moduleclass_sfx.'">');?>
	<div class="container">
		<div class="d-flex justify-content-center ml-2">
			<div class="imgslider"></div>
				<div id="show" class="showslider">
					<?php foreach ($list as $item) : 
						$jcFields = FieldsHelper::getFields('com_content.article', $item, true);
						$array = json_decode(json_encode($jcFields), True);
						$fields = [];
						foreach ($array as $field) :?>
							<?php array_push($fields,$field['name'],$field['value'],$field['rawvalue']);
						endforeach;?>
						<div class="media-body">
							<a href="<?=$item->link; ?>">
								<h2 class="page-header"><?=$item->title;?></h2>
							</a>
						
							<span class="sl-text"><?=$fields[4];?></span>
						</div>
					<?php endforeach; ?>
						
			</div>
			
	</div>
<?=(isset($moduleclass_sfx) ? null : '</div>');?>
