<?php
declare(strict_types=1);

require_once "../../vendor/autoload.php";
require_once "../../src/galaxygames/ovommand/parameter/parser/ParameterParser.php";

use galaxygames\ovommand\parameter\parser\ParameterParser;

$tests = [
	"131313113716531765371537157351757165765317615375",
	"112313.13131231",
	"                       12",
	"12                       ",
	"adakdjahdhjk1231231hknad.21",
	"12.123.123",
	"131  1231",
];

const RUN_PER_TEST = 500000;
const RUN_WARM_UP = 10;

gc_disable();

foreach ($tests as $i => $test) {
	printf("Test 1 %2d: %s\n", $i + 1, $test);
//	dump(ParameterParser::parsePosition($test));
	$result = null;
	for ($i = 0; $i < RUN_WARM_UP; ++$i) {
		$result = ParameterParser::parseInt($test);
		$result = ParameterParser::parseInt2($test);
		$result = ParameterParser::parseInt3($test);
	}
//	dump($result);
	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parseInt($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R1 : %12.6f ms\n", $runtime / 1e6);

	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parseInt2($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R2 : %12.6f ms\n", $runtime / 1e6);

	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parseInt3($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R3 : %12.6f ms\n", $runtime / 1e6);
}