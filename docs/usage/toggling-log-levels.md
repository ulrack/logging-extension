# Ulrack Logging Extension - Toggling log levels

By default all log levels are enabled, however in some cases (e.g. on
production environments) not all log levels are required. For this package
a set of `environment` variables are added to the project which handle this.
It is managed through the
[environment extension](https://github.com/ulrack/environment-extension). The
following variables are available:

```
logging.allowEmergency
logging.allowFatal
logging.allowError
logging.allowWarning
logging.allowNotice
logging.allowInfo
logging.allowDebug
```

When one of these values is set to `false` (with the
`bin/application environment set` command), that log level will not be logged
to a file. For example:
```
bin/application environment set -k logging.allowDebug -v false
```
Will disable any logging for the `debug` level in `var/log/debug.log`.

## Further reading

[Back to usage index](index.md)

[Installation](installation.md)

[Add a logger](add-a-logger.md)

[Add a logger plugin](add-a-logger-plugin.md)
