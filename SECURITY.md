# Security Policy

## Supported Versions

| Version | Supported                     |
|---------|-------------------------------|
| 6.x     | :white_check_mark:            |
| 5.x     | :white_check_mark:            |
| 4.x     | :warning: (security-fix only) |
| 3.x     | :x:                           |
| <= 2.0  | :x:                           |

## Reporting Potential Security Issues

If you have encountered a potential security vulnerability in this project,
please report it to us at <security@dotkernel.com>. We will work with you to
verify the vulnerability and patch it.

When reporting issues, please provide the following information:

- Component(s) affected
- A description indicating how to reproduce the issue
- A summary of the security vulnerability and impact

We request that you contact us via the email address above and give the
project contributors a chance to resolve the vulnerability and issue a new
release prior to any public exposure; this helps protect the project's
users, and provides them with a chance to upgrade and/or update in order to
protect their applications.

## Policy

If we verify a reported security vulnerability, our policy is:

- We will patch the current release branch, as well as the immediate prior minor
  release branch.

- After patching the release branches, we will immediately issue new security
  fix releases for each patched release branch.
