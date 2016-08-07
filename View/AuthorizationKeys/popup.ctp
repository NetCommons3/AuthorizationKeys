<?php
/**
 * authorization key popup
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<div id="authorizationKey-Popup-<?php echo Current::read('Frame.id'); ?>" >
	<?php echo $this->NetCommonsForm->create(false, array('url' => "$url", 'ng-submit' => 'submit()')); ?>
		<div class="modal-header">
			<button class="close" type="button"
					tooltip="<?php echo __d('net_commons', 'Close'); ?>"
					ng-click="cancel()">
				<span class="glyphicon glyphicon-remove small"></span>
			</button>

			<h4 class="modal-title">{{popupTitle}}</h4>
		</div>

		<div class="modal-body">
			<?php echo $this->element('AuthorizationKeys.authorization_key_popup'); ?>
		</div>

		<div class="modal-footer">
			<div class="text-center">
				<button class="btn btn-default btn-workflow" type="button" ng-click="cancel()"><?php echo __d('net_commons', 'Cancel'); ?></button>
				<button class="btn btn-primary btn-workflow" type="submit"><?php echo __d('net_commons', 'OK'); ?></button>
			</div>
		</div>

	<?php echo $this->NetCommonsForm->end(); ?>

</div>