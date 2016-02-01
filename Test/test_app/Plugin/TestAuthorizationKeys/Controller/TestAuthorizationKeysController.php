<?php
/**
 * TestAuthorizationKeys Controller
 *
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AuthorizationKeysAppController', 'AuthorizationKeys.Controller');
App::uses('AuthorizationKeysController', 'AuthorizationKeys.Controller');

/**
 * TestAuthorizationKeys Controller
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\test_app\Plugin\AuthorizationKeys\Controller
 */
class TestAuthorizationKeysController extends AuthorizationKeysController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security' => false,
		'AuthorizationKeys.AuthorizationKey' => array(
			'operationType' => 'redirect',
			'targetAction' => 'index',
			'model' => 'TestAuthorizationKeyModel',
			'contentId' => 1),
	);

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'AuthorizationKeys.AuthorizationKey',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'none_test', 'no_content_test', 'embed');

		if ($this->action == 'none_test') {
			$this->AuthorizationKey->operationType = 'none';
		}
		if ($this->action == 'no_content_test') {
			$this->AuthorizationKey->contentId = null;
		}
		if ($this->action == 'embed') {
			$this->AuthorizationKey->operationType = 'embedding';
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

/**
 * none_test method
 *
 * @return void
 */
	public function none_test() {
	}

/**
 * no_content_test method
 *
 * @return void
 */
	public function no_content_test() {
	}

/**
 * embed method
 *
 * @return void
 */
	public function embed() {
	}
}
