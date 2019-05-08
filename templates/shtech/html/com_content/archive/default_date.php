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
$params = $this->params;
?>

				<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category')); ?>
				<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
				<dl class="article-info">
						<?php /*
					<dt class="article-info-term">
						<?php // echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?>
					</dt>
						*/?>
					<?php if ($params->get('show_parent_category') && !empty($item->parent_slug)) : ?>
						<dd>
							<div class="parent-category-name">
								<?php $title = $this->escape($item->parent_title); ?>
								<?php if ($params->get('link_parent_category') && !empty($item->parent_slug)) : ?>
									<?php $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)) . '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
								<?php else : ?>
									<?php echo JText::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_category')) : ?>
						<dd>
							<div class="category-name">
								<?php $title = $this->escape($item->category_title); ?>
								<?php if ($params->get('link_category') && $item->catslug) : ?>
									<?php $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
								<?php else : ?>
									<?php echo JText::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>

					<?php if ($params->get('show_publish_date')) : ?>
						<dd class="published">
							<time datetime="<?=JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished"><?=JText::sprintf( JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC')));?></time>
						</dd>
						<?php  /*
						<dd>
							<div class="published">
								<span class="icon-calendar" aria-hidden="true"></span>
								<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'c'); ?>" itemprop="datePublished">
									<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
						*/ ?>
					<?php endif; ?>


					<?php if ($info == 0) : ?>

						<?php if ($params->get('show_modify_date')) : ?>
							<dd>
								<div class="modified">
									<span class="icon-calendar" aria-hidden="true"></span>
									<time datetime="<?php echo JHtml::_('date', $item->modified, 'c'); ?>" itemprop="dateModified">
										<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
									</time>
								</div>
							</dd>
						<?php endif; ?>

						<?php if ($params->get('show_create_date')) : ?>
							<dd>
								<div class="create">
									<span class="icon-calendar" aria-hidden="true"></span>
									<time datetime="<?php echo JHtml::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
										<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'))); ?>
									</time>
								</div>
							</dd>
						<?php endif; ?>

						<?php if ($params->get('show_hits')) : ?>
							<dd>
								<div class="hits">
									<span class="icon-eye-open"></span>
									<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
									<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
								</div>
							</dd>
						<?php endif; ?>
					<?php endif; ?>

				</dl>
			<?php endif; ?>