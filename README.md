# PHPBenchmarkClass
Simple benchmark class in PHP

## Single Benchmark

```PHP
$results1 = $benchmark->runBenchmark(function () {
    $var = explode(' ', 'PHP: microtime - Manual');
}, 10000);

$results2 = $benchmark->runBenchmark(function () {
    $var = explode(' ', 'PHP: microtime - Manual + PHP: microtime - Manual');
}, 10000);

print_r($results1);
print_r($results2);
```

## Multiple Benchmarks

```PHP
$results = $benchmark->runBenchMarks([
    'x1' => function () {
        $var = explode(' ', 'PHP: microtime - Manual');
    },
    'x2' => function () {
        $var = explode(' ', 'PHP: microtime - Manual + PHP: microtime - Manual');
    },
    'x3' => function () {
        $var = explode(' ', 'PHP: microtime - Manual + PHP: microtime - Manual + PHP: microtime - Manual');
    },
], 10000);

print_r($results);
```

## Multiple Benchmarks with Combinations

```PHP
$results = $benchmark->runBenchMarkCombinations([
    'x1' => function () {
        $var = explode(' ', 'PHP: microtime - Manual');
    },
    'x2' => function () {
        $var = explode(' ', 'PHP: microtime - Manual + PHP: microtime - Manual');
    },
    'x3' => function () {
        $var = explode(' ', 'PHP: microtime - Manual + PHP: microtime - Manual + PHP: microtime - Manual');
    },
], 10000);

print_r($results);
```

### Single Output

```
Array
(
    [start] => 1553155403.3169
    [end] => 1553155403.3243
    [diff] => 0.0073568820953369
    [rounded_diff] => 0.007
)
```