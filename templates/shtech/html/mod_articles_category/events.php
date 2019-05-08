<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;?>
<<?=$params->get('header_tag');?> class="<?=$params->get('header_class');?>">
<a href="index.php?option=com_content&view=category&layout=blog&id=44?tmpl=component"><?=$module->title;?></a>
</<?=$params->get('header_tag');?>>
<ul class="list-events <?php //echo $moduleclass_sfx; ?>" id="events">
	<?php if ($grouped) : ?>
		<?php foreach ($list as $group_name => $group) : ?>
		<li>
			<div class="group"><?=$group_name; ?></div>
			<ul>
				<?php foreach ($group as $item) : ?>
					<li>
						<?php if ($params->get('link_titles') == 1) : ?>
							<a class="title <?=$item->active; ?>" href="<?=$item->link; ?>">
								<?=$item->title; ?>
							</a>
						<?php else : ?>
							<?=$item->title; ?>
						<?php endif; ?>

						<?php if ($item->displayHits) : ?>
							<span class="hits">
								(<?=$item->displayHits; ?>)
							</span>
						<?php endif; ?>

						<?php if ($params->get('show_author')) : ?>
							<span class="writtenby">
								<?=$item->displayAuthorName; ?>
							</span>
						<?php endif; ?>

						<?php if ($item->displayCategoryTitle) : ?>
							<span class="category">
								<?=$item->displayCategoryTitle; ?>
							</span>
						<?php endif; ?>

						<?php if ($item->displayDate) : ?>
							<span class="date"><?=$item->displayDate;?></span>
						<?php endif; ?>

						<?php if ($params->get('show_introtext')) : ?>
							<p class="text">
								<?=$item->displayIntrotext; ?>
							</p>
						<?php endif; ?>

						<?php if ($params->get('show_readmore')) : ?>
							<p class="event-readmore">
								<a class="title <?=$item->active; ?>" href="<?=$item->link; ?>">
									<?php if ($item->params->get('access-view') == false) : ?>
										<?=JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?=$readmore; ?>
										<?=JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
												<?=JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php endif; ?>
									<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
										<?=JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
									<?php else : ?>
										<?=JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
										<?=JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php endif; ?>
								</a>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	<?php else : ?>
		<?php foreach ($list as $item) : ?>
			<li class="media">
				<?php $img = json_decode($item->images); ?>
				<?php if ($img->image_intro): ?>
					<a class="link <?=$item->active;?>" href="<?=$item->displayCategoryLink.'#anons-'.$item->id;?>">
						<img src="<?=htmlspecialchars($img->image_intro); ?>" alt="<?=htmlspecialchars($img->image_intro_alt); ?>" class='img-fluid' />
					</a>
				<?php endif ?>
				<div class="media-body">
				<?php if ($item->displayHits) : ?>
					<span class="hits">
						(<?=$item->displayHits; ?>)
					</span>
				<?php endif; ?>

				<?php if ($params->get('show_author')) : ?>
					<span class="writtenby">
						<?=$item->displayAuthorName; ?>
					</span>
				<?php endif; ?>

				<?php if ($item->displayCategoryTitle) : ?>
					<span class="category">
						<?=$item->displayCategoryTitle; ?>
					</span>
				<?php endif; ?>

				<?php if ($item->displayDate) : ?>
					<span class="date">
						<?=$item->displayDate; ?>
					</span>
				<?php endif; ?>

				<?php if ($params->get('link_titles') == 1) : ?>
					<a class="title" href="<?=$item->displayCategoryLink.'#anons-'.$item->id;?>"><?=$item->title; ?></a>
				<?php else : ?>
					<?=$item->title; ?>
				<?php endif; ?>

				<?php if ($params->get('show_introtext')) : ?>
					<p class="text">
						<?=$item->displayIntrotext; ?>
					</p>
				<?php endif; ?>
				</div>
				<?php if ($params->get('show_readmore')) : ?>
					<p class="event-readmore text-muted">
						<a class="title <?=$item->active; ?>" href="<?=$item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?=JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?=$readmore; ?>
								<?=JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?=JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
							<?php else : ?>
								<?=JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?=JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					</p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
