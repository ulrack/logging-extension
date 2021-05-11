# Ulrack Logging Extension - Add a logger

This package provides a set two different kinds of loggers. The logger are
defined in the `invocations` service of this package.
- `invocations.log.add.json.filesystem.logger`
 - This adds the JSON based file system logger.
- `invocations.log.add.plain.filesystem.logger`
 - This adds the plain text file system logger.

The trigger to add the logger to a configurable transit logger from
`grizz-it/log`, is added in this package. So the only thing left to do is add
the logger through a tag. To create the tag, add a file to `configuration/services`
with the following contents:
```json
{
    "tags": {
        "add-plain-logger": {
            "trigger": "triggers.add.loggers",
            "service": "invocations.log.add.plain.filesystem.logger"
        }
    }
}
```

After clearing the cache, the logger will added to the transit logger when it
is requested throught he services layer. The logger can be retrieved with the
service `services.log.logger`.

## Further reading

[Back to usage index](index.md)

[Installation](installation.md)

[Toggling log levels](toggling-log-levels.md)

[Add a logger plugin](add-a-logger-plugin.md)
