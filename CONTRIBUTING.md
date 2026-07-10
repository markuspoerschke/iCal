# Contribution guide

You found a bug? There is a missing feature?

Please feel free to contribute to this project. New issues and merge requests are welcome!

## Development

### Unit Testing

This project uses unit tests to keep the quality of this package high.
Please add some tests to your merge requests.

You can run the tests with the following command:

```
make test
```

The code style for non PHP files can be checked manually by running the following command:

```
make test-prettier
```

### Code Style

This project uses the [PHP Coding Standards Fixer](http://cs.sensiolabs.org/).
To fix or to check the code style download the tool and execute it on your command line:

```
make fix
```

## Documentation

The documentation will be published on the website `https://ical.poerschke.nrw`.
The sources are available within the `website/docs/` folder.
To preview the result, you can run:

```
cd website
make start
```
