<?php
defined('_JEXEC') or die;

function modChrome_mi5($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h4'), ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8');
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' col-' . $bootstrapSize : '';

	$headerClass    =  $params->get('header_class');
	$headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8') . '"' : '';

	if (!empty ($module->content)) : ?>
		<?php if ($params->get('moduleclass_sfx')): ?>
			<<?php echo $moduleTag; ?> class="<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8') . $moduleClass; ?>">
		<?php else: ?>
			<<?php echo $moduleTag; ?> class="mod<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8') . $moduleClass; ?>">
		<?php endif ?>
			<?php if ((bool) $module->showtitle) : ?>
				<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</<?php echo $moduleTag; ?>>
	<?php endif;
}
function modChrome_clear($module, &$params, &$attribs)
{
	echo $module->content;
}