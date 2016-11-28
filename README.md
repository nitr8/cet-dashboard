# What is cet-dasboard?

TBD

# Prerequisites

To run this application you need [Docker](https://www.docker.com).

# How to use this image

cet-dashboard requires access to a MySQL database to work. We'll use our very own [LAMP image](https://github.com/nitr8/docker-lamp).

## Fetching the source

To clone cet-dashboard to your local progects folder.

```bash
$ cd ~/projects/
$ git clone https://github.com/nitr8/cet-dashboard.git
```


## Running the dashboard localy

The recommended way to run cet-dashboard is using Docker Compose using the following `docker-compose.yml` template:

```bash
$ cd ~/projects/cet-dashboard
$ docker-compose up -d
```


# Configuration

## Environment variables
