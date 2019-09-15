<?php


namespace App\Traits;


Trait TraitSafeMergePaths
{
    public function safeMergePaths($path1, $path2)
    {
        return join('/', array(trim($path1, '/'), trim($path2, '/')));
    }
}
