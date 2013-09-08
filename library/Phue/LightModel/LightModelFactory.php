<?php

namespace Phue\LightModel;

/**
 * Light model factory
 */
class LightModelFactory
{
    /**
     * Build a new light model from model id
     *
     * @param string $modelId Model id
     *
     * @return AbstractLightModel Light model
     */
    public static function build($modelId)
    {
        $classNamePrefix      = __NAMESPACE__ . '\Model';
        $classNameModelSuffix = ucfirst(strtolower($modelId));

        if (!class_exists($classNamePrefix . $classNameModelSuffix)) {
            $classNameModelSuffix = 'Unknown';
        }

        $finalClassName = $classNamePrefix . $classNameModelSuffix;

        return new $finalClassName;
    }
}
