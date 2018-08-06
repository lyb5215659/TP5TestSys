<?php
namespace app\admin\controller;
use app\common\model\Klass;
use think\Request;
use app\common\model\Teacher;
use app\common\validate;

/**
* 班级
*/
class KlassController extends TeacherController
{
	
	public function index(){
		
		//得到对象实体		
		$klasses = new Klass();

		//取到 查询条件name
		$name=Request::Instance()->param('name');

		//判断查询条件是否非空
		if(!is_null($name)){
			$klasses->where('name','like','%'.$name.'%');
		}
		
		//数据分页显示
		$klasses= $klasses->paginate(4);
		
		//打包数据
		$this->assign('klasses',$klasses);
		
		//渲染数据到view
		return $this->fetch();
	}

	public function add(){
		$teachers = Teacher::all();
		$this->assign('teachers',$teachers);
		return $this->fetch();
	}

	public function insert(){
		$postData = Request::Instance()->post();
		$klass = new Klass($postData);//提示teacher_id 不存在
		// var_dump($klass);
		// $validate = Loader::validate('Klass');//不可用，不知为何？

		// var_dump($validate->check($klass));
		// $res=$klass->validate(true)->save();//不可用，不知为何？
		$res=$klass->save();
		// var_dump($res);
		if($res){
			return $this->success("新增成功！",url('index'));
		}else{
			return $this->error("新增失败！",url('add'));
		}
	}

	public function delete(){
		$id = Request::Instance()->param('id');
		try {
			$res = Klass::where(['id'=>$id])->delete();
			if($res){
				return $this->success("删除成功！",url('index'));
			}else{
				return $this->error("删除失败:".$this->getMessage(),url('index'));
			}
		} catch (\Exception $e) {
			// var_dump($e);
			return $this->error("Exception=删除异常:".$e,url('index'));//系统会返回空异常，删除成功，也会抛异常，不明白
		}catch(\think\Exception\HttpResponseException $e){
			return $this->error("HttpResponseException=删除异常:".$e->getMessage(),url('index'));
		}
	}

	public function edit(){

		//获取编辑数据 ID
		$id = Request::Instance()->param('id');

		//判断id是否获取到
		if(!is_null($id)){
			$klass = Klass::get($id);
		}

		//要编辑的 数据是否获取到
		if(!is_null($klass)){
			$this->assign('klass',$klass);
		}

		//关联的老师信息
		$teachers = Teacher::all();
		$this->assign('teachers',$teachers);

		//渲染数据到view
		return $this->fetch();
	}

	public function save(){
		//获取修改后的数据
		$post_klass = Request::Instance()->post();

		//实例化一个对象
		$klass = new Klass($post_klass);

		//保存数据
		$res=$klass->isUpdate(true)->save();

		if($res==='1'){
			return $this->success("修改成功！",url('index'));
		}else{
			return $this->error("修改失败！".$klass->getError(),url('index'));
		}

	}

}



