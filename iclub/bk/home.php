<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->library('Elasticsearch');
	}
	
	public function index_get($id=null)
	{	
		$this->api_config	= config_item('api');
		if(!is_null($id))
		{
			$this->_detail_get($id);
		}

		$code	= 200;
		$response['header']	= array(
			'code'	=> $code,
			'message'	=> $this->api_config[$code]
		);
		$response['data']=array(
			'Application'=>'REST',
			'status'=>'OK',
			'restsponse'=>'Json',
		);



		//werite restponse Json

		//var_dump('test กาโต้');
		//die();
		$this->response($response);
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