<?php
class Example {
	function foo() {
		return "foo!\n";
	}
}

// create an Example object
$e = new Example();

// output Example::foo() (before redefine)
echo "Before: " . $e->foo();

// Redefine the 'foo' method
runkit7_method_redefine(
	'Example',
	'foo',
	'',
	'return "bar!\n";',
	RUNKIT7_ACC_PUBLIC
);

// output Example::foo() (after redefine)
echo "After: " . $e->foo();