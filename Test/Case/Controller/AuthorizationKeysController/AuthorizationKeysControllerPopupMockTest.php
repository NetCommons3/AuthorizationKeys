<?php
/**
 * AuthorizationKeysController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * AuthorizationKeysController Test Case
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\Controller
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class AuthorizationKeysControllerPopupMockTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.authorization_keys.authorization_keys',
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'test_authorization_keys';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'test_authorization_keys';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsControllerTestCase::loadTestPlugin($this, 'AuthorizationKeys', 'TestAuthorizationKeys');
		parent::setUp();
	}

/**
 * アクションのGETテスト
 * POPUPタイプのパターン
 *
 * @return void
 */
	public function testPopupGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'popup',
		);
		$this->setExpectedException('ForbiddenException');
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - OK パターン
 *
 * @return void
 */
	public function testPopupPostOK() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_key' => 'test_key_authorization_fake_model',
				'authorization_hash' => 'authorizationKeyTest')
		);
		$this->controller->Session->expects($this->any())
			->method('read')
			->will($this->returnValue(array('AuthorizationKey' => array('authorization_key' => 'test_key_authorization_fake_model'))));
		$result = $this->_testPostAction('post', $data, array('action' => 'popup', 'block_id' => 1));
		$this->assertTextContains('ok_popup_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - NG パターン 認証キー未入力
 *
 * @return void
 */
	public function testPopupPostNG0() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_hash' => 'authorizationKeyTest')
		);
		$this->controller->Session->expects($this->any())
			->method('read')
			->will($this->returnValue(array('AuthorizationKey' => array('authorization_key' => 'test_key_authorization_fake_model'))));
		$result = $this->_testPostAction('post', $data, array('action' => 'popup', 'block_id' => 1));
		$this->assertTextContains('ng_popup_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - NG パターン
 *
 * @return void
 */
	public function testPopupPostNG1() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_key' => 'idontknow',
				'authorization_hash' => 'authorizationKeyTest')
		);
		$this->controller->Session->expects($this->any())
			->method('read')
			->will($this->returnValue(array('AuthorizationKey' => array('authorization_key' => 'test_key_authorization_fake_model'))));
		$result = $this->_testPostAction('post', $data, array('action' => 'popup', 'block_id' => 1));
		$this->assertTextContains('ng_popup_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - NG パターン ハッシュキーが抜けている
 *
 * @return void
 */
	public function testPopupPostNG2() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_key' => 'idontknow',
			));
		$result = $this->_testPostAction('post', $data, array('action' => 'popup', 'block_id' => 1));
		$this->assertTextContains('ng_popup_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - NG パターン セッションに情報がない
 *
 * @return void
 */
	public function testPopupPostNG3() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_key' => 'test_key_authorization_fake_model',
				'authorization_hash' => 'authorizationKeyTest')
		);
		$result = $this->_testPostAction('post', $data, array('action' => 'popup', 'block_id' => 1));
		$this->assertTextContains('ng_popup_view_ctp', $result);
	}
}
