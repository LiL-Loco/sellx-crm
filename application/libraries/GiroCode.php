<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
$payment
    ->setCharacterSet(CharacterSet::UTF_8)
    ->setBic("AIRACZPP")
    ->setBeneficiaryName("My Cool Company")
    ->setAmount(100)
    ->setPurpose(Purpose::ACCOUNT_MANAGEMENT)
    ->setRemittanceText("Invoice ID: XXX")
    ->setCreditorReference('RF123456') // setting both creditor reference and remittance text will actually result in exception
    ->setInformation("This is some note")
    ->setCurrency("EUR");