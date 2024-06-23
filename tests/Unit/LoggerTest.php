<?php

use Phico\Logger\Logger;

beforeEach(function () {
    files()->create('test.log');
});
afterEach(function () {
    files()->delete('test.log');
});


test('it logs an alert message', function () {
    $logger = new Logger([
        'level' => 'debug',
        'filepath' => 'test.log'
    ]);
    $logger->alert('This is an alert message');

    expect(files()->read('test.log'))
        ->toContain('[ALERT] This is an alert message');
});

test('it logs a debug message', function () {
    $logger = new Logger([
        'level' => 'debug',
        'filepath' => 'test.log'
    ]);
    $logger->debug('This is a debug message');

    expect(files()->read('test.log'))
        ->toContain('[DEBUG] This is a debug message');
});

test('it logs with context', function () {
    $logger = new Logger([
        'level' => 'debug',
        'filepath' => 'test.log'
    ]);
    $context = ['user' => 'testuser', 'id' => 1];
    $logger->info('This is an info message', $context);

    expect(files()->read('test.log'))
        ->toContain('[INFO] This is an info message')
        ->toContain(json_encode($context, JSON_UNESCAPED_SLASHES));
});

test('it does not log messages below the configured level', function () {
    $logger = new Logger([
        'level' => 'error',
        'filepath' => 'test.log'
    ]);
    $logger = new Logger();
    $logger->debug('This debug message should not be logged');

    expect(files()->read('test.log'))
        ->not->toContain('[DEBUG] This debug message should not be logged');
});

test('it logs messages with different levels', function () {
    $logger = new Logger([
        'level' => 'debug',
        'filepath' => 'test.log'
    ]);
    $logger->error('This is an error message');
    $logger->critical('This is a critical message');
    $logger->emerg('This is an emergency message');

    $content = files()->read('test.log');

    expect($content)->toContain('[ERROR] This is an error message');
    expect($content)->toContain('[CRITICAL] This is a critical message');
    expect($content)->toContain('[EMERG] This is an emergency message');
});
