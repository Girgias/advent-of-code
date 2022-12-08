<?php

$input = <<<'INPUT'
$ cd /
$ ls
dir a
14848514 b.txt
8504156 c.dat
dir d
$ cd a
$ ls
dir e
29116 f
2557 g
62596 h.lst
$ cd e
$ ls
584 i
$ cd ..
$ cd ..
$ cd d
$ ls
4060174 j
8033020 d.log
5626152 d.ext
7214296 k
INPUT;

$input = file_get_contents('input.txt');

$filesystem = [];
$parents = [];
$current = &$filesystem;

$commands = explode('$ ', $input);
array_shift($commands); // The explode will give an entry prior to the first $ which is an empty string that we don't care
foreach ($commands as $command) {
    if ($command[0] === 'c') {
        $name = substr($command, offset: 3, length: strlen($command)-4); // Take into account trailing \n
        if ($name == '..') {
            array_pop($parents);
            $current = &$filesystem;
            foreach ($parents as $folder) {
                $current = &$current[$folder];
            }
            continue;
        }
        //$current[$name] = [];
        $parents[] = $name;
        $current = &$current[$name];
    }
    if ($command[0] === 'l') {
        $files = explode("\n", trim($command));
        array_shift($files); // Don't care about the LS line
        foreach ($files as $file) {
            $data = explode(' ', $file);
            if ($data[0] === 'dir') {
                $current[$data[1]] = [];
            } else {
                $current[$data[1]] = $data[0];
            }
        }
    }
}
//file_put_contents('filesystem_visual.txt', print_r($filesystem, true));

$directories = [];

function directorySize(string $directory, array $content): void {
    global $directories;
    $directories[$directory] = 0;
    $size = &$directories[$directory];
    foreach ($content as $name => $value) {
        if (is_array($value)) {
            $canonicalName = $directory.$name;
            if (!array_key_exists($canonicalName, $directories)) {
                directorySize($canonicalName, $value);
            }
            $size += $directories[$canonicalName];
            continue;
        }
        $size += $value;
    }
}

directorySize('/', $filesystem['/']);

//file_put_contents('directories_visual.txt', print_r($directories, true));

/* Part 1
$less100k = array_filter($directories, fn($v) => $v <= 100_000);
$sum = array_sum($less100k);
var_dump($sum);
*/

const TOTAL_SPACE = 70_000_000;
const SPACE_NEEDED = 30_000_000;
$neededSpace = ($directories['/'] - TOTAL_SPACE) + SPACE_NEEDED;
$overNeededSpace = array_filter($directories, fn($v) => $v >= $neededSpace);
sort($overNeededSpace);
var_dump(current($overNeededSpace));
