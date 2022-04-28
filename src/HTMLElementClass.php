<?php
namespace DAW\HTMLElementClass;

require "tag_attributes.php";

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
