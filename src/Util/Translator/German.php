<?php

declare(strict_types = 1);

namespace RfcTool\Util\Translator;

class German implements
    \RfcTool\Util\Translator
{
    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'test':
            {
                return 'Test!';
            }
            case 'This value should not be blank.':
            {
                return 'Es wird eine Eingabe benötigt.';
            }
            case 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.':
            {
                return str_replace(search: '{{ limit }}', replace: $args[0]['{{ limit }}'], subject: 'Der Wert ist zu lang. Er sollte {{ limit }} Zeichen oder weniger haben.');
            }
        }
        throw new \InvalidArgumentException(message: 'Unknown translation: ' . $what);
    }
}
