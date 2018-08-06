<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
// use app\common\model\Users as UM;//other name
use app\common\model\Teacher;

class TeacherController extends Controller
{

	//更新数据
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
		// $teacher->name = $updateDate["name"];
		// $teacher->sex = $updateDate["sex"];
		// $teacher->username = $updateDate["username"];
		// $teacher->email = $updateDate["email"];
		// $teacher->id = $updateDate["id"];
		// $message="更新成功";
		// //$res=$teacher->allowField(true)->validate(true)->isupdate(true)->save($teacher);
		// var_dump($teacher);
		// $res=$teacher->allowField(true)->isupdate(true)->save($teacher);
		// 
		// 
		$res =Db::table('think_teacher')->where('id',$id)->update(['name'=>$updateDate["name"],'sex'=>$updateDate["sex"],'username'=>$updateDate["username"],'email'=>$updateDate["email"],'password'=>Teacher::encryptPassword($updateDate['password'])]);
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

	//编辑数据
	public function edit(){
		//要编辑的ID
		$id = $this->request->param('id/d');

		//获取数据
		$teacher = Teacher::get($id);

		//要编辑的数据是否存在
		if(is_null($teacher)){
			return "未找到ID为：".$id."的信息";
		}
		//打包数据
		$this->assign('teacher',$teacher);

		//渲染数据到View
		return $this->fetch();


	}

	//删除数据
	public function delete(){
	// 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // /d表示将数值转化为“整形”

        dump($id);
        return ;
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

	//新增数据
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

				if(!Teacher::isLogin()){
					return $this->error('用户未登录，请先登录！',url('login'));
				}
				// var_dump(session::get('teacherId'));
				$teacherId = session::get('teacherId');
				if(is_null($teacherId)){
					$this->redirect('/admin/login');
				}else{
					//获取登录信息 存在session里
					$loginteacher = Teacher::get($teacherId);
					if(!is_null($loginteacher)){
						// $loginInfo = "<li><a href='{:url(/admin/login/logout)}' >欢迎,".$loginteacher['username']."</a></li>";
						$this->assign('loginteacher',$loginteacher['username']);
					}
					//
				// try {
					$name = Request::Instance()->get('name');
					$teacher = new Teacher();
					$teacher->where('name|username','like','%'.$name.'%');
					$teacher = $teacher->paginate(4);
					$this->assign('teachers',$teacher);
					$html = $this->fetch();
					return $html;
				// } catch (\Exception $e) {
				// 	return "系统错误".$e->getMessage();
				// }
				}
			}
		}
