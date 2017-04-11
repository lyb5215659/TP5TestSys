<?php
namespace app\common\validate;
use think\Validate;
/**
* 
*/
class Teacher extends validate
{
	protected $rule = [
		'email' => 'email' ;
	]
	// function lists()
	// {
	// 	$list = Db::name('users')->select();
	// 	return $list;
	// }
}