<?php

class MyClass {
	public function printHello() {
		return "Original Hello from " . get_class($this);
	}
}

// Create a dynamic subclass that overrides printHello
$dynamicClass = new class extends MyClass {
	// Constructor to accept the closure
	public function __construct(private ?\Closure $closure = null) {
		$this->closure = $closure;
	}

	// Override printHello to call the bound closure
	public function printHello() {
		if ($this->closure === null) {
			throw new RuntimeException("Closure not set");
		}
		return ($this->closure)($this);
	}
};

$replacementClosure = function (MyClass $c) {
	return "Replaced Hello from closure in " . get_class($c);
};

// Instantiate the dynamic class with the closure
$object = new $dynamicClass($replacementClosure);
echo $object->printHello();