<?php

class __Mustache_3c13d586485fb94a873adabf429b3e11 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
';
        $buffer .= $indent . '<html>
';
        $buffer .= $indent . '    <head>
';
        $buffer .= $indent . '        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
';
        $buffer .= $indent . '        <title>';
        $value = $this->resolveValue($context->find('title'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</title>
';
        $buffer .= $indent . '		<script type="text/javascript" src="funciones/funciones_javascript.js"></script>
';
        $buffer .= $indent . '		<link rel="stylesheet" type="text/css" href="funciones/sala.css" />
';
        $buffer .= $indent . '</head>
';
        $buffer .= $indent . '<body>
';
        $buffer .= $indent . '<a href="log_auditoria.php?Atras=';
        $value = $this->resolveValue($context->find('atras'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">Atrás</a>
';
        $buffer .= $indent . '<a href="log_auditoria.php?Siguiente=';
        $value = $this->resolveValue($context->find('siguiente'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '">Siguiente</a>
';
        $buffer .= $indent . '
';
        // 'imprimir_matriz' section
        $value = $context->find('imprimir_matriz');
        $buffer .= $this->sectionC1324c41acc883d1fed2e4a7631a6e51($context, $indent, $value);
        $buffer .= $indent . '</body>
';
        $buffer .= $indent . '</html>';

        return $buffer;
    }

    private function sectionC1324c41acc883d1fed2e4a7631a6e51(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
  
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '  
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
