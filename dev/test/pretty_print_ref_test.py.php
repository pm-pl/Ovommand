<?php
declare(strict_types=1);
//require_once "..\\..\\vendor\\digitalnature\\php-ref\\ref.php";
//require_once "..\\..\\vendor\\symfony\\var-dumper\\VarDumper.php";

require_once '..\\..\\vendor\\autoload.php';

class D{}

class C{
	public int $a = 0;
	public int $b = 1;
	public int $c = 2;
	public D $d;
}

class B{
	public int $a = 0;
	public int $b = 1;
	public int $c = 2;
	public C $c2;

	public function __construct() {
		$this->c2 = new C();
	}
}

class A{
	public int $a = 0;
	private int|float $b = 0.2;
	public int $c = 0;
	public int $c2 = 0;
	public B $b2;
	public function __construct() {
		$this->b2 = new B();
	}
}

//error_reporting(E_ALL & ~E_DEPRECATED);
//ref::config("maxDepth", 3);
//ref::config("showPrivateMembers", true);
//r([12, [21, "213a" => new A()]]);

dump(new A());