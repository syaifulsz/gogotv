<?php

function freshCache()
{
    return !empty( $_GET['cache'] ) && ( $_GET['cache'] === 'refresh' );
}

function getSource(string $url)
{
    $cacheKey = md5( $url );
    $cache = __DIR__ . "/cache/{$cacheKey}";

    if ( file_exists( $cache ) && !freshCache() ) {
        return file_get_contents( $cache );
    }

    $source = file_get_contents( $url );
    file_put_contents( $cache, $source );

    return $source;
}

$output = [];

if ( !empty( $_GET['get_source'] ) ) {
    $output = getSource( $_GET['get_source'] );
}

header( 'Content-type:application/json' );
echo json_encode($output);
