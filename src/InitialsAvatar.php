<?php

declare(strict_types=1);

namespace Renfordt\Larvatar;

use Renfordt\Colors\HSLColor;
use Renfordt\Larvatar\Enum\FormTypes;
use Renfordt\Larvatar\Traits\ColorTrait;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Texts\SVGText;
use SVG\SVG;

class InitialsAvatar extends Avatar
{
    use ColorTrait;

    private FormTypes $form = FormTypes::Circle;
    private int $rotation = 0;
    private int $offset = 0;

    /**
     * Constructs a new instance of the class.
     *
     * @param Name $name The name object to set
     *
     * @return void
     */
    public function __construct(Name $name)
    {
        $this->setName($name);
    }


    public static function make(Name|string $name): InitialsAvatar
    {
        if (is_string($name)) {
            $name = Name::make($name);
        }

        return new self($name);
    }

    /**
     * Sets the form of the application
     *
     * @param string|FormTypes $form The form type
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
     * @param int $angle The rotation angle value
     */
    public function setRotation(int $angle): void
    {
        $this->rotation = $angle;
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
     * @param int $offset The offset in pixel
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * Returns the HTML representation of the code.
     *
     * @param bool $base64 Determines if the image source should be in base64 format. Default is false.
     * @return string The HTML representation of the code.
     */
    public function getHTML(bool $base64 = false): string
    {
        if (!$base64) {
            return $this->generate()->__toString();
        }

        return '<img src="' . $this->getBase64() . '" />';
    }

    /**
     * Generates an SVG representation with initials and shape based on the provided configurations.
     *
     * @return SVG The generated SVG content as a string.
     */
    public function generate(): SVG
    {
        $larvatar = new SVG($this->size, $this->size);
        $doc = $larvatar->getDocument();

        $this->addFontIfNotEmpty();

        /**
         * @var HSLColor $darkColor
         * @var HSLColor $lightColor
         */
        [$darkColor, $lightColor] = $this->getColorSet(
            $this->name,
            $this->textLightness,
            $this->backgroundLightness
        );

        if ($this->form == FormTypes::Circle) {
            $halfSize = $this->size / 2;
            $outlineForm = $this->getCircle($halfSize, $lightColor);
        } elseif ($this->form == FormTypes::Square) {
            $outlineForm = $this->getSquare($this->size, $lightColor);
        } elseif ($this->form == FormTypes::Hexagon) {
            $outlineForm = $this->getHexagon($this->size, $lightColor, $this->rotation);
        }

        $initials = $this->getInitials($darkColor);

        $doc->addChild($outlineForm);
        $doc->addChild($initials);

        return $larvatar;
    }

    /**
     * Adds a font if the font path and font family are not empty
     */
    private function addFontIfNotEmpty(): void
    {
        if ($this->fontPath !== '' && $this->fontFamily !== '') {
            SVG::addFont(__DIR__ . $this->fontPath);
        }
    }

    /**
     * Get a circle SVG element
     *
     * @param float $halfSize Half of the size of the circle
     * @param HSLColor $lightColor The light color to fill the circle with
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
     * @param float $size Half of the square size
     * @param HSLColor $lightColor The color of the square
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
     * @param float $size The size of the polygon
     * @param HSLColor $lightColor The light color to fill the polygon
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
     * Generates an SVG text element with the initials and formats it with the given dark color and font settings.
     *
     * @param HSLColor $darkColor The dark color used to fill the text, provided in HSL format and converted to hex.
     * @return SVGText The SVG text element containing the formatted initials.
     */
    private function getInitials(HSLColor $darkColor): SVGText
    {
        $initialsText = $this->name->getInitials();

        $fontFamily = $this->fontFamily === '' || $this->fontFamily === '0' ? 'Segoe UI, Helvetica, sans-serif' : $this->fontFamily;

        $initials = new SVGText($initialsText, '50%', '55%');
        $initials->setStyle('fill', $darkColor->toHex());
        $initials->setStyle('text-anchor', 'middle');
        $initials->setStyle('dominant-baseline', 'middle');
        $initials->setStyle('font-weight', $this->fontWeight);
        $initials->setFontFamily($fontFamily);
        if ($this->fontSize == 0) {
            $this->fontSize = $this->calculateFontSize($initialsText);
        }
        $initials->setFontSize($this->fontSize . 'px');

        return $initials;
    }

    /**
     * Calculate the font size based on the initials length
     *
     * @param string $initials The initials to calculate the font size for
     * @return int  The calculated font size
     */
    protected function calculateFontSize(string $initials): int
    {
        return intval($this->size * (0.5 - sin(0.5 * strlen($initials) - 1) / 5));
    }

    /**
     * Returns the base64 encoded string representing the SVG image.
     *
     * @return string The base64 encoded string representing the SVG image.
     */
    public function getBase64(): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode($this->generate()->__toString());
    }
}
