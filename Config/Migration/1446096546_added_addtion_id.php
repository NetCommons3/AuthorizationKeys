<?php
/**
 * Add plugin migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AddedAdditionalId migration
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Config\Migration
 */
class AddedAdditionalId extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_additional_id';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
			'create_field' => array(
				'authorization_keys' => array(
					'additional_id' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'content_id'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'drop_field' => array(
				'authorization_keys' => array('additional_id'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
