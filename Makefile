@PHONY: clean
clean:
	-rm -rf classmap/src
	-rm -rf psr4/src
	-rm -rf classmap/vendor
	-rm -rf psr4/vendor
	-rm -rf classmap/composer.lock
	-rm -rf psr4/composer.lock

@PHONY: generate
generate: clean
	php generate.php
	cd classmap && composer install
	cd psr4 && composer install

@PHONY: benchmark
benchmark: generate
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php
