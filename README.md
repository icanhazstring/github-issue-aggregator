# Github Issue Aggregator

Some project are split up into multiple packages which makes it harder to get an overview of open issues. This little utility helps you to get a full list of issues from root requirements of a given package.

## Information
This project was created during a CodeSprint for [PHPUnit](https://github.com/sebastianbergmann/phpunit).
 
It is in an early prototypical state. This means you might encounter some issues while using it. If you find one, please file me an issue.

## Usage
1. Navigate to [issues.icanhazstring.net](https://issues.icanhazstring.net)
2. Login with your github account
3. Put in the repository you want the issues to be listet

## Requirements
- You have an github account
    - This account is needed to avoid exceeding the limited requests per hour the public github api provides. So every user will use there own limit.
- The requested repository *must* contain a `composer.json`
- The name of the requested repository is taken from [github.com](https://github.com) (e.g. sebastianbergmann/phpunit)

## General functionality
The general functionality is very simple.

1. Fetch `composer.json` from github
2. Read root requirements
3. Resolve github repository urls using packagist for each requirement
4. Fetch issues from those repositories

## How to contribute
See [CONTRIBUTE.md](CONTRIBUTE.md).

## Credits
 - [@sebastianfeldmann](https://github.com/sebastianfeldmann) for hosting PHPUnit CodeSprint at [@CHECK24](https://github.com/CHECK24)
 - [@sebastianbergmann](https://github.com/sebastianbergmann) for the general idea
