<?php
namespace app\common\validate;
use think\Validate;
/**
* 
*/
class Teacher extends Validate
{
	protected $rule = [
		'email' => 'email',
	];
	// function lists()
	// {
	// 	$list = Db::name('users')->select();
	// 	return $list;
	// }
}