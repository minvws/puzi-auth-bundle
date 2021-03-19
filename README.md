![pUZI logo](pUZI.svg "pUZI logo")
# UZI authentication bundle for Symfony 

[![CI](https://github.com/minvws/puzi-auth-bundle/actions/workflows/test.yml/badge.svg)](https://github.com/minvws/puzi-auth-bundle/actions/workflows/test.yml)

Proficient UZI pass reader in php.

The UZI card is part of an authentication mechanism for medical staff and doctors working in the Netherlands. The cards are distributed by the CIBG. More information and the relevant client software can be found at www.uziregister.nl (in Dutch).

pUZI is a simple and functional module which allows you to use the UZI cards as authentication mechanism. It consists of:

1. a reader that reads the data on the card and gives an UziUser object in return.
2. a validator that will check the given UziUser against a set of types and roles.
3. a symfony guard authenticator that allows authentication based on UZI cards (this repository).

For documentation, software and to apply for an UZI card, please check out [www.uziregister.nl](https://www.uziregister.nl).     

pUZI is available under the EU PL licence. It was created early 2021 during the COVID19 campaign as part of the vaccination registration project BRBA for the ‘Ministerie van Volksgezondheid, Welzijn & Sport, programma Realisatie Digitale Ondersteuning.’

Questions and contributions are welcome via [GitHub](https://github.com/minvws/puzi-auth-bundle/issues).

## Requirements

* Symfony 4 or higher

Apache config (or NginX equivalent):
```apacheconf
SSLEngine on
SSLProtocol -all +TLSv1.3
SSLHonorCipherOrder on
SSLCipherSuite ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384
SSLVerifyClient require
SSLVerifyDepth 3
SSLCACertificateFile /path/to/uziCA.crt
SSLOptions +StdEnvVars +ExportCertData
```

## Installation

### Composer

```sh
composer require minvws/puzi-auth-bundle
```

## Usage


Step 1: install bundle with composer:

    composer require minvws/puzi-auth-bundle
    
Step 2: create a configuration file:

    # config/packages/puzi_auth.yaml
    puzi_auth:
        strict_ca_check: true
        allowed_types:
            - !php/const MinVWS\PUZI\UziConstants::UZI_TYPE_NAMED_EMPLOYEE
            - !php/const MinVWS\PUZI\UziConstants::UZI_TYPE_CARE_PROVIDER
        allowed_roles:
            - !php/const MinVWS\PUZI\UziConstants::UZI_ROLE_DOCTOR  

Step 3: add the guard to your `security.yml`:

    firewalls:
        main:
            guard:
               authenticators:
                - puzi_auth.security.guard.authenticator
            stateless: true

At this point, an authenticated user will be of the `MinVWS\PUZI\AuthBundle\Security\User\UziUser` class. You 
can fetch any information about the UZI card itself with `$this->getUser()->getUzi()`.


## Uses

puzi-php - [Proficient UZI pass reader in PHP](https://github.com/minvws/pUZI-php)

phpseclib - [PHP Secure Communications Library](https://phpseclib.com/)

## Contributing

1. Fork the Project

2. Ensure you have Composer installed (see [Composer Download Instructions](https://getcomposer.org/download/))

3. Install Development Dependencies

    ```sh
    composer install
    ```

4. Create a Feature Branch

5. (Recommended) Run the Test Suite

    ```sh
    vendor/bin/phpunit
    ```
6. (Recommended) Check whether your code conforms to our Coding Standards by running

    ```sh
    vendor/bin/phpstan analyse
    vendor/bin/phpcs
    ```

7. Send us a Pull Request

![pUZI](pUZI-hidden.svg "pUZI")
