<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Iclub extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->api_config = config_item('api');
        //$this->load->library('Elasticsearch');
    }

    public function category_get($id = null) {
        $id = $this->input->get('id');

        $this->load->model('Iclub_model', 'ic_model');
        $code = 200;
        $response['header'] = array(
            'code' => $code,
            'message' => $this->api_config[$code]
        );

        $catMain = config_item('categoryIclub');
        $i = 0;
        foreach ($catMain as $cats => $resultcat) {
            if ($id != "") {
                if ($id == $resultcat) {
                    $data['categoryId'] = $resultcat;
                    $data['categoryName'] = $cats;
                    foreach ($this->ic_model->getIclubByCategory($resultcat) as $items) {
                        $data2['id'] = $items['entry_id'];
                        $data2['modelName'] = $items['title'];

                        $data3[] = $data2;

                        unset($data2);
                    }
                    //$i++;

                    $data['item'] = $data3;
                    $response['data'][] = $data;

                    unset($data);
                }
            } else {
                $data['categoryId'] = $resultcat;
                $data['categoryName'] = $cats;
                foreach ($this->ic_model->getIclubByCategory($resultcat) as $items) {
                    $data2['id'] = $items['entry_id'];
                    $data2['modelName'] = $items['title'];

                    $data3[] = $data2;

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

    public function index_get($id = null) {
        //$id = $this->input->get('id');
        $cat = $this->input->get('cat');
        $page = $this->input->get('page');
        $limit = $this->input->get('limit');

        if ($page == "") {
            $page = 1;
        }

        if ($limit == "") {
            $limit = 10;
        }


        $this->load->model('Iclub_model', 'ic_model');
        $catMain = config_item('categoryIclub');

        if ($id != "" || $id != null) {
            $i = 0;
            $catMainText = "";
            foreach ($catMain as $cats => $resultcat) {
                if ($i != 0) {
                    $catMainText .="," . $resultcat;
                } else {
                    $catMainText .=$resultcat;
                }
                $i++;
            }

            $arrItems = $this->ic_model->getIclubByID($id, $catMainText);

            $code = 200;
            if (count($arrItems) == 0) {
                $code = 204;
            }

            $response['header'] = array(
                'code' => $code,
                'message' => $this->api_config[$code]
            );

           
            foreach ($arrItems as $items) {

//				foreach(unserialize($items['field_id_63']) as $img )
//				{
//					if($img!="" || $img!=null)
//					{
//						$dataIMG[] = config_item('static_url').$img;
//					}
//				}
                if ($items['field_id_63'] != "")
                    $dataIMG[] = config_item('static_url') . $items['field_id_63'];
                if ($items['field_id_65'] != "")
                    $dataIMG[] = config_item('static_url') . $items['field_id_65'];


                $data['id'] = $items['entry_id'];
                $data['title'] = $items['title'];
                $data['startdate'] = $items['year'] . $items['month'] . $items['day'];
                $data['enddate'] = ($items['expiration_date']) ? date('Ymd', $items['expiration_date']) : '';
                $data['picture'] = img_resize($dataIMG, null, null);
                $data['picture_detail'] = '';
                $data['spec'] = str_replace('\n', '\r\n',strip_tags($items['field_id_62']));
                $data['privilege_type'] = '';
                $data['privilege_code'] = '';
                $data['privilege_discount'] = '';
                $data['privilege_detail'] = '';
                
                if ($items['cat_id'] == 111) {
                        $data['privilege_type'] = 'sms';
                        $data['privilege_code'] = '2345679432';
                        $data['privilege_discount'] = 'ลดพิเศษ';
                        $data['privilege_detail'] = '30%';
                    } else if ($items['cat_id'] == 112) {
                        $data['privilege_type'] = 'e-coupon';
                        $data['privilege_code'] = '3456789909';
                        $data['privilege_discount'] = 'รับฟรี';
                        $data['privilege_detail'] = 'เครื่องดื่มขนาดกลาง 1 แก้ว';
                    } else if ($items['cat_id'] == 113) {
                        $data['privilege_type'] = 'code';
                        $data['privilege_code'] = '9876543210';
                        $data['privilege_discount'] = 'แถมฟรี';
                        $data['privilege_detail'] = 'แถมฟรีกระเป๋าน่ารัก หากซื้อสินค้าครบ 500 บาท';
                    } else if ($items['cat_id'] == 115) {
                        $data['privilege_type'] = 'e-coupon';
                        $data['privilege_code'] = '2348473930';
                        $data['privilege_discount'] = 'ลดพิเศษ';
                        $data['privilege_detail'] = '300 บาท หากทานครบ 1000 บาท';
                    }
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
        else {
            if ($cat != "") {

                $data['categoryId'] = "";
                $data['categoryName'] = "";

                //$data['item'] = $this->ic_model->getIclubByCategory($cat, $page, $limit);
                $data3['rows'] = "";
                $result_row = $this->ic_model->getIclubByCategory($cat, $page, $limit);
                foreach ($result_row['rows'] as $items) {
                    $data2['title'] = $items['title'];
                    $data2['entry_id'] = $items['entry_id'];
                    $data2['startdate'] = $items['year'] . $items['month'] . $items['day'];
                    $data2['enddate'] = ($items['expiration_date']) ? date('Ymd', $items['expiration_date']) : '';
                    $data2['picture'] = img_resize($items['picture'], null, null);

                    $data2['picture_detail'] = '';
                    $data2['privilege_type'] = '';
                    $data2['privilege_code'] = '';
                    $data2['privilege_discount'] = '';
                    $data2['privilege_detail'] = '';

                    if ($cat == 111) {
                        $data2['privilege_type'] = 'sms';
                        $data2['privilege_code'] = '2345679432';
                        $data2['privilege_discount'] = 'ลดพิเศษ';
                        $data2['privilege_detail'] = '30%';
                    } else if ($cat == 112) {
                        $data2['privilege_type'] = 'e-coupon';
                        $data2['privilege_code'] = '3456789909';
                        $data2['privilege_discount'] = 'รับฟรี';
                        $data2['privilege_detail'] = 'เครื่องดื่มขนาดกลาง 1 แก้ว';
                    } else if ($cat == 113) {
                        $data2['privilege_type'] = 'code';
                        $data2['privilege_code'] = '9876543210';
                        $data2['privilege_discount'] = 'แถมฟรี';
                        $data2['privilege_detail'] = 'แถมฟรีกระเป๋าน่ารัก หากซื้อสินค้าครบ 500 บาท';
                    } else if ($cat == 115) {
                        $data2['privilege_type'] = 'e-coupon';
                        $data2['privilege_code'] = '2348473930';
                        $data2['privilege_discount'] = 'ลดพิเศษ';
                        $data2['privilege_detail'] = '300 บาท หากทานครบ 1000 บาท';
                    }

                    $data3['rows'][] = $data2;

                    unset($data2);
                }
                $data['item'] = $data3;
                $data['item']['row_count'] = $result_row['row_count'];
                $data['item']['limit_per_page'] = $result_row['limit_per_page'];
                $data['item']['current_page'] = $result_row['current_page'];
                $data['item']['total_page'] = $result_row['total_page'];


                $code = 200;
                if ($data['item']['row_count'] == 0) {
                    $code = 204;
                }
                $response['header'] = array(
                    'code' => $code,
                    'message' => $this->api_config[$code]
                );

                foreach ($catMain as $cats => $resultcat) {
                    if ($cat == $resultcat) {
                        $data['categoryId'] = $resultcat;
                        $data['categoryName'] = $cats;
                    }
                }

                if ($data['item']['row_count'] > 0) {
                    $response['data'][] = $data;
                }

                unset($data);
                //}
            } else {
                //$i=0;
                foreach ($catMain as $cats => $resultcat) {

                    $data['categoryId'] = $resultcat;
                    $data['categoryName'] = $cats;


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
                    $data3['rows'] = "";
                    $result_row = $this->ic_model->getIclubByCategory($resultcat, $page, $limit);
                    foreach ($result_row['rows'] as $items) {
                        $data2['title'] = $items['title'];
                        $data2['entry_id'] = $items['entry_id'];
                        $data2['startdate'] = $items['year'] . $items['month'] . $items['day'];
                        $data2['enddate'] = ($items['expiration_date']) ? date('Ymd', $items['expiration_date']) : '';
                        $data2['picture'] = img_resize($items['picture'], null, null);
                        $data2['picture_detail'] = '';
                        $data2['privilege_type'] = '';
                        $data2['privilege_code'] = '';
                        $data2['privilege_discount'] = '';
                        $data2['privilege_detail'] = '';

                        if ($resultcat == 111) {
                            $data2['privilege_type'] = 'sms';
                            $data2['privilege_code'] = '2345679432';
                            $data2['privilege_discount'] = 'ลดพิเศษ';
                            $data2['privilege_detail'] = '30%';
                        } else if ($resultcat == 112) {
                            $data2['privilege_type'] = 'e-coupon';
                            $data2['privilege_code'] = '3456789909';
                            $data2['privilege_discount'] = 'รับฟรี';
                            $data2['privilege_detail'] = 'เครื่องดื่มขนาดกลาง 1 แก้ว';
                        } else if ($resultcat == 113) {
                            $data2['privilege_type'] = 'code';
                            $data2['privilege_code'] = '9876543210';
                            $data2['privilege_discount'] = 'แถมฟรี';
                            $data2['privilege_detail'] = 'แถมฟรีกระเป๋าน่ารัก หากซื้อสินค้าครบ 500 บาท';
                        } else if ($resultcat == 115) {
                            $data2['privilege_type'] = 'e-coupon';
                            $data2['privilege_code'] = '2348473930';
                            $data2['privilege_discount'] = 'ลดพิเศษ';
                            $data2['privilege_detail'] = '300 บาท หากทานครบ 1000 บาท';
                        }

                        $data3['rows'][] = $data2;

                        unset($data2);
                    }
                    $data['item'] = $data3;
                    $data['item']['row_count'] = $result_row['row_count'];
                    $data['item']['limit_per_page'] = $result_row['limit_per_page'];
                    $data['item']['current_page'] = $result_row['current_page'];
                    $data['item']['total_page'] = $result_row['total_page'];

                    //$data['item'] = $this->ic_model->getIclubByCategory($resultcat, $page, $limit);
                    //print_r($result_row);

                    $code = 200;
                    if (count($result_row) == 0) {
                        $code = 204;
                    }
                    $response['header'] = array(
                        'code' => $code,
                        'message' => $this->api_config[$code]
                    );

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

    public function index_post() {
        
    }

    public function index_put($id = null) {
        if (!is_null($id)) {
            $this->_detail_put($id);
        }
    }

    private function _detal_get($id) {
        
    }

    private function _detal_put($id) {
        
    }

}
