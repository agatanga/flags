<?php

namespace Agatanga\Flags;

use Agatanga\Flags\Flag;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Env;

class Factory
{
    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $defaultRatio;

    /** @var string */
    private $defaultClass;

    /** @var string */
    private $dir;

    /** @var array */
    private $memo = [];

    /**
     * @param Filesystem $filesystem
     * @param string $defaultRatio
     * @param string $defaultClass
     */
    public function __construct(Filesystem $filesystem, $defaultRatio = '', $defaultClass = '')
    {
        $this->filesystem = $filesystem;
        $this->defaultRatio = $defaultRatio ?: '4x3';
        $this->defaultClass = $defaultClass;
        $this->dir = sprintf(
            '%s/%s',
            Env::get('COMPOSER_VENDOR_DIR', base_path('vendor')),
            'components/flag-icon-css/flags'
        );
    }

    /**
     * @param string $name
     * @param string $class
     * @param array $attributes
     * @return Flag
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function flag($name, $class = '', array $attributes = [])
    {
        [$name, $ratio] = $this->splitRatioAndName($name);

        return new Flag(
            $this->contents($name, $ratio),
            $this->attributes($class, $attributes)
        );
    }

    /**
     * @param string $name
     * @return array
     */
    protected function splitRatioAndName($name)
    {
        $parts = explode(':', $name, 2);

        if (empty($parts[1])) {
            $parts[1] = $this->defaultRatio;
        } else {
            $mapping = [
                '11' => '1x1', '1:1' => '1x1',
                '43' => '4x3', '4:3' => '4x3',
            ];
            $parts[1] = str_replace(array_keys($mapping), $mapping, $parts[1]);
        }

        return $parts;
    }

    /**
     * @param string $name
     * @param string $ratio
     * @return string
     */
    protected function contents($name, $ratio)
    {
        $path = sprintf('%s/%s.svg', $ratio, $name);

        if (!isset($this->memo[$path])) {
            try {
                $contents = trim($this->filesystem->get($this->dir . '/' . $path));
                $contents = str_replace(' id="flag-icon-css-' . $name . '"', '', $contents);
            } catch (\Exception $e) {
                $contents = '';
            }

            $this->memo[$path] = $contents;
        }

        return $this->memo[$path];
    }

    /**
     * @param string $class
     * @param array $attributes
     * @return array
     */
    protected function attributes($class, array $attributes = [])
    {
        if (is_string($class) && $class) {
            $attributes['class'] = $attributes['class'] ?? $class;
        } elseif (is_array($class)) {
            $attributes = array_merge($class, $attributes);
        }

        if ($this->defaultClass) {
            $attributes['class'] = trim(sprintf(
                '%s %s',
                $this->defaultClass,
                $attributes['class'] ?? ''
            ));
        }

        return $attributes;
    }
}
