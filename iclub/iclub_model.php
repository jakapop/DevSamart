<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Iclub_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getIclubByCategory($id,$page=1,$limit=10)
	{
                $base_url = config_item('static_url');
		$sub_select	= parent::select();
		$sub_select->from('ee_category_posts',array('entry_id'));
		$sub_select->where('cat_id=?',$id);

		$select = parent::select();
		$select->from('ee_weblog_titles',array('title','entry_id','ee_weblog_titles.year','ee_weblog_titles.month','ee_weblog_titles.day','ee_weblog_titles.expiration_date'));
                $select->joinleft('ee_weblog_data','ee_weblog_data.entry_id=ee_weblog_titles.entry_id',array("CONCAT('$base_url',ee_weblog_data.field_id_63)  as picture"));
                
		$select->where('status = ?', 'open');
		$select->where(" ee_weblog_data.entry_id IN (".$sub_select->__toString().")");
		//$select->limitPage($page, $limit );

		//echo $select->__toString();
                //die();
		return parent::fetchPage($select,'',$page,$limit);
		//return parent::fetchAll($select);
	}

	public function getIclubByID($id,$cat)
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
                        'ee_weblog_titles.expiration_date',
			'ee_weblog_data.field_id_61',
			'ee_weblog_data.field_id_62',
			'ee_weblog_data.field_id_63',
			'ee_weblog_data.field_id_65'));
                $select->joinleft('ee_category_posts','ee_category_posts.entry_id=ee_weblog_titles.entry_id and ee_category_posts.cat_id != "116"',array('ee_category_posts.cat_id'));
		//$select->where('status = ?', 'open');
		$select->where(" ee_weblog_data.entry_id IN (".$sub_select->__toString().")" );

		if($id!=null)
		{
			$select->where('ee_weblog_data.entry_id = ?', $id);
		}
		//echo $select->__toString();
                //die();
		return parent::fetchAll($select);

	}

}