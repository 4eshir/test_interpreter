<?php
require_once 'interfaces/ParserStrategy.php';
require_once 'core/FunctionCall.php';
require_once 'Parser.php';

class FunctionCallParser implements ParserStrategy {
	private Parser $parser;

	public function __construct(Parser $parser) {
		$this->parser = $parser;
	}

    public function parse(string $input): Expression {
        $input = trim($input, '()');
        $parts = explode(',', $input, 2);
        $functionName = trim($parts[0]);
        $parameters = [];
        
        if (isset($parts[1])) {
            $paramsInput = $parts[1];
            $parameters = $this->parseParameters($paramsInput);
        }

        return new FunctionCall($functionName, $parameters);
    }

    /*
    * Эту функцию можно и нужно рефакторить, но я оставил ее в mvp-версии 
    * (мало времени на тестирование, а функция местами вызывает сложности в граничных случаях)
    */
    private function parseParameters(string $paramsInput): array {
	    $paramsInput = trim($paramsInput);
	    $params = [];
	    $depth = 0;
	    $currentParam = '';
	    $inString = false;
	    $escapeNext = false;
	
	    for ($i = 0; $i < strlen($paramsInput); $i++) {
	        $char = $paramsInput[$i];
	
	        // Проверяем на экранирование
	        if ($escapeNext) {
	            $currentParam .= $char;
	            $escapeNext = false;
	            continue;
	        }
	
	        // Учет экранирования
	        if ($char === '\\') {
	            $escapeNext = true;
	            continue;
	        }
	
	        // Проверка на начало и конец строки
	        if (($char === '"' || $char === "'") && !$escapeNext) {
	            $inString = !$inString; // Переключаем состояние в строке
	        }
	
	        // Увеличиваем и уменьшаем глубину в зависимости от скобок
	        if ($char === '(') {
	            if (!$inString) {
	                $depth++;
	            }
	        } elseif ($char === ')') {
	            if (!$inString) {
	                $depth--;
	            }
	        }
	
	        // Если мы на нулевом уровне вложенности и встретили запятую
	        if ($char === ',' && $depth === 0 && !$inString) {
	            // Если текущий параметр не пуст, парсим его
	            if (!empty(trim($currentParam))) {
	                $params[] = $this->parser->parse(trim($currentParam));
	                $currentParam = '';
	            }
	        } else {
	            // Добавляем текущий символ к параметру
	            $currentParam .= $char;
	        }
	    }
	
	    /* 
	    * Добавление последнего параметра, если он не пуст 
	    * (доп проверка на число, потому что empty("0") == true
	    */
	    if (is_numeric($currentParam) || !empty(trim($currentParam))) {
	    	$params[] = $this->parser->parse(trim($currentParam));
	    }
	
	    return $params;
	}
}
