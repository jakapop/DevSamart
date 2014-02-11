<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('elasticsearch');
	}
	
	public function index_get()
	{	
		//$this->benchmark->mark('code_start');
		$search=array(
			"query"=>array(
				"match_phrase"=>array(
					"title"=>array(
						"query"=>"ยอมเลิก"
					)
				)
			)
		);

		$json_search=json_encode($search);

		$search=$this->elasticsearch->advancedquery('titles',$json_search);
		$this->response($search);

		//$this->benchmark->mark('code_end');
		//echo $this->benchmark->elapsed_time('code_start', 'code_end');
	}
	public function index_post()
	{

	}
	
	public function index_put($id=null)
	{
		if(!is_null($id))
		{
			$this->_detail_put($id);
		}


	}
	
	public function search_get()
	{
		$this->response(array('msg'=>"Hello ".__CLASS__." world ",'get'=>$this->input->get()));
	}
	
	private function _detal_get($id)
	{
		
	}
	
	private function _detal_put($id)
	{
		
	}
	
}