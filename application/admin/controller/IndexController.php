<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
// use app\common\model\Users as UM;//other name
use app\common\model\Teacher;

class IndexController extends Controller
{

	public function update(){
		// var_dump($_POST);
		$teacher = new Teacher();
		$updateDate = Request::Instance()->post();
		// var_dump($updateDate);
		// var_dump($updateDate["name"]);
		$teacher->name = $updateDate["name"];
		$teacher->sex = $updateDate["sex"];
		$teacher->username = $updateDate["username"];
		$teacher->email = $updateDate["email"];
		$teacher->id = $updateDate["id"];
		try {
			$res=$teacher->validate(true)->isupdate(true)->save();
			var_dump($res);
			if(!$res){
				return "更新失败：".$teacher->getError();
			}
		} catch (Exception $e) {
			return "更新失败：".$e->getMessage();
		}
	}


	public function edit(){
		// var_dump(Request::Instance()->param());
		// $id = Request::instance()->param('id/d');
		$id = $this->request->param('id/d');
		$teacher = Teacher::get($id);
		if(is_null($teacher)){
			return "未找到ID为：".$id."的信息";
		}
		$this->assign('teacher',$teacher);
		$html=$this->fetch();
		return $html;	
		

	}


	public function delete(){
	// 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
        	return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Teacher = Teacher::get($id);

        // 要删除的对象不存在
        if (is_null($Teacher)) {
        	return $this->error('不存在id为' . $id . '的教师，删除失败');
        }

        // 删除对象
        if (!$Teacher->delete()) {
        	return $this->error('删除失败:' . $Teacher->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('/admin'));
    }


    public function insert(){

// var_dump($_POST);

    	$postData = Request::Instance()->post();
    	$teacher = new Teacher();
    	$teacher->name = $postData['name'];
    	$teacher->username = $postData["username"];
    	$teacher->sex = $postData["sex"];
    	$teacher->email = $postData["email"];
		$teacher->create_time = $postData["create_time"];//database.php 配置开启自动时间戳
		$status=$teacher->validate(true)->save();
		// $status=$teacher->validate($teacher)->save($teacher->getData());
		// var_dump($status);
		if(false==$status){
			return '新增失败'.$teacher->getError();
		}else{
			return "表单数据已提交到数据库,新增ID为：".$teacher->id;
		}

		//①
		// $teacher = array();
		// $teacher['name']="利息那生";
		// $teacher['username']="lixinasheng";
		// $teacher['sex']='1';
		// $teacher['email']="lixishengan@123.com";
		// $Teacher = new Teacher();
		// $state = $Teacher->data($teacher)->save();
		// return $teacher['name']."成功插入数据库。";
		// var_dump($state);
		// 
		
		//②
		// $teacher = new Teacher();
		// $teacher->name = "李元霸";
		// $teacher->username = "liyuanba";
		// $teacher->sex = "0";
		// $teacher->email = "liyuanba@123.com";
		// $teacher->save();
		// return "新增ID为：".$teacher->id."的数据到数据库";

	}


	public function add(){
		$html=$this->fetch();
		return $html; 

	}

	//后台首页
	public function index(){
		
		//get data
		// $user = Db::name("users")->select();
		
		//see   data
		// var_dump($user);
		
		// $list = Users::list();
		// return json($list);
		//json type
		// echo $user[0]['username'];

		// return json($user[0]['username']);
		$teacher = new Teacher();
		$teacher = $teacher->select();
		// var_dump($user);
		// $js= json($user);
		// return $user;
		// var_dump($user);
		
		// return json($user);
		// return json($user[0]->getData());
		// return json($user[0]->getData('username'));

		// return View();
		// 
// $user->where(['username'=>'lyb521569'])->delete();

// return json($users);
		$this->assign('teacher',$teacher);
		$html = $this->fetch();
		return $html;


		// if(Session::get('userinfo')){
		// 	$info = Request::Instance()->post();
  //   		// return json($userinfo);
		// 	$this->assign('userinfo',$info);
		// 	return $this->fetch();
		// }else{
		// 	$this->Redirect("/admin/index/login");
		// }
	}
	//登录
	public function login()
	{
		// Session::set("name","lyb");
		// $name = Session::get("name");
		// return "somthing".$name;

		return View();
	}


	//登录动作
	public function dologin(){

		if(Request::Instance()->post()){
			$info = Request::Instance()->post();
			// return json($info);
			// session_destroy();
			Session::set("$userinfo",json($info));

			return Redirect("/admin");
		}else{
			return redirect("/admin/index/login");
		}
	}


}
