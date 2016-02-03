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
class AuthorizationKeysControllerViewTest extends NetCommonsControllerTestCase {

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
	public $plugin = 'authorization_keys';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'authorization_keys';

/**
 * アクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderGet
 * @return void
 */
	public function testViewGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'view',
			'frame_id' => 6,
			'block_id' => 2,
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * アクションのGETテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderGet() {
		$results = array();
		$results[0] = array(
			'urlOptions' => array('authorization_key_hash'),
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[AuthorizationKey][authorization_key]', 'value' => ''),
		);
		$results[1] = array(
			'urlOptions' => array(),
			'assert' => null,
			'exception' => 'BadRequestException',
			'return' => 'json',
		);
		return $results;
	}

/**
 * アクションのGETテスト
 * POPUPタイプのPOS - OK パターン
 *
 * @return void
 */
	public function testPost() {
		$data = array(
			'AuthorizationKey' => array(
				'authorization_key' => 'test_key_authorization_fake_model',
				'authorization_hash' => 'testSession')
		);
		$this->controller->Session->expects($this->any())
			->method('read')
			->will(
				$this->returnValueMap([
					['AuthorizationKey.currentAuthorizationKey.' . 'testSession', array('AuthorizationKey' => array('authorization_key' => 'test_key_authorization_fake_model'))],
					['AuthorizationKey.returnUrl.' . 'testSession', array('http://netcommons.org')],
					['AuthorizationKey.judgement.' . 'testSession', array('OK')],
				]));
		$this->_testPostAction('post', $data, array('action' => 'view', 'block_id' => 2, 'testSession'));
		$result = $this->headers['Location'];

		$this->assertTextContains('netcommons', $result);
	}
}