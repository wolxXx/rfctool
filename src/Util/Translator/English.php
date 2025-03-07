<?php

declare(strict_types = 1);

namespace RfcTool\Util\Translator;

class English implements
    \RfcTool\Util\Translator
{
    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'test':
            {
                return 'test!';
            }
            case 'This value should not be blank.':
            {
                return 'This value should not be blank.';
            }
            case 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.':
            {
                return str_replace(search: '{{ limit }}', replace: $args[0]['{{ limit }}'], subject: 'This value is too long. It should have {{ limit }} character or less.');
            }
        }
        throw new \InvalidArgumentException(message: 'Unknown translation: ' . $what);
    }
}
