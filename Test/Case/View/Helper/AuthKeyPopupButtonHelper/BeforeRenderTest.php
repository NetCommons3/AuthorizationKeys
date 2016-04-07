<?php
/**
 * AuthKeyPopupButtonHelper::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * AuthKeyPopupButtonHelper::beforeRender()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Test\Case\View\Helper\AuthKeyPopupButtonHelper
 */
class AuthKeyPopupButtonHelperBeforeRenderTest extends NetCommonsHelperTestCase {

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
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		$view = new View();
		$htmlHelperMock = $this->getMock('NetCommonsHtmlHelper', ['script'], [$view, array()]);
		$this->AuthKeyPopupButton->NetCommonsHtml = $htmlHelperMock;
		//テスト実施
		// HtmlHelper::script()がコールされる
		$htmlHelperMock->expects($this->once())
			->method('script')
			->with(
				$this->stringContains('/authorization_keys/js/authorization_keys.js'),
				$this->isType('array')
			);

		$this->AuthKeyPopupButton->beforeRender($view);
	}

}
