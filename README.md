# Heartbeat Tracktor

[![Build Status](https://travis-ci.org/indielab/tracktor.svg?branch=master)](https://travis-ci.org/indielab/tracktor)
[![Coverage Status](https://coveralls.io/repos/github/indielab/tracktor/badge.svg?branch=master)](https://coveralls.io/github/indielab/tracktor?branch=master)

The tracktor!

## Commands

> You have to run the php process as sudo in order to read data from the wifi device with tcpdump.

|name|description|run
|----|-----------|---
|list|Generate a table view of the data.|`sudo php tracktor.php list <DEVICE_NAME>`
|json|Generate a json_encode output.|`sudo php tracktor.php json <DEVICE_NAME>`
|transfer|Transfer the data to a Rest API.|`sudo php tracktor.php transfer <DEVICE_NAME> <API_URL> <MACHINE_NAME>`

## Phare Creation

In order to create a phare install: `sudo apt-get install php7.0-bcmath`

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
