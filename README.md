# ComposerAutoloadSpeedBenchmark

Benchmark to show that PSR-4 autoloading is faster than classmap autoloading after the first run because of file system caching.

How to run the benchmarks:

```bash
$ make benchmark
```

Sample output:

> ## Run 1
> ```
> Classmap - total: 0.30039692 exec: 0.29499817
> ```
> ```
> PSR-4    - total: 0.29491711 exec: 0.29448605
> ```
> 
> ## Run 2
> ```
> Classmap - total: 0.26121807 exec: 0.25576091
> ```
> ```
> PSR-4    - total: 0.22717810 exec: 0.22679305
> ```
> 
> ## Run 3
> ```
> Classmap - total: 0.25657701 exec: 0.25119305
> ```
> ```
> PSR-4    - total: 0.22515678 exec: 0.22475600
> ```
