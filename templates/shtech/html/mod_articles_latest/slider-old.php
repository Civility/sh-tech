<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php foreach ($list as $as => $item) : 
$img = json_decode($item->images); ?>
	<div class="<?=$moduleclass_sfx;?>" style="background-image:url(/images/slider/<?=$as; ?>.jpg)">
		<div class="container h-100">
			<div class="row align-items-center h-100">
				<?php if ($img->image_fulltext) : ?> 
				<div class="col-3 offset-2">
					<div class="sl_prod_img">
						<img src="<?=$img->image_fulltext; ?>" alt="<?=$img->image_fulltext_alt; ?>" class='img-fluid w-100'>
					</div>
				</div>
				<div class="col-5 desc">
				<?php else : ?>
				<div class="col-9 offset-2 desc">
				<?php endif;?>
					<div class="sl_prod_title">
						<a href="<?=$item->link; ?>">
							<h2 class="title h4 text-uppercase"><?=$item->title;?></h2>
						</a>
					</div>
					<?php if ($item->introtext): ?>
						<spam class="sl_prod_text"><?=$item->introtext;?></span>
					<?php endif; ?>
				</div>
			</div>
		</div>		
	</div>	
<?php endforeach; ?>
