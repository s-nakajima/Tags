<?php
/**
 * Tag Model
 *
 * @property Block $Block
 * @property Origin $Origin
 * @property Language $Language
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TagsAppModel', 'Tags.Model');

/**
 * Summary for Tag Model
 */
class Tag extends TagsAppModel {


	public $recursive = -1;
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'model' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'origin_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		//'Origin' => array(
		//	'className' => 'Origin',
		//	'foreignKey' => 'origin_id',
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => ''
		//),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// OK
	public function getTagsByContentId($modelName, $contentId) {
		$conditions = array(
			'TagsContent.model' => $modelName,
			'TagsContent.content_id' => $contentId,
		);
		$options = array(
			'conditions' => $conditions,
		);
		$options['joins'] = array(
			array('table' => 'tags_contents',
				'alias' => 'TagsContent',
				'type' => 'LEFT',
				'conditions' => array(
					'Tag.id = TagsContent.tag_id',
				)
			)
		);
		$tags = $this->find('all', $options);
		return $tags;
	}

	// NG
	public function getTagsListByEntryId($entryId) {
		throw new Exception('not implement');

		$tags = $this->getTagsByContentId($entryId);
		$list = array();
		foreach ($tags as $tag) {
			$list[] = $tag['BlogTag'];
		}
		return $list;

	}

	// OK
	public function saveTags($blockId, $modelName, $contentId, $tags) {

		$TagsContent = ClassRegistry::init('Tags.TagsContent');
		if (!is_array($tags)) {
			$tags = array();
		}
		// 存在しないタグを保存
		// タグへのリンクを保存
		$tagNameList = array();
		foreach ($tags as $tag) {
			if (isset($tag['name'])) {
				$tagNameList[] = $tag['name'];
			}
		}
		foreach ($tagNameList as $tagName) {
			//
			$savedTag = $this->findByBlockIdAndName($blockId, $tagName);
			if (!$savedTag) {
				// $tagがないなら保存
				$data = $this->create();

				$data['Tag']['name'] = $tagName;
				$data['Tag']['block_id'] = $blockId;
				$data['Tag']['model'] = $modelName;
				if ($this->save($data)) {
					$savedTag = $this->findById($this->id);
				} else {
					return false;
				}
			}
			// save link
			$link = $TagsContent->create();
			$link['TagsContent']['content_id'] = $contentId;
			$link['TagsContent']['model'] = $modelName;
			$link['TagsContent']['tag_id'] = $savedTag['Tag']['id'];

			if (!$TagsContent->save($link)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * origin_idがセットされてなかったらorigin_id=idとしてアップデート
	 *
	 * @param bool $created created
	 * @param array $options options
	 * @return void
	 */
	public function afterSave($created, $options = array()) {
		if ($created) {
			if (empty($this->data[$this->name]['origin_id'])) {
				// origin_id がセットされてなかったらkey=idでupdate
				$this->originId = $this->data[$this->name]['id'];
				$this->saveField('origin_id', $this->data[$this->name]['id'], array('callbacks' => false)); // ここで$this->dataがリセットされる
			}
		}
	}


}
