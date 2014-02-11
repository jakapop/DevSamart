<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getShopbyID($id,$page=1,$limit=10)
	{

		$sub_select	= parent::select();
		$sub_select->from('ee_category_posts',array('entry_id'));
		$sub_select->where('cat_id in (89)');


/*
field_id_43: "ศูนย์การค้าฟิวเจอร์พาร์ครังสิต ชั้น 2F (ติดกับร้าน Trueshop) เลขที่ 94 ห้องเลขที่ PLZ.2.SHP 013B ต.ประชาธิปัตย์ อ.ธัญบุรี จ.ปทุมธานี 12130",
field_ft_43: "none",
field_id_44: "0-2958-5148, 085-155-3168",
field_ft_44: "none",
field_id_45: "0-2958-5938",
field_ft_45: "none",
field_id_46: "",
field_ft_46: "none",
field_id_47: "",
field_ft_47: "none",
field_id_48: "10.30-20.30",
field_ft_48: "none",
field_id_49: "0",
field_ft_49: "none",
field_id_50: "/ud/shop/1/1/390/.gif",
field_ft_50: "none",
field_id_51: "14.00803",
field_ft_51: "none",
field_id_52: "100.618973",
*/



		$select = parent::select();
		$select->from('ee_weblog_data',array('entry_id'));
		$select->joinleft('ee_weblog_titles','ee_weblog_data.entry_id=ee_weblog_titles.entry_id',array('ee_weblog_titles.title',
			'ee_weblog_titles.year',
			'ee_weblog_titles.month',
			'ee_weblog_titles.day',
			'ee_weblog_data.field_id_43',
			'ee_weblog_data.field_id_44',
			'ee_weblog_data.field_id_45',
			'ee_weblog_data.field_id_48',
			'ee_weblog_data.field_id_50',
			'ee_weblog_data.field_id_51',
			'ee_weblog_data.field_id_52'));
		$select->where(" ee_weblog_data.entry_id IN (".$sub_select->__toString().")" );

		if($id!=null)
		{
			$select->where('ee_weblog_data.entry_id = ?', $id);
		}

		//echo $select->__toString();
		return parent::fetchPage($select,'',$page,$limit);
		//return parent::fetchAll($select);
	}

	public function getArea()
	{

		$select = parent::select();
		$select->from('ee_categories',array('id'=>'cat_id',"name"=>"cat_name"));
		$select->where(" group_id =?",18);

		//echo $select->__toString();
		//return parent::fetchPage($select,'',$page,$limit);
		return parent::fetchAll($select);
	}
}
