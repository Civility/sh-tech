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

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
$fieldVal = array();
foreach($this->item->jcfields as $fval) : 
   // $groupTitle[$fval->name] = $fval->group_title; // группа title
   // $miFieldGroup[$fval->group_id] = $fval->group_id; // группа id
   // $miFieldID[$fval->name] = $fval->id; // id
   // $miFieldClass[$fval->name] = $fval->params->get('render_class');  // class
    $fieldVal[$fval->name] = $fval->title; // заголовок
    $fieldVal[$fval->name] = $fval->value; // значения
    $fieldRaw[$fval->name] = $fval->rawvalue; // значения
    ?>
<?php endforeach;
// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
JHtml::_('behavior.caption');

?>
<div class="item-page<?=$this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="inLanguage" content="<?=($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
    <?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header mb-5">
        <h1> <?=$this->escape($this->params->get('page_heading')); ?> </h1>
    </div>
    <?php endif;
    if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
    {
        echo $this->item->pagination;
    }
    ?>

    <?php // Todo Not that elegant would be nice to group the params ?>
    <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
    || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

    <?php if (!$useDefList && $this->print) : ?>
        <div id="pop-print" class="btn hidden-print">
            <?=JHtml::_('icon.print_screen', $this->item, $params); ?>
        </div>
        <div class="clearfix"> </div>
    <?php endif; ?>
    <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
    <div class="page-header mb-4">
        <?php if ($params->get('show_title')) : ?>
            <h2 itemprop="headline">
                <?=$this->escape($this->item->title); ?>
            </h2>
        <?php endif; ?>
        <?php if ($this->item->state == 0) : ?>
            <span class="label label-warning"><?=JText::_('JUNPUBLISHED'); ?></span>
        <?php endif; ?>
        <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
            <span class="label label-warning"><?=JText::_('JNOTPUBLISHEDYET'); ?></span>
        <?php endif; ?>
        <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
            <span class="label label-warning"><?=JText::_('JEXPIRED'); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if (!$this->print) : ?>
        <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
            <?=JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
        <?php endif; ?>
    <?php else : ?>
        <?php if ($useDefList) : ?>
            <div id="pop-print" class="btn hidden-print">
                <?=JHtml::_('icon.print_screen', $this->item, $params); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
        <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
        <?=JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
    <?php endif; ?>

    <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
        <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

        <?=$this->item->tagLayout->render($this->item->tags->itemTags); ?>
    <?php endif; ?>

    <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
        || (empty($urls->urls_position) && (!$params->get('urls_position')))) : ?>
    <?=$this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php if ($params->get('access-view')) : ?>
    <?php echo JLayoutHelper::render('joomla.content.full_image', $this->item); ?>
    <?php
    if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
        echo $this->item->pagination;
    endif;
    ?>
    <?php if (isset ($this->item->toc)) :
        echo $this->item->toc;
    endif; ?>
<div itemprop="articleBody">
<?php // START основной вывод страницы ?>

    <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
    <?=$this->item->event->afterDisplayTitle; ?>

    <div class="d-flex justify-content-between border-top">
        <?php if ($this->item->event->beforeDisplayContent): ?>
                <?=$this->item->event->beforeDisplayContent; ?>
        <?php elseif ($this->item->event->beforeDisplayContent && $fieldVal['add-title'] || $fieldVal['add-value']) :  ?>
                <?=$this->item->event->beforeDisplayContent; ?>
                <dl class="fields-container">
                    <dd class="field-entry">
                        <h5 class="field-label text-left">
                            <?=$fieldVal['add-title'];?>  
                        </h5>
                    <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>    
                    <?=$this->item->event->afterDisplayContent; ?>
                    </dd>
                </dl>
        <?php else: ?>
            <?php if (isset($fieldVal['add-title']) && !empty($fieldVal['add-title'])) : ?>
            <dl class="fields-container">
                <dd class="field-entry">
                    <h5 class="field-label text-left">
                        <?=$fieldVal['add-title'];?>  
                    </h5>
                <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>    
                <?php if (isset($fieldVal['add-value']) && !empty($fieldVal['add-value'])) : ?>
                    <?=$fieldVal['add-value'];?>
                 <?php endif; ?>
                </dd>
            </dl>
            <?php endif; ?>
        <?php endif ?>
        <?php if (isset($fieldVal['pdf']) && !empty($fieldVal['pdf'])) : ?>
            <span class="download">
            <a href="<?=$fieldRaw['pdf']?>" class="pdf d-block" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36px" height="37px"><g>
                <path class="cls-1"
                d="M32.243,37.000 L13.840,37.000 C11.766,37.000 10.078,35.309 10.078,33.232 L10.078,29.750 L2.815,30.000 C1.263,30.000 -0.000,28.733 -0.000,27.175 L-0.000,16.869 C-0.000,15.312 1.263,14.045 2.815,14.045 L10.078,14.045 L10.078,3.775 C10.078,1.694 11.766,0.000 13.840,0.000 L25.629,0.000 C25.884,0.000 26.128,0.104 26.305,0.289 L35.744,9.260 C35.888,9.411 35.978,9.606 36.000,9.813 L36.000,33.439 C35.893,35.420 34.249,37.000 32.243,37.000 ZM10.506,18.915 C10.194,18.509 9.838,18.245 9.376,18.123 C9.075,18.042 8.118,18.002 7.127,18.002 L4.014,18.002 L3.983,25.971 L6.111,25.971 L6.142,23.043 L7.204,23.043 C7.942,23.043 8.817,23.004 9.206,22.927 C9.492,22.864 9.773,22.736 10.050,22.543 C10.327,22.350 10.618,22.084 10.798,21.745 C10.978,21.406 11.005,20.989 11.005,20.492 C11.005,19.848 10.818,19.322 10.506,18.915 ZM25.861,2.544 L25.861,9.026 L33.072,9.026 L25.861,2.544 ZM34.128,10.910 L24.923,10.910 C24.404,10.910 23.983,10.488 23.983,9.968 L23.983,1.885 L13.840,1.885 C12.801,1.885 11.955,2.732 11.955,3.775 L11.955,14.045 L27.169,14.045 C28.721,14.045 29.983,15.312 29.983,16.869 L29.983,27.175 C29.983,28.733 28.721,30.000 27.169,30.000 L11.955,29.750 L11.955,33.232 C11.955,34.270 12.801,35.115 13.840,35.115 L32.243,35.115 C33.282,35.115 34.128,34.271 34.128,33.234 L34.128,10.910 ZM11.992,18.002 L11.992,26.033 L15.088,26.033 C15.689,26.033 16.295,25.976 16.654,25.862 C17.135,25.708 17.516,25.555 17.798,25.278 C18.173,24.914 18.585,24.438 18.787,23.849 C18.952,23.366 19.035,22.793 19.035,22.126 C19.035,21.368 18.947,20.730 18.771,20.213 C18.595,19.696 18.338,19.259 18.001,18.902 C17.663,18.545 17.008,18.296 16.535,18.156 C16.183,18.053 15.671,18.002 15.000,18.002 L11.992,18.002 ZM25.172,22.344 L25.172,20.974 L21.993,20.943 L21.993,19.434 L26.018,19.371 L26.018,18.002 L19.989,17.971 L19.989,25.971 L21.993,25.971 L21.993,22.312 L25.172,22.344 ZM17.070,22.055 C17.070,22.680 16.890,23.174 16.780,23.537 C16.670,23.899 16.528,24.097 16.353,24.256 C16.179,24.414 15.960,24.526 15.696,24.592 C15.494,24.644 15.697,24.670 15.243,24.670 L14.027,24.670 L14.027,19.371 L14.759,19.371 C15.422,19.371 15.337,19.397 15.564,19.449 C15.869,19.514 16.245,19.641 16.443,19.829 C16.641,20.017 16.795,20.279 16.905,20.613 C17.015,20.948 17.070,21.429 17.070,22.055 ZM8.321,21.541 C8.104,21.626 7.676,21.668 7.034,21.668 L5.986,21.668 L5.986,19.371 L6.929,19.371 C7.516,19.371 7.907,19.389 8.101,19.426 C8.365,19.474 8.583,19.594 8.755,19.785 C8.928,19.977 9.014,20.220 9.014,20.514 C9.014,20.753 8.953,20.963 8.830,21.144 C8.707,21.324 8.538,21.456 8.321,21.541 Z"/></g>
                </svg>
            </a>
            </span>
        <?php endif; ?>
    </div>
    <div class="table-responsive-md"><?=$this->item->text; ?></div>
    <strong class="d-block text-center text-primary lead"><?=JText::_('ATTENTION');?></strong>
</div>
<?php // END основной вывод страницы ?>
    <?php if ($info == 1 || $info == 2) : ?>
        <?php if ($useDefList) : ?>
                <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
            <?=JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
        <?php endif; ?>
        <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
            <?=$this->item->tagLayout->render($this->item->tags->itemTags); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
        echo $this->item->pagination;
    ?>
    <?php endif; ?>
    <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
    <?=$this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php // Optional teaser intro text for guests ?>
    <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
    <?=JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
    <?=JHtml::_('content.prepare', $this->item->introtext); ?>
    <?php // Optional link to let them register to see the whole article. ?>
    <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
    <?php $menu = JFactory::getApplication()->getMenu(); ?>
    <?php $active = $menu->getActive(); ?>
    <?php $itemId = $active->id; ?>
    <?php $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
    <?php $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
    <p class="readmore">
        <a href="<?=$link; ?>" class="register">
        <?php $attribs = json_decode($this->item->attribs); ?>
        <?php
        if ($attribs->alternative_readmore == null) :
            echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
        elseif ($readmore = $attribs->alternative_readmore) :
            echo $readmore;
            if ($params->get('show_readmore_title', 0) != 0) :
                echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
            endif;
        elseif ($params->get('show_readmore_title', 0) == 0) :
            echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
        else :
            echo JText::_('COM_CONTENT_READ_MORE');
            echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
        endif; ?>
        </a>
    </p>
    <?php endif; ?>
    <?php endif; ?>
    <?php
    if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
        echo $this->item->pagination;
    ?>
    <?php endif; ?>
</div>
