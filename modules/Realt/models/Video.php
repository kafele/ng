<?php

class Video extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_post':
	 * @var integer $id
	 * @var string $title
	 * @var string $content
	 * @var string $tags
	 * @var integer $status
	 * @var integer $create_time
	 * @var integer $update_time
	 * @var integer $author_id
	 */
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{video}}';
	}
	
	    public function behaviors() {
        return array(
            'commentable' => array(
                'class' => 'ext.comment-module.behaviors.CommentableBehavior',
                // name of the table created in last step
                'mapTable' => 'posts_comments_nm',
                // name of column to related model id in mapTable
                'mapRelatedColumn' => 'postId'

            ),
			
			
            'ECompositeUniqueKeyValidatable' => array(
                'class' => 'ECompositeUniqueKeyValidatable',
                'uniqueKeys' => array(
                    'attributes' => 'slug',
                    'errorMessage' => 'Такое значение уже занято'
                )
            ),
     		
			
			
       );
    }
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		   array('category_id', 'required'),
			array('title,  cod_video', 'required'),
			//array('status', 'in', 'range'=>array(1,2,3)),
			array('title', 'length', 'max'=>128),
			array('content', 'length', 'min'=>0),
			//array('*', 'compositeUniqueKeysValidator'),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
			array('cod_video', 'match', 'pattern'=>'|controls=\"true\" poster=\"(.+?)\"><source|is', 'message'=>'Неверный формат кода, не обнаружена ссылка на превью'),

			
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		
		//'VarName'=>array('RelationType', 'ClassName', 'ForeignKey', …дополнительные параметры)
		return array(
		//	'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		//	'comments' => array(self::HAS_MANY, 'VideoComment', 'video_id', 'condition'=>'comments.status='.VideoComment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
		//'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		
		    'category_id' =>array(self::BELONGS_TO, 'category', 'id'),
		
			'videocomments' => array(self::HAS_MANY, 'VideoComment', 'video_id', 'condition'=>'videocomments.status='.VideoComment::STATUS_APPROVED, 'order'=>'videocomments.create_time DESC'),
			'commentCount' => array(self::STAT, 'VideoComment',   'video_id' , 'condition'=>'status='.VideoComment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'cod_video' => 'Код видео',
			'slug' => 'URL',
			'category_id'=> 'ID категории'
			//'create_time' => 'Create Time',
			//'update_time' => 'Update Time',
		//	'author_id' => 'Author',
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('video/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('video/index', 'tag'=>$tag));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		return $comment->save();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
	//echo( $this->title );
	$Video_code_parser = new Video_code_parser();
	$img=$Video_code_parser->parse($this->cod_video); 
	//echo( $img );
if ($img=="Не найдено"){
	$this->status=0;
}	
	$this->photo=$img;
	 
	
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->date_pub=$this->date_last_modified=time();
				//$this->author_id=Yii::app()->user->id;
			}
			else
				$this->date_last_modified=time();
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
	//	Comment::model()->deleteAll('video_id='.$this->id);
		//Tag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	 public function suggestVideo($keyword,$limit=40)
	{
		$videos=$this->findAll(array(
		    'category_id' =>3,
			///'condition'=>'client LIKE :keyword' двоеточие !
			'order'=>'id DESC ',
			'limit'=>$limit,
			//'params'=>array(
			//	 ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			//),
		)); 
		$names=array();
		 foreach($videos as $video)
		 $names[]=   $video-> id;
		return $names;
	}
	
	public function compositeUniqueKeysValidator() {
        $this->validateCompositeUniqueKeys();
    }
	
	
	
	public function search()
	{
		$criteria=new CDbCriteria;

		// $criteria->compare('title',$this->title,true);
  
	//	 $criteria->compare('status',$this->status);
       // $criteria->compare('status',2);
		return new CActiveDataProvider('Video', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, date_last_modified DESC',
			),
		));
	}
}