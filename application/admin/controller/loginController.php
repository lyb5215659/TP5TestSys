<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
// use app\common\model\Users as UM;//other name
use app\common\model\Teacher;

class LoginController extends Controller
{

	public function index(){
		return $this->fetch();
	}

	//登录
	public function login()
	{
		$postData =Request::Instance()->post();
		if(Teacher::login($postData['username'],$postData['password'])){
			return $this->success('登录成功.',url('/admin'));
		}else{
			
			return $this->error('用户名或密码不正确',url('index'));
		}
	}


	 public function logout(){
		if(Teacher::logout()){
			$this->success('登出成功!','index');
		}else{
			$this->error('登出失败!','index');
		}
	}

}
