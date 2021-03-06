<?php
/**
 * Init
 */

/**
 * Class Init
 */
class Init extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'init';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'tags' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'ブロックID'),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'tag key | タグKey |  | '),
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'タグ名', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tags_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'tags', 'tags_contents'
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
