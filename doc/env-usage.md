# Using Envirorment Variables
The `.env` file is responsible for storing configuration variables. Follow the instructions below to set up and use the `.env` file effectively.


## Creating the `.env`
1. Rename the provided `.env.example` to `.env`.
2. Open the `.env` file in a text editor.


## Allowed Variables
| Variable          | Type   | Description                                                              |
|-------------------|--------|--------------------------------------------------------------------------|
| ALLOWED_ITEM_KEYS | string | The allowed keys for items in the vault                                  |
| LOGGER            | bool   |  Whether the logging feature is enabled                                  |
| ALLOWED_ORIGINS   | string | The allowed origins for CORS, empty string for null, `*` for all origins |

