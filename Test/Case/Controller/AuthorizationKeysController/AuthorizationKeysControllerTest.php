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
class AuthorizationKeysControllerTest extends NetCommonsControllerTestCase {

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
		$this->testAction($url);
		$result = $this->headers['Location'];
		$expected = Router::url(array(
			'plugin' => 'authorization_keys',
			'controller' => 'authorization_keys',
			'action' => 'view',
		), true);
		// 認証キー画面にリダイレクトされたことを確認
		$this->assertEquals($result, $expected);
	}

/**
 * アクションのGETテスト
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
		$result = $this->testAction($url, array('return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('none_test_view_ctp', $result);
	}

/**
 * アクションのGETテスト
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
		$result = $this->testAction($url, array('return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('no_content_test_view_ctp', $result);
	}

/**
 * アクションのGETテスト
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
		$result = $this->testAction($url, array('return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('embed_view_ctp', $result);
	}

}
