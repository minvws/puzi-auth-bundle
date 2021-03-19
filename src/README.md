
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

Step 3: add the guard to your security.yml:

    firewalls:
        main:
            guard:
               authenticators:
                - puzi_auth.security.guard.authenticator
            stateless: true

At this point, an authenticated user will be of the `MinVWS\PUZI\AuthBundle\Security\User\UziUser` class. You 
can fetch any information about the UZI card itself with `$this->getUser()->getUzi()`.
