<?php
/**
 * AuthorizationKey Model Test Case
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
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
/**
 * AuthorizationKeyTest Model Test Case
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\Model
 */
class AuthorizationKeyTest extends NetCommonsModelTestCase {

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
		'plugin.authorization_keys.test_authorization_key_model',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'AuthorizationKeys', 'TestAuthorizationKeys');
		$this->TestAuthorizationKeyModel = ClassRegistry::init('TestAuthorizationKeys.TestAuthorizationKeyModel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TestAuthorizationKeyModel);
		parent::tearDown();
	}

/**
 * test After save
 *
 * @return void
 */
	public function testAfterSave() {
		$FakeModel = ClassRegistry::init('TestAuthorizationKeyModel');

		// 普通にデータセーブ
		$FakeModel->create();
		$data['TestAuthorizationKeyModel']['block_id'] = 1;
		$data['AuthorizationKey'] = array(
			'authorization_key' => 'test_authorization_key',
		);
		$result = $FakeModel->save($data);
		$this->assertInternalType('array', $result);

		// 認証キーを空っぽにされたら
		$result['AuthorizationKey'] = array(
			'authorization_key' => '',
		);
		$result = $FakeModel->save($result);
		$this->assertInternalType('array', $result);

		//Tag save fail
		$mock = $this->getMockForModel('AuthorizationKeys.AuthorizationKey', ['saveAuthorizationKey']);
		$mock->expects($this->once())
			->method('saveAuthorizationKey')
			->will($this->returnValue(false));

		$FakeModel->create();
		$this->setExpectedException('InternalErrorException');
		$FakeModel->save($data);
	}

/**
 * 検索結果に認証キーが付随しているか
 *
 * @return void
 */
	public function testAfterFind() {
		$FakeModel = ClassRegistry::init('TestAuthorizationKeyModel');

		$fake = $FakeModel->findById(1);
		$this->assertEquals($fake['AuthorizationKey']['authorization_key'], 'test_key_authorization_fake_model');
	}

/**
 * オリジナルレコードの削除に付随して認証キーが削除されるか
 *
 * @return void
 */
	public function testDelete() {
		$FakeModel = ClassRegistry::init('TestAuthorizationKeyModel');

		$FakeModel->delete(1);

		$AuthorizationKey = ClassRegistry::init('AuthorizationKey');
		$result = $AuthorizationKey->find('all', array(
			'conditions' => array(
				'model' => 'TestAuthorizationKeyModel',
				'content_id' => 1,
			),
		));
		$this->assertEmpty($result);
	}

}
