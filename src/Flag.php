<?php

namespace Agatanga\Flags;

use Illuminate\Contracts\Support\Htmlable;

class Flag implements Htmlable
{
    /** @var string */
    private $contents;

    /** @var array */
    private $attributes;

    /**
     * @param string $contents
     * @param array $attributes
     */
    public function __construct($contents, array $attributes = [])
    {
        $this->contents = $contents;
        $this->attributes = $attributes;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return str_replace(
            '<svg',
            sprintf('<svg%s', $this->renderAttributes()),
            $this->contents,
        );
    }

    /**
     * @return string
     */
    protected function renderAttributes()
    {
        if (count($this->attributes) === 0) {
            return '';
        }

        return ' '.collect($this->attributes)->map(function ($value, $key) {
            if (is_int($key)) {
                return $value;
            }

            return sprintf('%s="%s"', $key, htmlspecialchars($value));
        })->implode(' ');
    }
}
