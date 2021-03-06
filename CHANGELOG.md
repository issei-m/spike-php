Changelog
=========

- 1.0-BETA5 (201x-xx-xx)
  - Start supporting PHP 7.2
  - Ensure dev stuff (e.g. tests, .gitignore, etc) is removed when package installation by adding `.gitattributes`

- 1.0-BETA4 (2016-12-22)
  - Starting PHP 7.1 support
  - Fix wrong parameter of charge api
  - Rename ChargeRequest::getCard(), setCard() methods to getToken(), setToken() (BC break)
  - Rename RecursiveObjectFactoryConverterBuilder::getBuilder() method to getConverter() (BC break)

- 1.0-BETA3 (2015-05-14)
  - Spike::getCharges(), ::setCard() and ::refund() methods now allow to be passed related object as a string
  - added ObjectList model object
  - now supports Dispute object
  - now supports capturing the charge
  - renamed Spike::getToken() method to requestToken() (BC Break)
  - Spike::getToken() method is now used to retrieve the token object

- 1.0-BETA2 (2015-03-30)
  - Charge/RefundFactory now uses system default timezone if none is specified
  - Spike::charge() now avoids error even if request has not set any value at all
  - added Spike::getToken to support retrieving a token interface (fixed #2)
  - added ObjectConverterInterface and replaced Spike's 2nd constructor argument with it (BC Break)
  - moved MoneyFactoryTrait to Util (BC Break)
  - added DateTimeUtil in favor of using TimeZoneSpecifiableTrait (BC Break)
  - Charge/Token now implement __toString()

- 1.0-BETA1 (2015-01-16)
  - renamed ApiErrorException to RequestException and changed its constructor signature
  - now uses Money class for dealing with money
  - Exception now extends \RuntimeException
  - now supports GuzzleHttp client as implementation of ClientInterface
  - changed Spike::__construct signature

- 1.0-alpha1 (2015-01-08)
  - first alpha release
