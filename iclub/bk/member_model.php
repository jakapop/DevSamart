<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getMember($condition=null,$limit=1,$offset=0,$username=null,$password=null)
	{
		if(is_null($condition['accesstoken']))
		{
			if(!is_null($condition['flage'])){
				switch ($condition['flage']) {
					case 'FB':
						$select = parent::select();
						$select->from('ee_members',array('member_id','screen_name','email',));
						$select->joinleft('ee_member_data','ee_members.member_id=ee_member_data.member_id',array('accesstoken'=>'m_field_id_6'));
				 		$select->where(parent::quoteInto('m_field_id_1=?',$condition['username']));
						break;

					case 'IG':
						$select = parent::select();
						$select->from('ee_members',array('member_id','screen_name','email',));
						$select->joinleft('ee_member_data','ee_members.member_id=ee_member_data.member_id',array('accesstoken'=>'m_field_id_6'));
				 		$select->where(parent::quoteInto('m_field_id_9=?',$condition['username']));
						break;

					case 'TW':
						$select = parent::select();
						$select->from('ee_members',array('member_id','screen_name','email',));
						$select->joinleft('ee_member_data','ee_members.member_id=ee_member_data.member_id',array('accesstoken'=>'m_field_id_6'));
				 		$select->where(parent::quoteInto('m_field_id_4=?',$condition['username']));
						break;

					default:
						# code...
						break;
				}
			}else{
				if(is_null($condition['email']))
				{
					if(is_null($condition['username'])or is_null($condition['password'])){
						return false;
					}
					$select = parent::select();
					$select->from('ee_members',array('member_id','screen_name','email',));
					$select->joinleft('ee_member_data','ee_members.member_id=ee_member_data.member_id',array('accesstoken'=>'m_field_id_6'));
			 		$select->where(parent::quoteInto('username=?',$condition['username']));
			 		$select->where(parent::quoteInto('password=?',md5($condition['password'])));
				}else{
					$select = parent::select();
					$select->from('ee_members');
			 		$select->where(parent::quoteInto('email=?',$condition['email']));
		 		}
	 		}
	 	}else{
			$select = parent::select();
			$select->from('ee_members',array('member_id','screen_name','email',));
			$select->joinleft('ee_member_data','ee_members.member_id=ee_member_data.member_id',
						array('fb_id'=>'m_field_id_1','fb_token'=>'m_field_id_2','fb_retoken'=>'m_field_id_3','fb_status'=>'m_field_id_7','twitter'=>'m_field_id_4','twitter_status'=>'m_field_id_8','instagram'=>'m_field_id_9','instagram_status'=>'m_field_id_10','avatar'=>'m_field_id_5','accesstoken'=>'m_field_id_6'));
	 		$select->where(parent::quoteInto('m_field_id_6=?',$condition['accesstoken']));
	 	}
	 	

		//echo $select->__toString();
		return parent::fetchAll($select);


	}

	public function setMember($data=null,$action=null,$condition=null,$table=null)
	{
		if(is_null($action)){
			return false;
		}

		switch ($action) {
			case 'insert':
				try {
					$id	= parent::insert($table,$data);
					return $id;
				} catch (Exception $e) {
					return false;
				}
				break;

			case 'update':
				try {
					if(empty($condition)){
						return false;
					}
					parent::update($table,$data,$condition);
					return true;
				} catch (Exception $e) {
					return false;
				}
				break;

			case 'delete':
				# code...
				break;

		}
	}

}