<?php

namespace Renfordt\Larvatar;

use Renfordt\Colors\HSLColor;
use Renfordt\Larvatar\Enum\ColorType;
use Renfordt\Larvatar\Enum\FormTypes;
use Renfordt\Larvatar\Traits\ColorTrait;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class InitialsAvatar
{
    use ColorTrait;

    private string $fontPath = '';
    private string $fontFamily = '';
    private Name $name;
    private int $size = 128;
    private int $fontSize = 0;
    private FormTypes $form = FormTypes::Circle;
    private int $rotation;
    private string $fontWeight = 'normal';
    private float $backgroundLightness = 0.8;
    private float $textLightness = 0.35;
    private int $offset = 0;

    /**
     * Constructs a new instance of the class.
     *
     * @param  Name  $name  The name object to set
     *
     * @return void
     */
    public function __construct(Name $name)
    {
        $this->setName($name);
    }

    /**
     * Sets the name for the user
     * @param  Name  $name  The user's name
     * @return void
     */
    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public static function make(Name $name): InitialsAvatar
    {
        return new self($name);
    }

    /**
     * Generates an avatar based on the given names and encoding
     *
     * @param  array  $names  An array of names to generate initials from
     * @param  string|null  $encoding  The encoding type for the output ('base64' or null)
     *
     * @return string The generated avatar in SVG format or the base64-encoded avatar image
     */
    public function generate(string|null $encoding = null): string
    {
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();

        $this->addFontIfNotEmpty();

        /**
         * @var HSLColor $darkColor
         * @var HSLColor $lightColor
         */
        list($darkColor, $lightColor) = $this->getColorSet($this->name, $this->textLightness,
            $this->backgroundLightness);

        if ($this->form == FormTypes::Circle) {
            $halfSize = $this->size / 2;
            $outlineForm = $this->getCircle($halfSize, $lightColor);
        } elseif ($this->form == FormTypes::Square) {
            $outlineForm = $this->getSquare($this->size, $lightColor);
        } elseif ($this->form == FormTypes::Hexagon) {
            $outlineForm = $this->getHexagon($this->size, $lightColor, $this->rotation);
        }


        $initials = $this->getInitials($this->name->getSplitNames(), $darkColor);

        $doc->addChild($outlineForm);
        $doc->addChild($initials);

        if ($encoding == 'base64') {
            return 'data:image/svg+xml;base64,'.base64_encode($larvatar);
        }
        return $larvatar;
    }

    /**
     * Adds a font if the font path and font family are not empty
     * @return void
     */
    private function addFontIfNotEmpty(): void
    {
        if ($this->fontPath != '' && $this->fontFamily != '') {
            SVG::addFont(__DIR__.$this->fontPath);
        }
    }

    /**
     * Get a circle SVG element
     *
     * @param  float  $halfSize  Half of the size of the circle
     * @param  HSLColor  $lightColor  The light color to fill the circle with
     * @return  SVGCircle                     The circle SVG element
     */
    private function getCircle(float $halfSize, HSLColor $lightColor): SVGCircle
    {
        $circle = new SVGCircle($halfSize, $halfSize, $halfSize);
        $circle->setStyle('fill', $lightColor->toHex());

        return $circle;
    }

    /**
     * Get a square SVGRect
     *
     * @param  float  $size  Half of the square size
     * @param  HSLColor  $lightColor  The color of the square
     *
     * @return SVGRect The generated square SVGRect object
     */
    private function getSquare(float $size, HSLColor $lightColor): SVGRect
    {
        $square = new SVGRect(0, 0, $size, $size);
        $square->setStyle('fill', $lightColor->toHex());
        return $square;
    }

    /**
     * Get a polygon shape
     *
     * @param  float  $size  The size of the polygon
     * @param  HSLColor  $lightColor  The light color to fill the polygon
     * @param  int  $rotation
     * @return SVGPolygon The polygon shape with the specified size and color
     */
    private function getHexagon(float $size, HSLColor $lightColor, int $rotation = 0): SVGPolygon
    {
        $rotation = pi() / 180 * $rotation;

        for ($i = 0; $i <= 5; $i++) {
            $xCoordinate = $size / 2 * cos(pi() / 3 * $i + $rotation) + $size / 2;
            $yCoordinate = $size / 2 * sin(pi() / 3 * $i + $rotation) + $size / 2;
            $edgePoints[] = [$xCoordinate, $yCoordinate];
        }

        $polygon = new SVGPolygon($edgePoints);
        $polygon->setStyle('fill', $lightColor->toHex());
        return $polygon;
    }

    /**
     * Generates initials for the given names and returns SVGText object
     * @param  array  $names  List of names
     * @param  HSLColor  $darkColor  Dark color object
     * @return SVGText  SVGText object containing the initials
     */
    private function getInitials(array $names, HSLColor $darkColor): SVGText
    {
        $initialsText = '';
        foreach ($names as $name) {
            $initialsText .= substr($name, 0, 1);
        }

        $initials = new SVGText($initialsText, '50%', '55%');
        $initials->setStyle('fill', $darkColor->toHex());
        $initials->setStyle('text-anchor', 'middle');
        $initials->setStyle('dominant-baseline', 'middle');
        $initials->setStyle('font-weight', $this->fontWeight);
        $initials->setFontFamily($this->fontFamily);
        if ($this->fontSize == 0) {
            $this->fontSize = $this->calculateFontSize($initialsText);
        }
        $initials->setFontSize($this->fontSize.'px');

        return $initials;
    }

    /**
     * Calculate the font size based on the initials length
     *
     * @param  string  $initials  The initials to calculate the font size for
     * @return int  The calculated font size
     */
    protected function calculateFontSize(string $initials): int
    {
        return intval($this->size * (0.5 - sin(0.5 * strlen($initials) - 1) / 5));
    }

    /**
     * Sets the font size for the text
     *
     * @param  int  $size  The font size in pixel
     * @return void
     */
    public function setFontSize(int $size): void
    {
        $this->fontSize = $size;
    }

    /**
     * Sets the size of the avatar
     * @param  int  $size  Size in pixel
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * Sets the font which shall be used for the avatar
     * @param  string  $fontFamily  Font Family, e.g. 'Roboto'
     * @param  string  $path  Relative path to the true type font with a leading slash, e.g. '/font/Roboto-Bold.ttf'
     * @return void
     */
    public function setFont(string $fontFamily, string $path): void
    {
        $this->fontFamily = $fontFamily;
        $this->fontPath = $path;
    }

    /**
     * Sets the form of the application
     *
     * @param  string|FormTypes  $form  The form type
     * @return void
     */
    public function setForm(string|FormTypes $form): void
    {
        if (is_string($form)) {
            $form = FormTypes::from($form);
        }

        $this->form = $form;
    }

    /**
     * Sets the rotation angle of the element
     *
     * @param  int  $angle  The rotation angle value
     *
     * @return void
     */
    public function setRotation(int $angle): void
    {
        $this->rotation = $angle;
    }

    /**
     * Sets the font weight
     * @param  string  $fontWeight  The font weight to set
     * @return void
     */
    public function setFontWeight(string $fontWeight): void
    {
        $this->fontWeight = $fontWeight;
    }

    /**
     * Get the lightness of the background color.
     *
     * @return float The lightness value of the background color.
     */
    public function getBackgroundLightness(): float
    {
        return $this->backgroundLightness;
    }

    /**
     * Sets the lightness of the background
     *
     * @param  float  $lightness  Lightness value (between 0 and 1)
     * @return void
     */
    public function setBackgroundLightness(float $lightness): void
    {
        $this->backgroundLightness = clamp($lightness, 0, 1);
    }

    /**
     * Get the lightness of the text
     *
     * @return float The lightness of the text
     */
    public function getTextLightness(): float
    {
        return $this->textLightness;
    }

    /**
     * Sets the lightness of the text
     *
     * @param  float  $lightness  Lightness value ranging from 0 to 1
     * @return void
     */
    public function setTextLightness(float $lightness): void
    {
        $this->textLightness = clamp($lightness, 0, 1);
    }

    /**
     * Retrieves the offset of the object
     *
     * @return int The offset value
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Sets the offset for the avatar
     *
     * @param  int  $offset  The offset in pixel
     * @return void
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

}
