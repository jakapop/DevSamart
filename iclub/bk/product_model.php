<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getProductByCategory($id,$page=1,$limit=10)
	{

		$sub_select	= parent::select();
		$sub_select->from('ee_category_posts',array('entry_id'));
		$sub_select->where('cat_id=?',$id);

		$select = parent::select();
		$select->from('ee_weblog_titles',array('title','entry_id'));
		$select->where('status = ?', 'open');
		$select->where(" entry_id IN (".$sub_select->__toString().")");
		//$select->limitPage($page, $limit );


		//echo $select->__toString();
		return parent::fetchPage($select,'',$page,$limit);
		//return parent::fetchAll($select);
	}

	public function getProductByID($id,$cat)
	{
		$sub_select	= parent::select();
		$sub_select->from('ee_category_posts',array('entry_id'));
		$sub_select->where('cat_id in ('.$cat.')');

		$select = parent::select();
		$select->from('ee_weblog_data',array('entry_id'));
		$select->joinleft('ee_weblog_titles','ee_weblog_data.entry_id=ee_weblog_titles.entry_id',array('ee_weblog_titles.title',
			'ee_weblog_titles.year',
			'ee_weblog_titles.month',
			'ee_weblog_titles.day',
			'ee_weblog_data.field_id_8',
			'ee_weblog_data.field_id_57',
			'ee_weblog_data.field_id_36',
			'ee_weblog_data.field_id_59',
			'ee_weblog_data.field_id_55',
			'ee_weblog_data.field_id_25',
			'ee_weblog_data.field_id_35',
			'ee_weblog_data.field_id_58',
			'ee_weblog_data.field_id_24',
			'ee_weblog_data.field_id_26',
			'ee_weblog_data.field_id_60',
			'ee_weblog_data.field_id_56'));
		//$select->where('status = ?', 'open');
		$select->where(" ee_weblog_data.entry_id IN (".$sub_select->__toString().")" );

		if($id!=null)
		{
			$select->where('ee_weblog_data.entry_id = ?', $id);
		}
		//echo $select->__toString();
		return parent::fetchAll($select);

	}

}