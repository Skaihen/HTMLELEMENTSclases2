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
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->content = $isEmpty?null:$content;
        $this->isEmpty = $isEmpty;

        return $this->validateConstruct($tagName, $attributes);
    }

    private function validateConstruct(string $tagName, array $attributes): bool{
        $tryValidate = [$this->validateContent($tagName), $this->validateAttributes($tagName, $attributes)];
        $validationLen = count($tryValidate);
        if (count(array_filter($tryValidate)) < $validationLen) {
            return false;
        }
        return true;
    }

    private function validateContent(string $tagName): bool{
        foreach (EMPTY_TAGS as $tag) {
            if ($tagName == $tag){
                return false;
            }
        }
        return true;
    }

    private function validateAttributes(string $tagName, array $attributes): bool{
        foreach ($attributes as $key) {
            if (array_key_exists($key, ATTRIBUTES_TAG)){
                if (!array_key_exists($tagName, ATTRIBUTES_TAG[$key])){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }

    private function validateAttributeValue(array $attributes): bool{
        foreach ($attributes as $key) {
            if (array_key_exists($key, ATTRIBUTES_TAG)){
                if (!array_key_exists($tagName, ATTRIBUTES_TAG[$key])){
                    return false;
                }
            }else{
                return false;
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
