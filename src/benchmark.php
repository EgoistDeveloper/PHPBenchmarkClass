<?php

class Benchmark
{
    /**
     * Number of digits after a comma
     */
    public $diffRound = 3;

    /**
     * Simple benckmark function
     *
     * @param function $function: anonymous function
     * @param int $loopCount: max count of repeats
     * @return array
     */
    public function runBenchmark($function, int $loopCount = 1000)
    {
        if (is_callable($function) && $loopCount > 0) {
            $startTime = microtime(true);

            for ($i = 0; $i < $loopCount; $i++) {
                $function();
            }

            $endTime = microtime(true);
            $diff = $endTime - $startTime;

            $result = [
                'start' => $startTime,
                'end' => $endTime,
                'diff' => $diff,
            ];

            if ($this->diffRound > 0) {
                $result['rounded_diff'] = round($diff, $this->diffRound);
            }

            return $result;
        }

        return false;
    }

    /**
     * Serial
     *
     * @param function $function: anonymous function
     * @param int $loopCount: max count of repeats
     * @return array
     */
    public function runBenchMarks($functions, int $loopCount = 1000)
    {
        if (is_array($functions) && count($functions) > 0) {
            $results = [];

            // simple serial benchmarks
            foreach ($functions as $key => $function) {
                if (is_callable($function)) {
                    $result = $this->runBenchmark($function, $loopCount);

                    array_push($results, [
                        $key => $result,
                    ]);
                }
            }

            return $results;
        }

        return false;
    }

    /**
     * Simple benckmark function
     *
     * @param function $function: anonymous function
     * @param int $loopCount: max count of repeats
     * @return array
     */
    public function runBenchMarkCombinations($functions, int $loopCount = 1000)
    {
        if (is_array($functions) && count($functions) > 0) {
            $results = [];

            $functionKeys = [];

            // get function names as key
            foreach ($functions as $key => $value) {
                array_push($functionKeys, $key);
            }

            // get function name combinations as array
            $allCombinations = $this->getArraysOfCombinations($functionKeys);

            // loop in this combinations
            foreach ($allCombinations as $combination) {
                // merge function names for listing
                $mergeCombinations = implode(', ', $combination);
                $results[$mergeCombinations] = [];

                // loop in functions
                foreach ($combination as $key => $functionName) {
                    $function = $functions[$functionName];

                    if (is_callable($function)) {
                        $result = $this->runBenchmark($function, $loopCount);

                        $results[$mergeCombinations][$functionName] = $result;
                    }
                }
            }

            return $results;
        }

        return false;
    }

    /**
     * Get arrays of combinations
     *
     * @param array $array
     * @return array
     * @see source: https://www.oreilly.com/library/view/php-cookbook/1565926811/ch04s25.html
     */
    private function getArraysOfCombinations($array)
    {
        if ($array) {
            $combinations = [[]];

            foreach ($array as $element) {
                foreach ($combinations as $combination) {
                    array_push($combinations, array_merge(array($element), $combination));
                }
            }

            unset($combinations[0]);
            $combinations = array_values($combinations);

            return $combinations;
        }

        return false;
    }
}
