# ComposerAutoloadSpeedBenchmark

Benchmark to show that PSR-4 autoloading is faster than classmap autoloading after the first run because of file system caching.

Sample Run:

```bash
$ make benchmark
...
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
Classmap Time: 0.27020287513733
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
Psr4 Time:     0.27232098579407
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
Classmap Time: 0.27177286148071
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
Psr4 Time:     0.24337601661682
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
Classmap Time: 0.26799201965332
php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
Psr4 Time:     0.24139904975891

```
