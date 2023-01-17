<?php

declare(strict_types=1);

class NameConverterLT
{
    private array $ending = [
        'ius' => 'iaus',
        'ienė' => 'ienės',
        'aitis' => 'aičio',
        'aitė' => 'aitės',
        'ė' => 'ės',
        'as' => 'o',
        'is' => 'io',
        'a' => 'os',
    ];

    /**
     * Pakeičiamos frazės galūnės:
     *      direktorius Vardenis Pavardenis
     *          ||
     *          \/
     *      direktoriaus Vardenio Pavardenio.
     */
    public function convertString(?string $string): string
    {
        if (is_null($string)) {
            return '';
        }
        $phrase = explode(' ', $string);

        foreach ($phrase as $item => $value) {
            if (strpos($value, '-')) {
                $name = explode('-', $value);
                foreach ($name as $nam => $val) {
                    $name[$nam] = $this->changeName($val);
                }
                $phrase[$item] = implode('-', $name);
            } else {
                $phrase[$item] = $this->changeName($value);
            }
        }

        return implode(' ', $phrase);
    }

    private function changeName(string $name): string
    {
        $word = \str_split($name);

        for ($i = 5; $i > 0; --$i) {
            $str = \implode('', \array_slice($word, -$i, $i));
            $base = \array_slice($word, 0, -$i);
            if (\array_key_exists($str, $this->ending)) {
                $base[] = $this->ending[$str];

                return implode('', $base);
            }
        }

        return $name;
    }
}
