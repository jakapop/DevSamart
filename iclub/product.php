<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->api_config	= config_item('api');
		//$this->load->library('Elasticsearch');
	}
	
	/*public function category_get($id=null)
	{
		$id = $this->input->get('id');

		$this->load->model('Product_model','p_model');
		$code	= 200;

		$catMain = config_item('categoryMain');
		$i=0;
		foreach($catMain as $cats => $resultcat)
		{
			if($id!="")
			{
				if($id==$resultcat)
				{
					$data['categoryId']	= $resultcat;
					$data['categoryName']	= $cats;
					foreach($this->p_model->getProductByCategory($resultcat) as $items)
					{
						$data2['id'] = $items['entry_id'];
						$data2['modelName'] =  $items['title'];

						$data3[]=$data2;

						unset($data2); 
					}
					//$i++;
				
					$data['item'] = $data3;
					//$response['data'][] = $data;
					$dataResult[] = $data;
					unset($data); 
				}
			}
			else
			{
				$data['categoryId']	= $resultcat;
				$data['categoryName']	= $cats;
				foreach($this->p_model->getProductByCategory($resultcat) as $items)
				{
					$data2['id'] = $items['entry_id'];
					$data2['modelName'] =  $items['title'];

					$data3[]=$data2;

					unset($data2); 
				}
				//$i++;
				
				$data['item'] = $data3;
				//$response['data'][] = $data;
				$dataResult[] = $data;

				unset($data); 
				$i++;
			}
		}

		$response['header']	= array(
			'code'	=> $code,
			'message'	=>  $this->api_config[$code]
		);

		$response['data']=$dataResult;
		$this->response($response);
	}*/

	public function index_get($id=null)
	{	

		//$id = $this->input->get('id');
		$cat = $this->input->get('cat');
		$page = $this->input->get('page');
		$limit = $this->input->get('limit');


		$code	= 200;


		if($page=="")
		{
			$page=1;
		}


		if($limit=="")
		{
			$limit=10;
		}


		$this->load->model('Product_model','p_model');
		$catMain = config_item('categoryMain');
		if($id!="" || $id!=null)
		{

			$i=0;
			$catMainText = "";
			foreach($catMain as $cats => $resultcat)
			{
				if($i!=0)
				{
					$catMainText .=",".$resultcat;
				}
				else
				{
					$catMainText .=$resultcat;
				}
				$i++;
			}

			$arrItems = $this->p_model->getProductByID($id,$catMainText);

			if(!empty($arrItems))
			{
				foreach($arrItems as $items)
				{

					foreach(unserialize($items['field_id_8']) as $img )
					{
						if($img!="" || $img!=null)
						{
							$dataIMG[] = config_item('static_url').$img;
						}
					}

					$data['id'] =  $items['entry_id'];
					$data['title'] =  $items['title'];
					$data['startdate'] =  $items['year'].$items['month'].$items['day'];
					$data['picture'] = $dataIMG[0];
					$data['spec'] =  "<h1>ข้อมูลทั่วไป : </h1>".$items['field_id_57'].
					"<h1>เกี่ยวกับข้อความ : </h1>".$items['field_id_36'].
					"<h1>โซเชียลเน็ตเวิร์ค : </h1>".$items['field_id_59'].
					"<h1>จัดการสมุดโทรศัพท์ : </h1>".$items['field_id_55'].
					"<h1>แอปพลิเคชั่น : </h1>".$items['field_id_25'].
					"<h1>หน้าจอ : </h1>".$items['field_id_35'].
					"<h1>กล้อง : </h1>".$items['field_id_58'].
					"<h1>มัลติมีเดีย :< /h1>".$items['field_id_24'].
					"<h1>การเชื่อมต่อ : </h1>".$items['field_id_26'].
					"<h1>อุปกรณ์ในกล่อง : </h1>".$items['field_id_60'].
					"<h1>แบตเตอรี่ : </h1>".$items['field_id_56'];



					//$response['data'][] = $data;
					$dataResult[] = $data;
				}
				//$response['data'][] = $data;
				//unset($data); 
			}
			else
			{

				$code	= 204;
				$dataResult[] = array();
			}
		}
		else
		{
			if($cat!="")
			{
				$ResultTrue=0;
				foreach($catMain as $cats => $resultcat)
				{
					if($resultcat==$cat)
					{
						$data['categoryId']	= $resultcat;
						$data['categoryName']	= $cats;
					
						$arrItemsCat = $this->p_model->getProductByCategory($resultcat,$page,$limit);
						if(!empty($arrItemsCat) || $arrItemsCat!="")
						{
							$data['item'] = $arrItemsCat;
							//$response['data'][] = $data;
							$dataResult[] = $data;
							unset($data);

							$ResultTrue=1;
						}
						else
						{
							$code	= 204;
							$dataResult[] = array();
						}
					}
				}

				if($ResultTrue==0)
				{
					$code	= 204;
					$dataResult[] = array();
				}
				
			}
			else
			{
				//$i=0;
				foreach($catMain as $cats => $resultcat)
				{

						$data['categoryId']	= $resultcat;
						$data['categoryName']	= $cats;

						$data['item'] = $this->p_model->getProductByCategory($resultcat,$page,$limit);
						//$response['data'][] = $data;
						$dataResult[] = $data;

						unset($data); 
						//$i++;

				}
			}
		}
		
		$response['header']	= array(
				'code'	=> $code,
				'message'	=> $this->api_config[$code]
		);

		$response['data']=$dataResult;

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