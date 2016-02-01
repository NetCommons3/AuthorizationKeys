<?php
/**
 * AuthorizationKey::getAuthorizationKeyByContentId()のテスト
 *
 * @property AuthorizationKey $AuthorizationKey
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * AuthorizationKey::getAuthorizationKeyByContentId()のテスト
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\Model\AuthorizationKey
 */
class AuthorizationKeyGetAuthorizationKeyByContentIdTest extends NetCommonsModelTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'authorization_keys';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.authorization_keys.authorization_keys',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'AuthorizationKey';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'getAuthorizationKeyByContentId';

/**
 * getAuthorizationKeyByContentId
 *
 * @param string $modelName モデル名
 * @param int $contentId コンテンツID
 * @param string $additionalId 追加ID
 * @param string $expected 期待値
 * @dataProvider dataProviderGetAuthorizationKeyByContentId
 * @return void
 */
	public function testGetAuthorizationKeyByContentId($modelName, $contentId, $additionalId, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($modelName, $contentId, $additionalId);

		if (is_string($expected)) {
			$this->assertEquals($result[$model]['authorization_key'], $expected);
		} else {
			$this->assertEquals($result, $expected);
		}
	}

/**
 * existsLikeのDataProvider
 *
 * #### 戻り値
 *  - contentKey 取得データ
 *  - expected 期待値
 *  - userId ユーザーID
 *
 * @return array
 */
	public function dataProviderGetAuthorizationKeyByContentId() {
		//$modelName, $contentId, $additionalId = null   expected
		return array(
			array( 'aaa', 1, null, false),
			array( 'test', 1, null, 'test_key'),
			array( 'test', 2, null, false),
			array( 'test', 2, 'a', 'test_key_2'),
			array( 'test', 2, 'b', 'test_key_b'),
		);
	}

}
