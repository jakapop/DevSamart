<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Iclub extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->api_config	= config_item('api');
		//$this->load->library('Elasticsearch');
	}
	
	public function category_get($id=null)
	{
		$id = $this->input->get('id');

		$this->load->model('Iclub_model','ic_model');
		$code	= 200;
		$response['header']	= array(
			'code'	=> $code,
			'message'	=>  $this->api_config[$code]
		);

		$catMain = config_item('categoryIclub');
		$i=0;
		foreach($catMain as $cats => $resultcat)
		{
			if($id!="")
			{
				if($id==$resultcat)
				{
					$data['categoryId']	= $resultcat;
					$data['categoryName']	= $cats;
					foreach($this->ic_model->getIclubByCategory($resultcat) as $items)
					{
						$data2['id'] = $items['entry_id'];
						$data2['modelName'] =  $items['title'];

						$data3[]=$data2;

						unset($data2); 
					}
					//$i++;
				
					$data['item'] = $data3;
					$response['data'][] = $data;

					unset($data); 
				}
			}
			else
			{
				$data['categoryId']	= $resultcat;
				$data['categoryName']	= $cats;
				foreach($this->ic_model->getIclubByCategory($resultcat) as $items)
				{
					$data2['id'] = $items['entry_id'];
					$data2['modelName'] =  $items['title'];

					$data3[]=$data2;

					unset($data2); 
				}
				//$i++;
				
				$data['item'] = $data3;
				$response['data'][] = $data;

				unset($data); 
				$i++;
			}
		}

		
		$this->response($response);
	}

	public function index_get($id=null)
	{	
		//$id = $this->input->get('id');
		$cat = $this->input->get('cat');
		$page = $this->input->get('page');
		$limit = $this->input->get('limit');

		if($page=="")
		{
			$page=1;
		}

		if($limit=="")
		{
			$limit=10;
		}


		$this->load->model('Iclub_model','ic_model');
		$catMain = config_item('categoryIclub');

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
                        
                        
                        
			$arrItems = $this->ic_model->getIclubByID($id,$catMainText);
                        
			$code	= 200;
                        if(count($arrItems) == 0){
                            $code = 204;
                        }
                        
			$response['header']	= array(
				'code'	=> $code,
				'message' => $this->api_config[$code]
			);

			foreach($arrItems as $items)
			{

//				foreach(unserialize($items['field_id_63']) as $img )
//				{
//					if($img!="" || $img!=null)
//					{
//						$dataIMG[] = config_item('static_url').$img;
//					}
//				}
                                
                                if($items['field_id_63']!="")
                                $dataIMG[] = config_item('static_url').$items['field_id_63'];
                                if($items['field_id_65']!="")
                                $dataIMG[] = config_item('static_url').$items['field_id_65'];


				$data['id'] =  $items['entry_id'];
				$data['title'] =  $items['title'];
				$data['startdate'] =  $items['year'].$items['month'].$items['day'];
				$data['picture'] = $dataIMG;
                                $data['spec'] = $items['field_id_62'];
//				$data['spec'] =  "<h1>ข้อมูลทั่วไป : </h1>".$items['field_id_57'].
//				"<h1>เกี่ยวกับข้อความ : </h1>".$items['field_id_36'].
//				"<h1>โซเชียลเน็ตเวิร์ค : </h1>".$items['field_id_59'].
//				"<h1>จัดการสมุดโทรศัพท์ : </h1>".$items['field_id_55'].
//				"<h1>แอปพลิเคชั่น : </h1>".$items['field_id_25'].
//				"<h1>หน้าจอ : </h1>".$items['field_id_35'].
//				"<h1>กล้อง : </h1>".$items['field_id_58'].
//				"<h1>มัลติมีเดีย :< /h1>".$items['field_id_24'].
//				"<h1>การเชื่อมต่อ : </h1>".$items['field_id_26'].
//				"<h1>อุปกรณ์ในกล่อง : </h1>".$items['field_id_60'].
//				"<h1>แบตเตอรี่ : </h1>".$items['field_id_56'];



				$response['data'][] = $data;
			}

			//$response['data'][] = $data;
			//unset($data); 



		}
		else
		{
			if($cat!="")
			{
                            
                            $data['categoryId']="";
                            $data['categoryName']="";
                            
                            $data['item'] = $this->ic_model->getIclubByCategory($cat,$page,$limit);
                            
                            $code = 200;
                            if ($data['item']['row_count'] == 0){
                                $code = 204;
                            }
                          
                            
                            $response['header']	= array(
                                    'code'	=> $code,
                                    'message'	=> $this->api_config[$code]
                            );
                            
                            foreach($catMain as $cats => $resultcat)
                            {
                                if($cat==$resultcat){
                                    $data['categoryId']	= $resultcat;
                                    $data['categoryName'] = $cats;
                                }
                            }

                            if($data['item']['row_count'] > 0){
                               $response['data'][] = $data;
                            }

                            unset($data); 
				//}
			}
			else
			{
				//$i=0;
				foreach($catMain as $cats => $resultcat)
				{

						$data['categoryId']	= $resultcat;
						$data['categoryName']	= $cats;


	/*
						foreach($this->ic_model->getIclubByCategory($resultcat,$page,$limit) as $itemsCat)
						{
							print_r($itemsCat);

							$data2['id'] = $itemsCat['entry_id'];
							$data2['modelName'] =  $itemsCat['title'];

							$data3[]=$data2;

							unset($data2); 
						}
						//$i++;
						*/
						$data['item'] = $this->ic_model->getIclubByCategory($resultcat,$page,$limit);
                                                //print_r($data['item']) ;
                                                //echo $data['item']['rows'][0]['picture'];
                                                //die();
						$response['data'][] = $data;


						unset($data); 
						//$i++;

				}
			}
		}
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