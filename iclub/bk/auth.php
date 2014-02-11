<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index_get($id=null)
	{
		echo"index get";

	}

	public function forgot_post()
	{
		$this->api_config	= config_item('api');
		$this->load->model('member_model','m_member');
		$this->load->library('Email','email');

		$email=$this->input->post('email');

		if(!empty($email)){
			$condition=array(
				"email"=>$email
			);
			$memberData=$this->m_member->getMember($condition);
			if(count($memberData)>=1){
				$newPassword=generate_password();
				$mdpassword=md5($newPassword);

				$datamember=array('password' => $mdpassword);
				$entry_id=$this->m_member->setMember($datamember,'update','member_id='.$memberData[0]['member_id'],'ee_members');

				if($entry_id){
					$mail_data=array(
					'fromEmail'=>$this->config->item('email_fromEmail'),
					'fromName'=>$this->config->item('email_fromName'),
					'toEmail'=>$memberData[0]['email'],
					'toName'=>isset($memberData[0]['screen_name'])?$memberData[0]['screen_name']:$memberData[0]['username'],
					'data'=>array(
						'user_name'=>isset($memberData[0]['screen_name'])?$memberData[0]['screen_name']:$memberData[0]['username'],
						'user_email'=>$memberData[0]['email'],
						'user_id'=>$memberData[0]['member_id'],
						'username'=>$memberData[0]['username'],
						'password'=>$newPassword

						)
					);					
					try
					{	
						//print_r($this->load->view("template/email/contact_owner",$mail_data,true));
						if($this->email->send($mail_data,'forgot_email'))
						{
							$code	= 200;
							$response['header']	= array(
								'code'	=> $code,
								'message'	=> $this->api_config[$code]
							);
							$this->response($response);

						}else{
							echo"<span class='txt-red'> ไม่สามารถส่งอีเมลได้ </span>";
						}
					}
					catch( Exception $e )
					{
						error_log("Error page :: ".$e);
					}
				}
			}else{
				$code	= 204;
				$response['header']	= array(
					'code'	=> $code,
					'message'	=> $this->api_config[$code]
				);		
				$this->response($response);
			}
		}else{
			$code	= 402;
			$response['header']	= array(
				'code'	=> $code,
				'message'	=> $this->api_config[$code]
			);		
			$this->response($response);
		}



	}

	public function memberlogin_get()
	{
		$this->api_config	= config_item('api');
		$this->load->model('member_model','m_member');

		$username=$this->input->get_request_header('Username');
		$password=$this->input->get_request_header('Password');
		$flage=strtoupper($this->input->get('social'));

		if(empty($flage)){
			if(empty($username) or empty($password))
			{
				$code	= 402;
				$response['header']	= array(
					'code'	=> $code,
					'message'	=> $this->api_config[$code]
				);		
				$this->response($response);
			}
			$condition=array(
					"username"=>$username,
					"password"=>$password
				);
			$memberData=$this->m_member->getMember($condition);
			if(count($memberData)>=1){
				$code	= 200;
				$response['header']	= array(
					'code'	=> $code,
					'message'	=> $this->api_config[$code]
				);
				$response['data']=$memberData;
				$this->response($response);
			}else{
				$code	= 204;
				$response['header']	= array(
					'code'	=> $code,
					'message'	=> $this->api_config[$code]
				);		
				$this->response($response);
			}
		}else{
			switch ($flage) {
				case 'FB':
					$condition=array(
						"username"=>$username,
						"flage"=>$flage
						);
					$memberData=$this->m_member->getMember($condition);
					if(count($memberData)>=1){
						$code	= 200;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);
						$response['data']=$memberData;
						$this->response($response);
					}else{
						$code	= 204;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);		
						$this->response($response);
					}
					break;

				case 'IG':
					$condition=array(
						"username"=>$username,
						"flage"=>$flage
						);
					$memberData=$this->m_member->getMember($condition);
					if(count($memberData)>=1){
						$code	= 200;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);
						$response['data']=$memberData;
						$this->response($response);
					}else{
						$code	= 204;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);		
						$this->response($response);
					}
					break;

				case 'TW':
					$condition=array(
						"username"=>$username,
						"flage"=>$flage
						);
					$memberData=$this->m_member->getMember($condition);
					if(count($memberData)>=1){
						$code	= 200;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);
						$response['data']=$memberData;
						$this->response($response);
					}else{
						$code	= 204;
						$response['header']	= array(
							'code'	=> $code,
							'message'	=> $this->api_config[$code]
						);		
						$this->response($response);
					}
					break;
				default:
					# code...
					break;
			}
		}

	}

	public function gettoken_get()
	{
		$this->authenticate->appid=$this->input->get('appid');
		$this->authenticate->apikey=$this->input->get('apikey');

		$returnData=$this->authenticate->serialize();

		if($returnData['code']=='200')
		{
			$this->response(array(
				'header'=>$returnData,
				'data'=>array('appid'=>$this->authenticate->appid,"token"=>$this->authenticate->token)));
		}else{
			$this->response($returnData);
		}
	}


	public function login_get()
	{
		$this->input->get('username');
		$this->input->get('password');

	}
}