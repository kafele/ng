<?php

class Invoice extends CActiveRecord
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
		return '{{invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		 	array('invoicenumber, invoiceamount ', 'required'),
		//	array('invoicenumber, invoiceamount', 'safe'), 
		 	//array('status', 'in', 'range'=>array(1,2,3)),
		 	//array('title', 'length', 'max'=>128),
		//	array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
		//	array('tags', 'normalizeTags'),

		//	array('title, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		//'clientid' => array(self::BELONGS_TO, 'main', 'id'),
		// 'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		// 'mySecondTable' => array(self::HAS_MANY, 'MySecondTable', 'second_table_id'),
		//'tbl_main' => array(self::HAS_MANY, 'client', 'id'),

	 	  //'clientid' => array(self::BELONGS_TO, 'main', 'id'),
		  'client' => array(self::BELONGS_TO, 'Client', 'clientid'),
		 //'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		// 	'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
		// 'commentCount' => array(self::STAT, 'Comment', 'post_id', 'condition'=>'status='.Comment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'invoiceamount' => 'Invoice Amount',
			'invoicenumber' => 'Invoice number',
			'invoicedate' => 'Invoice date',
			
			//'email' => 'email',
			//'status' => 'Status',
			 
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('invoice/view', array(
			'id'=>$this->id,
			//'email'=>$this->email,
			
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
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
		//$this->_oldTags=$this->tags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
	
		if(parent::beforeSave())
		{
		
		
			if($this->isNewRecord)
			{
			//$this->create_time=time();
				//$this->create_time=$this->update_time=time();
				 $this->sellerid=Yii::app()->user->id;
			}
			else{
				//$this->update_time=time();
				}
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
		//Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	
	public function suggestInvoices($keyword,$limit=40)
	{
	 
		$invoices=$this->findAll(array(
			'condition'=>'invoicenumber LIKE :keyword',
			'order'=>'id DESC ',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$invoices=array();
		 foreach($invoices as $invoice)
		 $invoices[]=$invoice->invoicenumber;
		return $invoices;
	}
	
	public function suggestInvoiceNumber( )
	{
	
	 $invoices=$this->findAll(array(
			'condition'=>'invoicenumber >1',
			'order'=>'invoicenumber DESC ',
			'limit'=>1,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		//$invoices=array();
		 foreach($invoices as $invoice)
		 $num=$invoice->invoicenumber;
		 
	     $num=$num+1;
		 
		 return $num;
	}
	
	
	
	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		//$criteria->compare('userid', Yii::app()->user->id ,true);
        //$criteria->compare('userid', 2 ,true);
		//$criteria->compare('status',$this->status);
$criteria->compare('userid',Yii::app()->user->id);
		return new CActiveDataProvider('Invoice', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>' id DESC',
			),
		));
	}
}