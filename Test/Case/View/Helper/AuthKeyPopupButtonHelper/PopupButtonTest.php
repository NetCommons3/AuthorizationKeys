<?php
/**
 * AuthKeyPopupButtonHelper::popupButton()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * AuthKeyPopupButtonHelper::popupButton()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\View\Helper\AuthKeyPopupButtonHelper
 */
class AuthKeyPopupButtonHelperPopupButtonTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'authorization_keys';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストデータ生成
		$viewVars = array();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('NetCommons.AuthKeyPopupButton', $viewVars, $requestData, $params);
	}

/**
 * popupButton()のテスト
 *
 * @return void
 */
	public function testPopupButton() {
		$result = $this->AuthKeyPopupButton->popupButton(array(
			'url' => '/test_plugin/test_controller/test_action'
		));
		$this->assertTextContains('/test_plugin/test_controller/test_action', $result);
		$this->assertTextContains('glyphicon-download', $result);
		$this->assertTextContains('btn btn-success', $result);

		$result = $this->AuthKeyPopupButton->popupButton(array(
			'url' => '/test_plugin/test_controller/test_action2',
			'icon' => 'test_icon',
			'class' => 'btn btn-danger',
			'popup-title' => 'test_popup_title',
			'popup-label' => 'test_popup_label',
			'popup-placeholder' => 'test_popup_placeholder',
		));
		$this->assertTextContains('/test_plugin/test_controller/test_action2', $result);
		$this->assertTextContains('test_icon', $result);
		$this->assertTextContains('btn btn-danger', $result);

		$result = $this->AuthKeyPopupButton->popupButton(array(
			'url' => '/test_plugin/test_controller/test_action3',
			'icon' => '',
		));
		$this->assertTextContains('/test_plugin/test_controller/test_action3', $result);
		$this->assertNotContains('icon', $result);
	}
}
