<?php

namespace NowCal\Interfaces;

interface ComponentInterface
{
    public function before();

    public function output();

    public function after();
}
