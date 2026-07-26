# Security Policy

## Supported Versions

Below is information regarding which versions of **OpenSIDCustom** are currently receiving security updates.

| Version | Supported          |
| ------- | ------------------ |
| Main (`main`) | :white_check_mark: |
| Development   | :white_check_mark: |
| Legacy        | :x:                |

## Reporting a Vulnerability

We take the security of OpenSIDCustom seriously. If you discover a security vulnerability, please follow these guidelines to report it responsibly.

### How to Report

1. **Do NOT open a public issue.** Publicly disclosing a vulnerability can endanger live village deployments before a patch is ready.
2. Send a private security report or contact the repository maintainers via GitHub Private Vulnerability Reporting or email.
3. Please include the following details in your report:
   - A description of the vulnerability and its potential impact.
   - Clear steps to reproduce the issue (proof-of-concept, payload, or HTTP request details).
   - Affected endpoints, parameters, or components.

### Response & Handling Process

- **Acknowledgement:** We aim to acknowledge receipt of security reports within 24 to 48 hours.
- **Assessment:** The report will be investigated and verified by the development team.
- **Patch & Release:** A fix will be developed and released promptly.
- **Credit:** We appreciate responsible disclosure and will attribute credit to researchers who report valid vulnerabilities.

## Security Best Practices for Village Deployments

To ensure your OpenSIDCustom instance remains secure in production:

1. **Protect Credentials:** Never commit sensitive database credentials (`database.php`), secret keys, or `.env` files to public repositories. Ensure the `desa/` directory remains ignored in Git.
2. **Access Management:** Require strong passwords for all administrator and pamong accounts.
3. **Directory Permissions:** Restrict write permissions on web server directories, leaving only `storage/` and upload folders writable.
4. **Regular Backups:** Perform regular backups of your MySQL database and uploaded documents.
