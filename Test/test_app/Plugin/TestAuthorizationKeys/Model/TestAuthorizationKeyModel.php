<?php
/**
 * TestAuthorizationKeys Model
 *
 * @property AuthorizationKey $AuthorizationKey
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AuthorizationKeysAppModel', 'AuthorizationKeys.Model');
App::uses('AuthorizationKey', 'AuthorizationKeys.Model');

/**
 * TestAuthorizationKeys Model
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\test_app\Plugin\TestAuthorizationKeys\Model
 */
class TestAuthorizationKeyModel extends CakeTestModel {

/**
 * name
 *
 * @var string
 */
	public $name = 'TestAuthorizationKeyModel';

/**
 * alias
 *
 * @var string
 */
	public $alias = 'TestAuthorizationKeyModel';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'AuthorizationKeys.AuthorizationKey'
	);

}
