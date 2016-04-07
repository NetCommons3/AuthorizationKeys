<?php
/**
 * All AuthKeyPopupButtonHelper Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * All AuthKeyPopupButtonHelper Test suite
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\AtuhorizationKeys\Test\Case\AuthKeyPopupButtonHelper
 */
class AllAuthorizationKeysViewHelperAuthKeyPopupButtonHelperTest extends NetCommonsTestSuite {

/**
 * All AuthKeyPopupButtonHelper Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$name = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s tests', $name));
		$suite->addTestDirectoryRecursive(__DIR__ . DS . 'AuthKeyPopupButtonHelper');
		return $suite;
	}
}
