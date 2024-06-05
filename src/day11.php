<?php

function inc_letter(string $char): string
{
    $char = ord($char);
    return $char == 122 ? 'a' : chr(++$char);
}

function inc_password(string $password): string
{
    $rev_split = str_split(strrev($password));
    $rev_split[0] = inc_letter($rev_split[0]);
    $i = 0;

    while (true) {
        if ($rev_split[$i] == 'a' && isset($rev_split[$i + 1])) {
            $rev_split[$i + 1] = inc_letter($rev_split[$i + 1]);
            $i++;
        } else {
            break;
        }
    }

    return strrev(implode("", $rev_split));
}

function to_asciis_arr(string $password): array
{
    return array_map(
        fn (string $char) => ord($char),
        str_split($password)
    );
}

function has_three_cons_char(string $password): bool
{
    $asc = to_asciis_arr($password);
    $len = count($asc);

    for ($i = 0; $i < $len; $i++) {
        if ($i + 2 < $len &&
            $asc[$i] + 1 == $asc[$i + 1] &&
            $asc[$i] + 2 == $asc[$i + 2]
        ) {
            return true;
        }
    }

    return false;
}

function contains_iol(string $str): bool
{
    return strpbrk($str, 'iol') !== false;
}

function has_two_diff_pairs($string): bool
{
    $pattern_first_pair = '/([a-z])\1/';

    if (preg_match($pattern_first_pair, $string, $matches)) {
        $first_pair_char = $matches[1];
        $pattern_second_pair = '/(?!' . $first_pair_char . ')([a-z])\1/';

        return preg_match($pattern_second_pair, $string) === 1;
    }

    return false;
}

// PART 1 & 2
// Note : The last example of the riddle in my case is way too long to compute
// But it works well with the real inputs

$password = "cqjxxyzz";

do {
    $password = inc_password($password);

    if (has_three_cons_char($password) &&
        !contains_iol($password) &&
        has_two_diff_pairs($password)
    ) {
        break;
    }
}
while (true);

echo $password;
