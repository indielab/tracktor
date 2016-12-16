# Heartbeat Tracktor

[![Build Status](https://travis-ci.org/indielab/tracktor.svg?branch=master)](https://travis-ci.org/indielab/tracktor)
[![Coverage Status](https://coveralls.io/repos/github/indielab/tracktor/badge.svg?branch=master)](https://coveralls.io/github/indielab/tracktor?branch=master)

The tracktor!

## Run

```php
php tracktor.php track <DEVICE_NAME>
```

## Testing

```sh
./vendor/bin/phpunit tests/
```

## Informations

|type|description
|----|-----------
|mac|The mac adresse of the client, can also be randomized
|signal|Values close to 0 are closer to the device. Means -90 farther then -60.
|ssid|The prob request lookup for the following ssid.