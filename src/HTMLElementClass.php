<?php
namespace DAW\HTMLElementClass;

require 'tag_attributes.php';

class HTMLElementClass
{
    private string $tagName;
    private array $attributes;
    private $content;
    private bool $isEmpty;

    function __construct(string $tagName, array $attributes, array | string $content, $isEmpty)
    {
        if ($this->validateConstruct($tagName, $attributes, $content)){
            $this->tagName = $tagName;
            $this->attributes = $attributes;
            $this->content = $isEmpty?null:$content;
            $this->isEmpty = $isEmpty;
        } else {
            return false; // Cambiar por throw
        }
    }

    private function validateConstruct(string $tagName, array $attributes, array | string $content): bool{
        $tryValidate = [$this->validateContent($tagName, $content), $this->validateAttributes($tagName, $attributes), $this->validateAttributeValue($attributes)];
        $validationLen = count($tryValidate);
        return !(count(array_filter($tryValidate)) < $validationLen);
    }

    private function validateContent(string $tagName, array | string $content): bool{
        if (array_key_exists($tagName, EMPTY_TAGS)){
            return !($content != null);
        }
        return true;
    }

    private function validateAttributes(string $tagName, array $attributes): bool{
        if (!empty($attributes)){
            foreach ($attributes as $key => $value) {
                if (array_key_exists($key, ATTRIBUTES_TAG)){
                    if (ATTRIBUTES_TAG[$key] != "global"){
                        return (array_key_exists($tagName, ATTRIBUTES_TAG[$key]));
                    }
                }else{
                    return false;
                }
            }
        }
        return true;
    }

    private function validateAttributeValue(array $attributes): bool{
        if (!empty($attributes)){
            foreach ($attributes as $key => $value) {
                if (array_key_exists($key, ATTRIBUTE_VALUES)){
                    return !(ATTRIBUTE_VALUES[$key] != null && !array_key_exists($value, ATTRIBUTES_TAG[$key]));
                }else{
                    return false;
                }
            }
        }
        return true;
    }

    public function getTagName(): string{
        return $this->tagName;
    }

    public function getContent(){
        return $this->content;
    }

    public function getAttributes(): array{
        return $this->attributes;
    }

    public function isEmptyElement(): bool{
        return $this->isEmpty;
    }

    public function addContent(array | string $arrayHTMLElement){
        $this->content[] = $arrayHTMLElement;
    }

    public function addAttribute(string $attributeName, string $attributeValue){
        $this->attributes[$attributeName] = $attributeValue;
    }

    public function removeAttribute(string $attributeName){
        if (isset($this->attributes[$attributeName])) {
            unset($this->attributes[$attributeName]);
        }
    }

    public function isSameTag(HTMLElementClass $HTMLElementClass): bool{
        return $this->tagName == $HTMLElementClass->getTagName();
    }

    public function getHTML(): string{
        $stringattributes = "";
        foreach ($this->attributes as $clave => $valor) {
            $stringattributes .= $clave . " = " . '"' . $valor . '" ';
        }
        $stringattributes = rtrim($stringattributes);
        $code = "<".$this->tagName." ".$stringattributes.">";
        if (!$this->isEmpty) {
            if(is_array($this->content)){
                foreach ($this->content as $contenido) {
                    $code .= $contenido;
                }
            }else{
                $code .= $this->content;
            }
            $code .= "</".$this->tagName.">";
        }
        return $code;
    }
}
?>
