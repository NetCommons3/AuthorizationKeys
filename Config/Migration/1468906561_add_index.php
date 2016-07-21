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
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'authorization_keys' => array('indexes' => array('fk_authorization_key_model1_idx', 'fk_authorization_key_content1_idx')),
			),
			'create_field' => array(
				'authorization_keys' => array(
					'indexes' => array(
						'model' => array('column' => array('model', 'content_id', 'additional_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'create_field' => array(
				'authorization_keys' => array(
					'indexes' => array(
						'fk_authorization_key_model1_idx' => array('column' => 'model', 'unique' => 0),
						'fk_authorization_key_content1_idx' => array('column' => 'content_id', 'unique' => 0),
					),
				),
			),
			'drop_field' => array(
				'authorization_keys' => array('indexes' => array('model')),
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
