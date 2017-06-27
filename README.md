# GRPC Everywhere for PHP

Documentation will be soon. Simple example below.

Install via composer:
```bash
composer require shumkov/grpc-everywhere
```

Append psr7 middleware to your PHP application:

```php
$application = new \App\Application();

$service = new \GrpcEverywhere\Service(
    'test.greeter',
    'Greeter'
);

$service->setHandler('sayHello', new \App\SayHelloHandler());

$application->add(new \GrpcEverywhere\Middleware(
    $service,
    new \GrpcEverywhere\Dispatcher(
        new \DrSlump\Protobuf\Codec\Json(),
        new \GrpcEverywhere\MessageClassNameResolver()
    )
));

$application->run();
```

## MIT License

Copyright (c) 2016 Ivan Shumkov

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.