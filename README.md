<h1 align="center">SysKeep Core</h1>

SysKeep's Core is a lightweight and flexible api for a password management system that allows you to securely store and manage your passwords.<br>
It is designed to be hosted locally on your own server, giving you full control over your data.


# Features
* **Multi-User Support**: Create and manage multiple user accounts.
* **Flexibility**: Not just passwords, add your own types.
* **Security**: All the data stored in the `database/` directory is encrypted.


# Requirements

* [PHP](https://www.php.net/downloads) version 7 or higher.
* [Composer](https://getcomposer.org/download/)


# Installation

1. Clone this repository to your local machine
```bash
git clone https://github.com/SysKeep/core.git && cd core
```

2. Run the bootstrap file
```bash
composer setup
```
OR
```bash
composer setup -- --force
```
To remove all the existing databases and generate a new initialization vector (IV).



## Usage
See the [docs](https://github.com/SysKeep/core/tree/main/doc) for all the available methods and their usage.


## License
[SysKeep/core](https://github.com/SysKeep/core/) is under the [MIT License](https://github.com/SysKeep/core/blob/main/LICENSE).