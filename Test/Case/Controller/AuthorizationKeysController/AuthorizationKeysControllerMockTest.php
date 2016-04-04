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
class AuthorizationKeysControllerMockTest extends NetCommonsControllerTestCase {

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
 * index へアクセスしてリダイレクトされるパターン
 *
 * @return void
 */
	public function testIndexGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		);
		$this->testAction($url, array('method' => 'get'));
		$result = $this->headers['Location'];
		$expected = '/authorization_keys/authorization_keys/view';
		// 認証キー画面にリダイレクトされたことを確認
		$this->assertTextContains($expected, $result);
	}

/**
 * アクションのGETテスト
 * index へアクセスして通されるパターン
 *
 * @return void
 */
	public function testIndexGet2() {
		$this->controller->Session->expects($this->any())
			->method('check')
			->will($this->returnValue(true));
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		$this->assertTextContains('index', $result);
	}

/**
 * アクションのGETテスト
 * operationTypeがnoneで何も起こらないタイプのパターン
 *
 * @return void
 */
	public function testNoneGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'none_test',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('none_test_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * content_idが抜けていてなにも動作しないパターン
 *
 * @return void
 */
	public function testNoContentIdGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'no_content_test',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('no_content_test_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * 埋め込みタイプのパターン
 *
 * @return void
 */
	public function testEmbedGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'embed',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('embed_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * 自前guaadタイプのパターン
 *
 * @return void
 */
	public function testGuardGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'key_guard',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));

		// 画面遷移なし
		$this->assertTextContains('guard_view_ctp', $result);
	}

/**
 * アクションのGETテスト
 * editの確認
 *
 * @return void
 */
	public function testEditGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));

		// 画面遷移なし
		$this->assertTextContains('data[AuthorizationKey][authorization_key]', $result);
	}
}
