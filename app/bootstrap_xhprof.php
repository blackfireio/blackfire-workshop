<?php

if (
    is_file($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$_SERVER['SCRIPT_NAME']) &&
    '.php' !== strtolower(substr($_SERVER['SCRIPT_NAME'], -4))
) {
    return false;
}

if (!isset($_SERVER['REQUEST_URI']) || 0 === strpos($_SERVER['REQUEST_URI'], '/xhprof')) {
    return false;
}

register_shutdown_function(function () {
    $xhprof_data = uprofiler_disable();
    if (null === $xhprof_data) {
        return;
    }
    $xhprof_runs = new uprofilerRuns_Default();
    $xhprof_runs->save_run($xhprof_data, $app);
});
uprofiler_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
