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
	-rm -rf benchmark.log

	echo "## Run 1" | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php     | tee -a benchmark.log

	echo "\n## Run 2" | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php     | tee -a benchmark.log

	echo "\n## Run 3" | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 classmap/benchmark.php | tee -a benchmark.log
	php -d zend.assertions=1 -d assert.active=1 -d opcache.enable=0 psr4/benchmark.php     | tee -a benchmark.log

	cat benchmark.log

