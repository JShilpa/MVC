<?php 
class App
{

protected $_controller="home"; //default controller name in controllers folder app/controllers/home.php
protected $_method="index"; //function name in home.php
protected $_params =array(); //parameters passed in index function
//if php version higher than 5.4, we can use array referencing.$_params=[];

public function __construct()
{
		$url=$this->parseUrl();
	

//checks whether file exists in app/controllers
//url http://localhost/Evoke/public/bla/index/abc
//here, it checks whether bla exists.if it does, $_controller is set to bla
	if(file_exists('../app/controllers/'.$url[0].'.php'))
	{
		$this->_controller=$url[0];
		unset($url[0]);					//unset the value from array.
	}
	

	//include the controller file to access the method
	require_once '../app/controllers/'.$this->_controller.'.php'; 
	$this->_controller=new $this->_controller();
	//method_exists takes an object and method name as parameter
	if(isset($url[1]))
	{

		if(method_exists($this->_controller, $url[1]))
		{
				$this->_method=$url[1];
				unset($url[1]);

		}
		
	}

	$this->_params=$url ?array_values($url): array();


	//call back function
	//use call_user_function_array when no of parameters are unknown
	//example
	

// function thisFuncTakesACallback($callbackFunc)
// {
//     echo "I'm going to call $callbackFunc!<br />";
//     $callbackFunc();
// }

// function thisFuncGetsCalled()
// {
//     echo "I'm a callback function!<br />";
// }

// thisFuncTakesACallback( 'thisFuncGetsCalled' );


	call_user_func_array(array($this->_controller,$this->_method), $this->_params);



// class foo {
//     function bar($arg, $arg2) {
//         echo __METHOD__, " got $arg and $arg2\n";
//     }
// }



// $foo = new foo;
// call_user_func_array(array($foo, "bar"), array("three", "four"));



	
}





public function parseUrl()
{


	if(isset($_GET['url']))
	{
		return

			$url=explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
		

	}

	//rtrim($_GET['url'],'/'):rtrim trims whitespaces on right side.Since /is mentioned, it will trim it.
	//filter_var: filter a variable.in this case, we are sanitizing URL. It will sanitize and remove all illegal characters.
	//It allows $-_.+!*'(),{}|\\^~[]`"><#%;/?:@&= 
	//explode: url to be exploded as forward slash.

	//url:http://localhost/Evoke/public/home/index/shilpa/ffff/
	//in .htaccess we have path till public folder. 
	//rtrim gets rid of last forward slash.
	//filter_var sanitizes the URL.
	//explode url as /
	//o/p: Array ( [0] => home [1] => index [2] => shilpa [3] => ffff )
	//here home is our controller. index method in it. shilpa and ff as parameters of index function

}


}










 ?>