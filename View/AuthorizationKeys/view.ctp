<?php
/**
 * authorization key key input
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<article>
	<p>
		<?php echo __d('authorization_keys', 'Please enter the authentication key to proceed'); ?>
	</p>
	<?php echo $this->NetCommonsForm->create('AuthorizationKey'); ?>

		<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
		<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>

		<?php echo $this->AuthorizationKey->authorizationKeyInput(); ?>

	<div class="text-center">
		<?php echo $this->BackTo->pageLinkButton(__d('net_commons', 'Cancel'), array('icon' => 'remove')); ?>
		<?php echo $this->NetCommonsForm->button(
		__d('net_commons', 'OK') . ' <span class="glyphicon glyphicon-chevron-right"></span>',
		array(
		'class' => 'btn btn-primary',
		'name' => 'next_' . '',
		)) ?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</article>