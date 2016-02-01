<?php
/**
 * Element edit form of authorization key
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<?php
	if (! isset($options)) {
		$options = array();
	}
	echo $this->NetCommonsForm->input('AuthorizationKey.authorization_key', array_merge(
		array('label' => false), $options));