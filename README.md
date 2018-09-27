# Simple HTML Invoice PHP
Create invoices from this template: https://github.com/sparksuite/simple-html-invoice-template

## Example

```php
echo '<link rel="stylesheet" type="text/css" href="styles.css">';

require_once('../SimpleHtmlInvoice.php');
$header = array(
    'logoPath' => 'logo.png',
    'logoStyle' => '',
    'invoiceNumber' => 5,
    'creationDate' => 0,
    'dueDate' => 0,
    'invoiceFromCompany' => 'Tester Co.',
    'streetAddress' => '7 Maple Tree',
    'ciy' => 'Oaktown',
    'state' => 'NJ',
    'zip' => '03315',
    'invoiceToCompany' => 'User Inc.',
    'fullName' => 'Peter Keller',
    'emailAddress' => 'pete@gmail.com',
    'checkNumber' => '5000'
);

$lines = array(
    array("description" => "Test 1", "price" => 199),
    array("description" => "Test 2", "price" => 1099),
    array("description" => "Test 3", "price" => 1000000),
);

$formatBlankFor = array('checkNumber', 'fullName');
$simpleHtmlInvoice = new SimpleHtmlInvoice($header, $formatBlankFor);
$simpleHtmlInvoice->setLines($lines);
$simpleHtmlInvoice->addLines(true);
echo $simpleHtmlInvoice->displayInvoice();
```