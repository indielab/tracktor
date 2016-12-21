# Heartbeat Tracktor

[![Build Status](https://travis-ci.org/indielab/tracktor.svg?branch=master)](https://travis-ci.org/indielab/tracktor)
[![Coverage Status](https://coveralls.io/repos/github/indielab/tracktor/badge.svg?branch=master)](https://coveralls.io/github/indielab/tracktor?branch=master)

The tracktor!

## Run

List Data

```sh
sudo php tracktor.php list <DEVICE_NAME>
```

Transfer Data:

```sh
sudo php tracktor.php transfer <DEVICE_NAME> <API_URL> <MACHINE_NAME>
```

## Testing

```sh
./vendor/bin/phpunit tests/
```

## Informations

|type|description
|----|-----------
|mac|The mac adresse of the client, can also be randomized
|signal|Values close to 0 are closer to the device. `-90` is farther then `-60`.
|ssid|The prob request lookup for the following ssid.