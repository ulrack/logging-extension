# Ulrack Logging Extension - Add a logger plugin

This package provides a standard plugin which can be used within a project for
logging, using the [ulrack/aop-extension](https://github.com/ulrack/aop-extension).
The provided plugin logs the parameters on the `before` method. The `after`
method will log both the parameters and the return of a method. And finally the
`around` method will catch any exception, when thrown, logs it and rethrows it
to not disturp the original method logic.

The plugin can be configured with a logger and a log level. The following
combinations in advices have been made available within this package:

- log-parameters.info
- log-parameters.debug
- log-parameters.notice
- log-parameters.warning
- log-parameters.error
- log-parameters.fatal
- log-parameters.emergency
- log-parameters-and-return.info
- log-parameters-and-return.debug
- log-parameters-and-return.notice
- log-parameters-and-return.warning
- log-parameters-and-return.error
- log-parameters-and-return.fatal
- log-parameters-and-return.emergency
- log-exception.debug
- log-exception.info
- log-exception.notice
- log-exception.warning
- log-exception.error
- log-exception.fatal
- log-exception.emergency

In order to add a logger to a point in the application, create a `join-point`
in a file in `configuration/services` with the following contents:
```json
{
    "join-points": {
        "all-endpoint-invocations": {
            "class": "\\Ulrack\\Web\\Common\\Endpoint\\EndpointInterface",
            "method": "__invoke",
            "explicit": false
        }
    }
}
```

Then the logger can be add through a `pointcut` with a file in
`configuration/services` with the following contents:
```json
{
    "pointcuts": {
        "log-exceptions-on-all-endpoints": {
            "join-point": "all-endpoint-invocations",
            "advice": "log-exception.fatal"
        }
    }
}
```

After clearing the cache, all exceptions thrown on endpoints will be logged to
`var/log/fatal.log`.

## Further reading

[Back to usage index](index.md)

[Installation](installation.md)

[Add a logger](add-a-logger.md)

[Toggling log levels](toggling-log-levels.md)
