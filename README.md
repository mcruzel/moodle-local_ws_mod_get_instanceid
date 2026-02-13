# Moodle Plugin: local_ws_mod_get_instanceid

This plugin adds a web service to Moodle that retrieves the instance ID and module type from a course module ID (cmid).

## License
MIT License
Copyright (c) 2025 Maxime Cruzel
March 2025

## Installation

1. Copy the contents of this folder to the `local/ws_mod_get_instanceid` directory in your Moodle installation
2. Log in to your Moodle site as an administrator
3. Go to Site administration > Notifications
4. Follow the instructions to install the plugin

## Web Service Usage

### Web Service Name
`local_ws_mod_get_instanceid_get_instance`

### Parameters
- `cmid` (int): Course module ID

### Return Value
The web service returns a JSON object containing:
- `instanceid` (int): Module instance ID
- `modulename` (string): Module type name (e.g., quiz, assign)

### Example Response
```json
{
    "instanceid": 45,
    "modulename": "quiz"
}
```

## Security
- The web service requires authentication
- Users must have the `moodle/course:view` capability to use the web service
- Parameters are validated and sanitized
- Exceptions are handled appropriately

## Tests
The plugin includes unit tests that cover:
- Retrieving a valid course module
- Handling invalid course modules
- Managing user permissions

To run the tests:
1. Ensure PHPUnit is installed
2. Run the command: `php admin/tool/phpunit/cli/init.php`
3. Then: `vendor/bin/phpunit local_ws_mod_get_instanceid/tests/external_test.php`

## Version
- Current version: 2024032102
- Compatible with Moodle 4.1 and higher 