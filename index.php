<?php
require_once 'core/Expression.php';
require_once 'core/Constant.php';
require_once 'core/FunctionCall.php';
require_once 'parser/Parser.php';
require_once 'parser/ConstantParser.php';
require_once 'parser/FunctionCallParser.php';
require_once 'interpreter/Interpreter.php';

$parser = new Parser();
$interpreter = new Interpreter();
$input = '(json, (map, (array, "message"), (array, (concat, "Hello, ", (getArg, 0)))))';

try {
    $program = $parser->parse($input);
    var_dump($interpreter->execute($program, ['world']));
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}