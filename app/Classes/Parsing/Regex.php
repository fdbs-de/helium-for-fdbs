<?php

namespace App\Classes\Parsing;



class Regex
{
    public const COMPONENT = '/(?s)<cms_(\w+)\s*([^>]*)>((?:(?:(?!<\/?cms_\1>).)*|(?R))*)<\/cms_\1>/s';
    public const PROP = '/\{\{([a-zA-Z_.]+)\}\}/';
    public const SLOT = '/\{\{\{(\w+)\}\}\}/s';
}