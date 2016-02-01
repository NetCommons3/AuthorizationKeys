<?php
/**
 * AuthorizationKey::cleanup()のテスト
 *
 * @property AuthorizationKey $AuthorizationKey
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');

/**
 * AuthorizationKey::cleanup()のテスト
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\Model\AuthorizationKey
 */
class AuthorizationKeyCleanupTest extends NetCommonsDeleteTest {

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
	protected $_methodName = 'cleanup';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
		'AuthorizationKey' => array(
			'model' => 'AuthorizationKey',
			'content_id' => 1
		),
	);

/**
 * DeleteのDataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return void
 */
	public function dataProviderDelete() {
		return array(
			array($this->__data),
		);
	}

/**
 * Deleteのテスト
 *
 * @param array $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行前のチェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('model' => $data[$this->$model->alias]['model'], 'content_id' => $data[$this->$model->alias]['content_id']),
		));
		$this->assertNotEquals(0, $count);

		//テスト実行
		$result = $this->$model->$method($this->$model, $data[$model]['content_id']);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('model' => $data[$this->$model->alias]['model'], 'content_id' => $data[$this->$model->alias]['content_id']),
		));
		$this->assertEquals(0, $count);
	}

/**
 * ExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->__data, 'AuthorizationKeys.AuthorizationKey', 'deleteAll'),
		);
	}

/**
 * DeleteのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderDeleteOnExceptionError
 * @return void
 */
	public function testDeleteOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($this->$model, $data[$model]['content_id']);
	}

}
