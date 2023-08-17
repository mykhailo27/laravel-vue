<?php

namespace App\Models\Attributes;

interface Attribute
{
    public function getName(): string;

    public function getType(): string;

    public function getValue(): string;
}
