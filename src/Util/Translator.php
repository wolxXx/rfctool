<?php

declare(strict_types = 1);

namespace RfcTool\Util;

interface Translator
{
    public const string LANGUAGE_DEBUG  = 'xx';
    public const string LANGUAGE_ENGLISH = 'en';
    public const string LANGUAGE_GERMAN  = 'de';


    //region: generic
    public function translate($what, ...$args): string;
    //endregion
    //region: a
    //endregion
    //region: b
    //endregion
    //region: c
    //endregion
    //region: d
    //endregion
    //region: e
    //endregion
    //region: f
    //endregion
    //region: g
    //endregion
    //region: h
    //endregion
    //region: i
    //endregion
    //region: j
    //endregion
    //region: k
    //endregion
    //region: l
    //endregion
    //region: m
    //endregion
    //region: n
    public function no(): string;
    //endregion
    //region: o
    //endregion
    //region: p
    //endregion
    //region: q
    //endregion
    //region: r
    //endregion
    //region: s
    //endregion
    //region: t
    //endregion
    //region: u
    //endregion
    //region: v
    //endregion
    //region: w
    //endregion
    //region: x
    //endregion
    //region: y
    public function yes(): string;
    //endregion
    //region: z
    //endregion
}
