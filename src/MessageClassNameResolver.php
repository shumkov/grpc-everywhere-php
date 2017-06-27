<?php

namespace GrpcEverywhere;

/**
 * Class MessageClassNameResolver
 * @package GrpcEverywhere
 */
class MessageClassNameResolver
{
    /**
     * @param Request $request
     * @param string $messageName
     * @return string
     */
    public function resolve(Request $request, $messageName)
    {
        $segments = explode('.', $request->getPackageName());

        $segmentsWithBigFirstLetter = array_map(function($segment) {
            return ucfirst($segment);
        }, $segments);

        return implode('\\', array_merge($segmentsWithBigFirstLetter, [$messageName]));
    }
}