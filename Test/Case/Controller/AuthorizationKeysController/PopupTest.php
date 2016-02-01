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
class AuthorizationKeysControllerPopupTest extends NetCommonsControllerTestCase {

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
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'popup',
			'frame_id' => 6));
		if (!empty($urlOptions)) {
			$url .= '&' . $urlOptions[0];
		}

		//URL設定
		$params = array();
		if ($return === 'json') {
			$params['return'] = 'view';
			$params['type'] = 'json';
			if ($exception === 'BadRequestException') {
				$status = 400;
			} elseif ($exception === 'ForbiddenException') {
				$status = 403;
			} else {
				$status = 200;
			}
		} else {
			$params['return'] = $return;
		}
		$params = Hash::merge($params, array('method' => 'get'));

		//テスト実施
		$view = $this->testAction($url, $params);
		if ($return === 'json') {
			$result = json_decode($this->contents, true);
			$this->assertArrayHasKey('code', $result);
			$this->assertEquals($status, $result['code']);
		} else {
			$result = $view;
		}

		if (! $exception && $assert) {
			if ($assert['method'] === 'assertActionLink') {
				$assert['url'] = Hash::merge($url, $assert['url']);
			}

			$this->asserts(array($assert), $result);
		}
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
			'urlOptions' => array('url=test_url'),
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
}