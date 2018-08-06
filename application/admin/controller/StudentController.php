<?php
namespace app\admin\controller;
use app\common\model\Student;

/**
* 学生类
*/
class StudentController extends TeacherController
{
	
	// function __construct(argument)
	// {
	// 	# code...
	// }
	// 
	

	public function index(){

		$student = Student::paginate();
		$this->assign('students',$student);
		return $this->fetch();

	}
}
