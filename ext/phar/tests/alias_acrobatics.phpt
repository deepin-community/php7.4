--TEST--
Phar: alias edge cases
--SKIPIF--
<?php if (!extension_loaded("phar")) die("skip"); ?>
--INI--
phar.readonly=0
--FILE--
<?php

$fname = __DIR__ . '/' . basename(__FILE__, '.php') . '.phar';
$fname2 = __DIR__ . '/' . basename(__FILE__, '.php') . '.2.phar';

$p = new Phar($fname);

$p->setAlias('foo');
$p['unused'] = 'hi';
try {
$a = new Phar($fname2, 0, 'foo');
} catch (Exception $e) {
echo $e->getMessage(),"\n";
}
copy($fname, $fname2);
echo "2\n";
try {
$a = new Phar($fname2);
} catch (Exception $e) {
echo $e->getMessage(),"\n";
}
try {
$b = new Phar($fname, 0, 'another');
} catch (Exception $e) {
echo $e->getMessage(),"\n";
}
?>
===DONE===
--CLEAN--
<?php
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.phar');
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.2.phar');
?>
--EXPECTF--
alias "foo" is already used for archive "%salias_acrobatics.phar" cannot be overloaded with "%salias_acrobatics.2.phar"
2
Cannot open archive "%salias_acrobatics.2.phar", alias is already in use by existing archive
alias "another" is already used for archive "%salias_acrobatics.phar" cannot be overloaded with "%salias_acrobatics.phar"
===DONE===
