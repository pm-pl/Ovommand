<?php
declare(strict_types=1);

use pocketmine\utils\AssumptionFailedError;

require_once "../../vendor/autoload.php";

function parseQuoteAwareProvider() : \Generator{
	yield [
		'give "steve jobs" apple',
		['give', 'steve jobs', 'apple']
	];
	yield [
		'say \"escaped\"',
		['say', '"escaped"']
	];
	yield [
		'say This message contains \"escaped quotes\", which are ignored',
		['say', 'This', 'message', 'contains', '"escaped', 'quotes",', 'which', 'are', 'ignored']
	];
	yield [
		'say dontspliton"half"wayquotes',
		['say', 'dontspliton"half"wayquotes']
	];
	yield [
		'say "This is a \"string containing quotes\""',
		['say', 'This is a "string containing quotes"']
	];
	yield [
		'/say "This is a \\\\"',
		['/say', 'This is a \\']
	];
	yield [
		'/say "This is a \\"',
		['/say', '"This', 'is', 'a', '"']
	];
	yield [
		'/tellraw @a {"rawtext":[{"text":"I\\"m    blue!"}]}',
		['/say', '"This', 'is', 'a', '"']
	];
}

//$value = '/tellraw @a "tell \"MR\" red" {"rawtext":[{"text":"§bI  \"  am \"   blue"}]}';
$value = 'say This message contains \"escaped quotes\", which are ignored';

function parseQuoteAware(string $commandLine) : array {
	$args = [];
	preg_match_all('/"((?:\\\\.|[^\\\\"])*)"|(\S+)/u', $commandLine, $matches);

	foreach($matches[0] as $k => $_){
		for($i = 1; $i <= 2; ++$i){
			if($matches[$i][$k] !== ""){
				$match = $matches[$i][$k];
				$args[] = preg_replace('/\\\\([\\\\"])/u', '$1', $match) ?? throw new AssumptionFailedError(preg_last_error_msg());
				break;
			}
		}
	}

	return $args;
}

function parseQuoteAware2(string $commandLine) : array {
	$args = [];
	preg_match_all('/"((?:\\\\.|[^\\\\"])*)"|([^\s]+)/u', $commandLine, $matches);

	foreach($matches[0] as $k => $_){
		for($i = 1; $i <= 2; ++$i){
			if($matches[$i][$k] !== ""){
				$match = $matches[$i][$k];
				$args[] = preg_replace('/\\\\([\\\\"])/u', '$1', $match) ?? throw new AssumptionFailedError(preg_last_error_msg());
				break;
			}
		}
	}

	return $args;
}
foreach (parseQuoteAwareProvider() as $testCase) {
	$input = $testCase[0];
	$expected = $testCase[1];
	echo "WAN: $input\n";
	dump($expected);
	$actual1 = parseQuoteAware($input);
	if (!empty($diff = array_diff($actual1, $expected))) {
		echo "Diff Ori:\n";
		dump($diff);
	}
	$actual3 = parseQuoteAware2($input);
	if (!empty($diff = array_diff($actual3, $expected))) {
		echo "Diff Ve2:\n";
		dump($diff);
	}
	echo "-------------------------------\n\n";
}

//dump(parseQuoteAware($value));
//dump(parseQuoteAwareB($value));
//dump(parseQuoteAware2($value, ));