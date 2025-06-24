# PHP sample code for Doverunner Multi-DRM license token generation

## Overview

This repository provides server-side sample code that can generate license token for Doverunner multi-DRM service. DRM license tokens are used to authenticate license requests in multi-DRM integration workflows.

Here's how a license token works in the DRM license issuance process.
- When a multi-DRM client tries to play DRM content, the client requests a token to the content service platform to acquire DRM license. The service platform verifies that the user requesting the token has permission to the content, and then generates a token data according to the specification.
- The service platform can set usage rights and various security policies in the token data. The generated token is delivered to the client as response.
- When the client requests a DRM license with the token, DoveRunner cloud server validates the token and issues a license.

## Documentation

- [DoveRunner Docs](https://doverunner.com/docs/)

## Support

If you have any questions or issues with the token sample, please create a ticket at [Doverunner Helpdesk](https://support.doverunner.com) website.
