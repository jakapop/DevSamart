<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->api_config	= config_item('api');
		//$this->load->library('Elasticsearch');
	}

	public function contactus_get()
	{	
		

		$code	= 200;
		$response['header']	= array(
			'code'	=> $code,
			'message'	=> $this->api_config[$code]
		);
		$response['data'] = config_item('contactus');
		$this->response($response);
	}


	public function shop_get($id=null)
	{	

		$page = $this->input->get('page');
		$limit = $this->input->get('limit');

		$this->load->model('Service_model','s_model');

		$code	= 200;
		$response['header']	= array(
			'code'	=> $code,
			'message'	=> $this->api_config[$code]
		);
		$response['data'] = $this->s_model->getShopbyID($id,$page,$limit);
		$this->response($response);
	}

	public function area_get()
	{	

		$this->load->model('Service_model','s_model');

		$code	= 200;
		$response['header']	= array(
			'code'	=> $code,
			'message'	=> $this->api_config[$code]
		);
		$response['data'] = $this->s_model->getArea();
		$this->response($response);
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
	
	private function _detal_get($id)
	{
		
	}
	
	private function _detal_put($id)
	{
		
	}
	
}