<?php
use PHPUnit\Framework\TestCase;
use DAW\HTMLElementClass\HTMLElementClass;

final class HTMLElementClassTest extends TestCase{
    public function DP_test_createHTMLElementClass(){
        $HTMLElementClassNested = new HTMLElementClass("p" ,[], "Esto es un ejemplo", false);
        $HTMLElementClassNested = $HTMLElementClassNested->getHTML();
        return [
            "TEST P" => [
                '<p id = "ParrafoIntroduccion" class = "Normal">ParrafoIntroduccionDeprueba</p>',
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                [
                    "ParrafoIntroduccion",
                    "Deprueba"
                ],
                false
            ],
            "TEST NESTED" => [
                '<div id = "Container" class = "Centrado rojo" style = "position: absolute"><p >Esto es un ejemplo</p></div>',
                "div",
                [
                    "id" => "Container",
                    "class" => "Centrado rojo",
                    "style" => "position: absolute"
                ],
                $HTMLElementClassNested,
                false,
            ]
        ];
    }
    /**
    * @dataProvider DP_test_createHTMLElementClass
    */
    public function test_createHTMLElementClass($esperado, $tagName, $attributes, $content, $isEmpty){
        $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $this->assertEquals($esperado, $HTMLElementClass->getHTML());
    }


    public function DP_test_getTagName(){
        return [
            "TEST P" => [
                "p",
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                "Prueba",
                false
            ]
        ];
    }
    /**
    * @dataProvider DP_test_getTagName
    */
    public function test_getTagName($esperado, $tagName, $attributes, $content, $isEmpty){
    $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $this->assertEquals($esperado, $HTMLElementClass->getTagName());
    }
    /**
    * @dataProvider DP_test_getTagName
    */
    public function test_isEmptyElement($esperado, $tagName, $attributes, $content, $isEmpty){
        $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $this->assertEquals($isEmpty, $HTMLElementClass->isEmptyElement());
    }

    public function DP_test_addContent(){
        return [
            "TEST P" => [
                ["Prueba", "Prueba2"],
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                ["Prueba"],
                false
            ]
        ];
    }
    /**
    * @dataProvider DP_test_addContent
    */
    public function test_addContent($esperado, $tagName, $attributes, $content, $isEmpty){
        $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $HTMLElementClass->addContent("Prueba2");
        $this->assertEquals($esperado, $HTMLElementClass->getContent());

    }

    public function DP_test_addAttribute(){
        return [
            "TEST P" => [
                ["id" => "ParrafoIntroduccion", "class" => "Normal", "Test" => "Prueba"],
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                "Prueba",
                false
            ]
        ];
    }
    /**
    * @dataProvider DP_test_addAttribute
    */
    public function test_addAttribute($esperado, $tagName, $attributes, $content, $isEmpty){
        $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $HTMLElementClass->addAttribute("Test", "Prueba");
        $this->assertEquals($esperado, $HTMLElementClass->getAttributes());
    }

    public function DP_test_removeAttribute(){
        return [
            "TEST P" => [
                ["id" => "ParrafoIntroduccion"],
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                "Prueba",
                false
            ]
        ];
    }
    /**
    * @dataProvider DP_test_removeAttribute
    */
    public function test_removeAttribute($esperado, $tagName, $attributes, $content, $isEmpty){
        $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
        $HTMLElementClass->removeAttribute("class");
        $this->assertEquals($esperado, $HTMLElementClass->getAttributes());
    }

    public function DP_test_isSameTag(){
        return [
            "TEST P" => [
                "p",
                "p",
                [
                    "id" => "ParrafoIntroduccion",
                    "class" => "Normal"
                ],
                "Prueba",
                false
            ]
        ];
    }
    /**
    * @dataProvider DP_test_isSameTag
    */
    public function test_isSameTag($esperado, $tagName, $attributes, $content, $isEmpty){
    $HTMLElementClass = new HTMLElementClass($tagName, $attributes, $content, $isEmpty);
    $HTMLElementClass2 = new HTMLElementClass($esperado, $attributes, $content, $isEmpty);
        $this->assertTrue($HTMLElementClass->isSameTag($HTMLElementClass2));
    }
}
?>