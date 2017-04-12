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

		//获取请求的数据
		$updateDate = Request::Instance()->post();
		
		//获取ID
		$id = Request::Instance()->post('id');
		if($id<=0){
			return "系统错误，ID：".$id."不存在";
		}

		//获取模型
		$teacher = Teacher::find($id);
		//判断模型是否存在
		if(is_null($teacher)){
			return "要更新的数据不存在";
		}
		$teacher->name = $updateDate["name"];
		$teacher->sex = $updateDate["sex"];
		$teacher->username = $updateDate["username"];
		$teacher->email = $updateDate["email"];
		$teacher->id = $updateDate["id"];
		$message="更新成功";
		$res=$teacher->allowField(true)->validate(true)->isupdate(true)->save($teacher);
		//更新数据是否成功		
		if($res){
			$this->success('更新成功',url('/admin'));
		}else{
			$message= "更新失败：".$teacher->getError();
			return $message;
		}
		// 	try {
		// 		$res=$teacher->validate(true)->isupdate(true)->save($teacher);
		// 	// var_dump($res);
		// 		if($res==0){
		// 			$message= "更新失败：".$teacher->getError();
		// 		}
		// 	} catch (\Exception $e) {
		// 		$message= "更新异常,：".$e->getMessage();
		// 	}
		// 	return $message;
		// }else{
  //       	 throw new \Exception("所更新的记录不存在", 1);   // 调用PHP内置类时，需要在前面加上 \ 

	}
	public function edit(){
		//要编辑的ID
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
    	$message="新增失败";
    	// try {
    	var_dump(Request::Instance()->post());
    	$postData =Request::Instance()->post();
    	$Teacher = new Teacher();
    	$Teacher->name = $postData['name'];
    	$Teacher->username = $postData["username"];
    	$Teacher->sex = $postData["sex"];
    	$Teacher->email = $postData["email"];
				$Teacher->create_time = $postData["create_time"];//database.php 配置开启自动时间戳
				// $status=$Teacher->Validate(true)->save($Teacher);//这样写 报异常：fields not exists:[connection]，还没搞明白
				$status=$Teacher->Validate(true)->save();
					// $status=$Teacher->validate($Teacher)->save($Teacher->getData());
				var_dump($status);
				if($status==1){
					return $this->success("用户 ".$Teacher->name."新增成功。",url('index'));
				}else{
					$message ='新增失败'.$Teacher->getError();
				}
			// } catch (\think\Exception\HttpResponseException $e) {
			// 	return "新增失败，异常信息：".$e->getMessage();
			// }
			// catch (\Exception $e) {
			// 	return "异常信息：".$e->getMessage();
			// }
			// return $this->error($message);
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
				try {
					$html=$this->fetch();
					return $html; 
				} catch (\Exception $e) {
					return "系统错误".$e->getMessage();
				}


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
				try {
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
				} catch (\Exception $e) {
					return "系统错误".$e->getMessage();
				}



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
