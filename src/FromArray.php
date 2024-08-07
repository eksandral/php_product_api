<?php

namespace Eksandral\ProductsApi;

trait FromArray{
    public static function fromArray(array $data): self {

        $instance = new self();
        foreach(static::getAttributes() as $k=>$v){
            $attr = $v;
            $cb = null;
            if (is_string($k)) {
                $attr = $k;
                $cb = $v;
            }
            if (array_key_exists($attr, $data)) {

                $instance->$attr = $cb !== null ?call_user_func($cb,$data[$attr]):$data[$attr];
            }
        }

        return $instance;
    }
    abstract static function getAttributes(): array;
}
