<?php
/**
 * Element of authorization keys
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php echo
	$this->NetCommonsForm->input('AuthorizationKey.authorization_key', array(
		'label' => '{{popupLabel}}',
		'placeholder' => '{{popupPlaceholder}}'));
?>
<?php if (isset($authorizationKeyErrorMessage)): ?>
	<div class="has-error">
		<div class="help-block">
			<?php echo $authorizationKeyErrorMessage; ?>
		</div>
	</div>
<?php endif ?>
<?php echo $this->NetCommonsForm->hidden('AuthorizationKey.authorization_hash');
