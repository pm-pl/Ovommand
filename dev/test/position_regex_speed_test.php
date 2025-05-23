<?php
declare(strict_types=1);

require_once "../../vendor/autoload.php";
require_once "../../src/galaxygames/ovommand/parameter/parser/ParameterParser.php";

use galaxygames\ovommand\parameter\parser\ParameterParser;

$patterns = [
	"G00T1" => "([^~^+\-\d\s]*[+-]?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-]*?[^^~\d\s]*)",
//	"G01T1" => "([^~^+\-\d\s]*[+-]*?)([~^+-]?\d+(?:\.\d+)?|[~^])([+-]*?[^^~\d\s]*)",
//	"G02T1" => "([^~^+\-\d\s]*[+-]*?)([~^+-]?\d+(?:\.\d+)?|[~^]?)([+-]*?[^^~\d\s]*)",  // bad #2
//	"G03T1" => "([^\d\s~^+-]*[+-]*?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-][^\d.]|[^^~\d]*)",
//	"G04T1" => "([^\d\s~^+-]*[+-]*)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G05T1" => "([+-][^\d.]|[^\d~^]*)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G06T1" => "([+-][^\d.]|[^\d~^]*)([~^]?[+-]?\d*\.?\d+|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G07T1" => "([+-][^\d.]|[^\d~^]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G08T1" => "([+-]+[^\d.]|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G09T1" => "([+-]+[^\d.]|[^\d~^]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G10T1" => "([+-]+[^\d.]+|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-][^\d.]|[^\d~^]*)",
//	"G11T1" => "([+-]+[^\d.~^]+|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d.~^]+|[^\d~^+-]*)",
//	"G12T1" => "([^\d~^]*|[+-]+[^\d.~^]+)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d.~^]+|[^\d~^+-]*)",
//	"G13T1" => "([^\d~^+-]*(?:[+-]+[^\d.~^]+)?)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d.~^]+|[^\d~^+-]*)",
//	"G14T1" => "([^\d~^+-]*(?:[+-]+[^\d.~^]+)?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-]+[^\d.~^]+|[^\d~^+-]*)", //Modified G13T1
	"G15T1" => "([^\d~^+-]*(?:[+-]+[^\d.]+)?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-]+[^\d.~^]+|[^\d~^+-]*)",
//	"G16T1" => "([^\d~^+-]*(?:[+-]+[^\d.]+)?)([~^]|[~^]?[+-]?\d+(?:\.\d+)?)([+-]+[^\d.~^]+|[^\d~^+-]*)", // Modified G15T1
//	"G17T1" => "((?:[+-]+[^\d.~])?|[^\d~^]*)([~^]|[~^]?[+-]?\d+(?:\.\d+)?)([+-]+[^\d.~^]+|[^\d~^+-]*)", // worked, but slowest (not really, only a few ns to ms)
//	"G18T1" => "([+-]+[^\d.~]?|[^\d~^]*)([~^]|[~^]?[+-]?\d+(?:\.\d+)?)([+-]+[^\d.~^]+|[^\d~^+-]*)",
	"G19T1" => "([+-]+[^\d~]+|[^\d~^+-]*)([~^]|[~^]?[+-]?\d+(?:\.\d+)?)([+-]+[^\d~^]+|[^\d~^+-]*)",
	"G20T1" => "([+-]+[^\d~]+|[^\d~^+-]*)([~^]|[~^]?[+-]?\d+\.?\d*)([+-]+[^\d~^]+|[^\d~^+-]*)", // modified G19T1
	"G21T1" => "([^\d~^+-]*(?:[+-]+[^\d.]+)?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([^\d~^+-]*(?:[+-]+[^\d.]+)?)", // modified G15T1
	"G22T1" => "([+-]+[^\d~]+|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d~^]+|[^\d~^+-]*)",
//	"G00T2" => "([^~^+\-\d\s]*[+-]?)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-]*[^~^\d\s]*)",
//	"G01T2" => "([+-]*?[^~^\d\s]*)([~^]?[+-]?\d+(?:\.\d+)?|[~^])([+-]*?[^~^\d\s]*)",
//	"G02T2" => "([+-]*?[^~^\d]*)([~^]?[+-]?\d+(?:\.\d+)?|[~^]|[\S])",
//	"G03T2" => "([+-]*?[^~^\d]*)([~^]?[+-]?\d+(?:\.\d+)?|[~^\S])",
//	"G04T2" => "([+-]*?[^~^\d]*)([~^]?[+-]?\d+\.?\d*|[~^\S])",
//	"G05T2" => "([+-]*?[^~^\d]*)([~^]?[+-]?\d*\.?\d*)",
//	"G06T2" => "([+-]*?[^~^\d.]*)([~^]?[+-]?\d*\.?\d*)[\s]*",
//	"G07T2" => "([+-]*?[^~^\d]*)([~^]?[+-]?\d*\.?\d*)[\s]*",
//	"G08T2" => "([^~^\d.+-]*|[+-][^\d.])([~^]?[+-]?\d*\.?\d+|[~^])?",  // bad
//	"G09T2" => "([+-][^\d.]|[^~^\d+-]*)([~^]?[+-]?\d*\.?\d+|[~^])?",
//	"G10T2" => "([+-][^\d.]*|[^~^\d\s+-]*)([~^]?[+-]?\d*\.?\d+|[~^])?", // bad, worst
//	"G11T2" => "([^~^\d\s+-]*(?:[+-]+[^\d.])?)([~^]?[+-]?\d*\.?\d+|[~^])?", // bad
//	"G12T2" => "([~^]?[+-]?\d*\.?\d+|[~^])([^~^\d+-]*(?:[+-]+[^\d.])?)",
//	"G00T3" => "([+-]+[^\d.^~]+|[^\d+-]*)([~^]?[+-]?\d+\.?\d*|[~^]*)", // horrible
];

$tests = [
	"~.13 1213 2123",
	"~-.0002 -13.23 +23",
	"13.13 -12.54 13123",
	"891749248749712498798279442142141242187249847 -124987282712412412412897489271449271456 918247981274987129874917249712974719842798712974124789",
	"121239821798729879723313309231208201038108301803180381083081083108308038109380183018038108038103801803810948017964917648716481848 12310831083080381093801830180381080381038018038109480179649176487164818481231232131234414124.2124217648712498874122141241 124124124124124891.312412412746782618746287624142244212",
	"1321319873981739871983718973981739172 .212398127387198731 1.39873219739817398172912",
	"~ ~ ~",
	"~~~",
	"~^~",
	"~^^",
	"^ ^^",
	"^~ ~",
	"~ ~~",
	"~~ ~",
	"~13812739718973911212331 ~ ~1131318761786.812386132798343",
	"~11231231212131331~~1213123.4312312312313",
	"~13213121331^1.42131232323312312312333~",
	"1232123211a 1231213123123122b --212131232133",
	"1123123138726323~~~",
	"--1233421234234134432314131 1234324143241 1312789192",
	"~--121387918273981739817389712383 ~921371793871983719213 887216378162332.287361278368761872",
	"~error error1.3 ^error",
	"~--11.2 -12.312 2131aa",
	"aaa~a---11.2 -12.312 aaa2131aa",
	"---------12312312317283617863~12313123a--asdjhjksahdkjhakjdhakjshdka-------++++~.132213 ~123.123",
	"-+-----~12312312317283617863--------aaaa----------~12313123a--asdjhjksahdkjhakjdhakjshdka-------++++~.132213 ~123.123",
	"&--------12312312317123123131283617863--------~12313112313123a--asdjhjksahdkjhak123123131232312313jdhakjshdka-------++++~.1321232113 ~123.123123123123",
];

const RUN_PER_TEST = 500000;
const RUN_WARM_UP = 10;

gc_disable();

foreach ($tests as $i => $test) {
	printf("Test 1 %2d: %s\n", $i + 1, $test);
//	dump(ParameterParser::parsePosition($test));
	$result = null;
	for ($i = 0; $i < RUN_WARM_UP; ++$i) {
		$result = ParameterParser::parsePosition($test);
		$result = ParameterParser::parsePosition2($test);
//		$result = ParameterParser::parsePosition3($test);
	}
//	dump($result);
	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parsePosition($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R1 : %12.6f ms\n", $runtime / 1e6);

	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parsePosition2($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R2 : %12.6f ms\n", $runtime / 1e6);

	$runtime = hrtime(true);
	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
		$result = ParameterParser::parsePosition2b($test);
	}
	$runtime = hrtime(true) - $runtime;
	printf("R2b: %12.6f ms\n", $runtime / 1e6);

//	$runtime = hrtime(true);
//	for ($i = 0; $i < RUN_PER_TEST; ++$i) {
//		$result = ParameterParser::parsePosition3($test);
//	}
//	$runtime = hrtime(true) - $runtime;
//	printf("R3 : %.6f ms\n", $runtime / 1e6);
}

$benchmarks = [];

foreach ($tests as $n => $test) {
	usleep(10);
	printf("Test %d: \"%s\"\n", $n + 1, $test);
	$benchmark = [];
	foreach ($patterns as $name => $pattern) {
		usleep(1);
		$input_pattern = "/{$pattern}/";
		printf("\"%s\": ", $name);
		$result = false;
		for ($i = 0; $i < RUN_WARM_UP; ++$i) {
			$result = test_parse_speed($test, $input_pattern);
		}
		$runtime = hrtime(true);
		for ($i = 0; $i < RUN_PER_TEST; ++$i) {
			$result = test_parse_speed($test, $input_pattern);
		}
		$runtime = hrtime(true) - $runtime;
		if ($result === false) {
			printf("! %.6f ms\n", $runtime / 1e6);
		} else {
			printf("  %.6f ms\n", $runtime / 1e6);
		}
		$benchmark[$name] = $runtime / 1e6;
	}
	asort($benchmark, SORT_NUMERIC);
	$benchmarks[$n] = $benchmark;
}

gc_enable();

printf("\n----------==========TEST-LIST==========----------\n");

foreach ($tests as $i => $test) {
	printf("Test %2d: %s\n", $i + 1, $test);
}

function redmsg(string $msg) : string{
	return "\033[01;31m" . $msg . "\033[0m";
}

$points = [];

printf("\n----------==========SCOREBOARD=========----------\n");
$len = count($patterns);
printf("Test | %s |     Best     |   Worst   |  Average \n", str_repeat(" ", 8 * $len - 3));
foreach ($benchmarks as $test => $benchmark) {
	$i = 0;
	foreach ($benchmark as $k => $_) {
		$i++;
		$points[$k] ??= 0;
		$points[$k] += $len - $i;
	}
	$array_values = array_values($benchmark);
	printf(" %3d | %s | %9.6f ms | %9.6f | %9.6f\n",
		$test + 1,
		implode(" > ", array_keys($benchmark)),
		min(...$array_values),
		max(...$array_values),
		array_sum($array_values) / count($array_values)
	);
}

printf("\n----------============GRADE============----------\n");
arsort($points, SORT_NUMERIC);
foreach ($points as $k => $v) {
	printf("- %s: %d\n", $k, $v);
}
