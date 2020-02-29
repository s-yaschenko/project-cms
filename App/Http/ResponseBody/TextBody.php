<?php


namespace App\Http\ResponseBody;


/**
 * Class TextBody
 * @package App\Http\ResponseBody
 *
 * @var string $value
 * @method set(string $value)
 */
class TextBody extends AbstractBody
{

    public function __toString(): string
    {
        return $this->value;
    }
}