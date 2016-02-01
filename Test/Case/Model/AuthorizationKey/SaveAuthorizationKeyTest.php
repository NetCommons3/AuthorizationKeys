<?php
/**
 * AuthorizationKey::saveAuthorizationKey()のテスト
 *
 * @property AuthorizationKey $AuthorizationKey
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * AuthorizationKeys::saveAuthorizationKey()のテスト
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\Model\AuthorizationKey
 */
class AuthorizationKeySaveAuthorizationKeyTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveAuthorizationKey';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$data = array(
			'AuthorizationKey' => array(
				'id' => 1,
				'model' => 'test',
				'content_id' => '1',
				'additional_id' => null,
				'authorization_key' => 'test_key_new_save',
			),
		);

		return $data;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//チェック用データ取得
		if (isset($data[$this->$model->alias]['id'])) {
			$before = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
		}

		//テスト実行
		$result = $this->$model->$method($data[$model]['model'], $data[$model]['content_id'], $data[$model]['authorization_key'], $data[$model]['additional_id']);
		$this->assertNotEmpty($result);

		//idのチェック
		if (isset($data[$this->$model->alias]['id'])) {
			$id = $data[$this->$model->alias]['id'];
		} else {
			$id = $this->$model->getLastInsertID();
		}

		//登録データ取得
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $id),
		));

		if (isset($data[$this->$model->alias]['id'])) {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		} else {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created_user');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');

			if ($this->$model->hasField('key')) {
				$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig);
			}
			$before[$this->$model->alias] = array();
		}
		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias],
			array(
				'id' => $id,
			)
		);
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');

		$this->assertEquals($expected, $actual);
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		$newData = $this->__getData();
		$newData = Hash::remove($newData, 'AuthorizationKey.id');
		$newData['AuthorizationKey']['content_id'] = 3;
		$newData['AuthorizationKey']['authorization_key'] = 'test_key_new';
		return array(
			array($this->__getData()), //修正
			array($newData), //新規
		);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data[$model]['model'], $data[$model]['content_id'], $data[$model]['authorization_key'], $data[$model]['additional_id']);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'AuthorizationKeys.AuthorizationKey', 'save'),
		);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnValidationError
 * @return void
 */
	public function testSaveOnValidationError($data, $mockModel, $mockMethod = 'validates') {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);
		$result = $this->$model->$method($data[$model]['model'], $data[$model]['content_id'], $data[$model]['authorization_key'], $data[$model]['additional_id']);
		$this->assertFalse($result);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'AuthorizationKeys.AuthorizationKey'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'model', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'content_id', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'authorization_key', '',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
