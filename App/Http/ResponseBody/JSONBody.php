<?php


namespace App\Http\ResponseBody;

/**
 * Class JSONBody
 * @package App\Http\ResponseBody
 *
 * @var array $value
 * @method set(array $value)
 */
class JSONBody extends AbstractBody
{

    public function __toString(): string
    {
        return json_encode($this->value);
    }
}