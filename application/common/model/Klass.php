<?php
namespace app\common\model;
use think\Model;
class Klass extends Model{

	public function getTeacher(){
		// var_dump("get Relationship");
		// echo "执行关联查询</br>";
		$teacherId = $this->getData('teacher_id');
		$teacher = Teacher::get($teacherId);
		return $teacher;
	}
}





