<?php

namespace thesebas\composablemapper;

function compose(...$functions)
{
    return function ($r) use ($functions) {
        return array_reduce($functions, function ($res, $func) {
            return $func($res);
        }, $r);
    };
}

function takeField($fname)
{
    return function ($r) use ($fname) {
        if (is_array($fname)) {
            $ret = [];
            foreach ($fname as $k => $v) {
                $ret[$k] = $r[$v];
            }
            return $ret;
        }
        return $r[$fname];
    };
}

function nullOn($nullVal)
{
    return function ($val) use ($nullVal) {
        if ($val === $nullVal) {
            return null;
        }
        return $val;
    };
}

function ifNotNull(\Closure $param)
{
    return function ($val) use ($param) {
        if ($val === null) {
            return null;
        }
        return $param($val);
    };
}