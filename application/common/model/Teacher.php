<?php
namespace app\common\model;
use think\Model;
use think\db\Query;
use think\Session;
/**
* 
*/
class Teacher extends Model
{
	
	//用户登录
	static public function login($username,$password)
	{
		$map = array('username' => $username);
		$teacher = self::get($map);
		if(is_null($teacher)){
			return false;
		}

		if($teacher->checkPassword($password)){
			session('teacherId',$teacher['id']);
			return true;
		}else
		{
			return false;
		}
		
	}

	// 验证密码是否正确
	public function checkPassword($password){
		if($this->getData('password')===$this::encryptPassword($password)){
			return true;
		}
		return false;
	}


	static public function encryptPassword($password){
		// var_dump(sha1(md5($password),"liyuanbing"));
		if(!is_string($password)){
			throw new \Exception("密码非字符串类型,非法输入", 1);
		}
		return sha1(md5($password));
	}

	static public function logout(){
		session::set('teacherId',null);
		return true;
	}

	static function islogin(){
		return true;
	}
}