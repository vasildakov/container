<?php

namespace VasilDakov\ContainerTests\Assets;

class Logger
{
    public function __construct(public Writer $writer)
    {
    }
}