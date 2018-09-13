<?php

class SimpleHtmlInvoice {

    private $html = '';
    private $lines = array();

    public function __construct($header = array(), $formatBlankFor = array()) {
        $cleanedHeader = $this->cleanHeader($header, $formatBlankFor);

        $this->html =  '<div class="invoice-box">';
        $this->html .=     '<table cellpadding="0" cellspacing="0">';
        $this->html .=          $this->topSection($cleanedHeader);
        $this->html .=          $this->informationSection($cleanedHeader);
        $this->html .=          $this->paymentSection($cleanedHeader);
        $this->html .=          $this->itemPriceHeading();

    }

    private function cleanHeader($header = array(), $formatBlankFor = array()) {
        $cleanedHeader = array();
        if (count($header) > 0) {
            if (!array_key_exists('logoStyle', $header)) {
                $header['logoStyle'] = '';
            }
            foreach($header as $headerKey => $headerValue) {
                $cleanedHeaderValue = $headerValue;
                if (in_array($headerKey, array('creationDate', 'dueDate'))) {
                    $cleanedHeaderValue = $this->formatDate($cleanedHeaderValue);
                } elseif ((strcasecmp($headerKey, 'logoStyle') == 0) && (strlen($cleanedHeaderValue) > 0)) {
                    $cleanedHeaderValue = 'width:100%; max-width:300px;';
                }
                if (in_array($headerKey, $formatBlankFor)) {
                    $cleanedHeaderValue = $this->formatBlank($cleanedHeaderValue);
                }
                $cleanedHeader[$headerKey] = $cleanedHeaderValue;
            }
        }
        return $cleanedHeader;
    }

    private function formatBlank($text = '') {
        if (strlen(trim($text)) == 0) {
            return 'N/A';
        }
        return $text;
    }

    private function formatDate($timestamp = 0) {
        if ($timestamp > 31557600) { // one year
            return date('', $timestamp);
        } else {
            return '';
        }
    }

    private function setLines($lines = array()) {
        $this->lines = $lines;
    }

    private function getLines() {
        return $this->lines;
    }

    private function linesDisplay() {

    }


    public function displayInvoice() {
        $this->html .=    '</table>';
        $this->html .= '</div>';
        return $this->html;
    }

    private function topSection($header = array()) {
        $html =  '<tr class="top">';
        $html .=    '<td colspan="2">';
        $html .=        '<table>';
        $html .=            '<tr>';
        $html .=                '<td class="title">';
        $html .=                    '<img src="' . $header['logoPath'] . '" style="' . $header['logoStyle'] . '">';
        $html .=                '</td>';
        $html .=                '<td>';
        $html .=                    'Invoice #: ' . $header['invoiceNumber'] . '<br>';
        if (strlen($header['creationDate']) > 0) {
            $html .=                'Created: ' . $header['creationDate'] . '<br>';
        }
        if (strlen($header['dueDate']) > 0) {
            $html .=                'Due: ' . $header['dueDate'];
        }
        $html .=                '</td>';
        $html .=            '</tr>';
        $html .=        '</table>';
        $html .=    '</td>';
        $html .= '</tr>';
        return $html;
    }

    private function formatAddressLineTwo($city = '', $state = '', $zip = '') {
        $cleanedCity = trim($city);
        $cleanedState = trim($state);
        $cleanedZip = trim($zip);
        $formattedAddressLineTwo = $cleanedCity;
        if ((strlen($formattedAddressLineTwo) > 0) && (strlen($cleanedState) > 0)) {
            $formattedAddressLineTwo .= ', ' . $cleanedState;
        }
        if ((strlen($formattedAddressLineTwo) > 0) && (strlen($cleanedZip) > 0)) {
            $formattedAddressLineTwo .= ' ' . $cleanedZip;
        }
        return $formattedAddressLineTwo;
    }

    private function informationSection($header = array()) {
        $html =  '<tr class="information">';
        $html .=    '<td colspan="2">';
        $html .=        '<table>';
        $html .=            '<tr>';
        $html .=                '<td>';
        $html .=                    $header['invoiceFromCompany'] . '<br>';
        $html .=                    $header['streetAddress'] . '<br>';
        $html .=                    $this->formatAddressLineTwo($header['ciy'], $header['state'] . $header['zip']);
        $html .=                '</td>';
        $html .=                '<td>';
        $html .=                    $header['invoiceToCompany'] . '<br>';
        $html .=                    $header['fullName'] . '<br>';
        $html .=                    $header['emailAddress'];
        $html .=                '</td>';
        $html .=            '</tr>';
        $html .=        '</table>';
        $html .=    '</td>';
        $html .= '</tr>';
        return $html;
    }

    private function paymentSection($header = array()) {
        $html =  '<tr class="heading">';
        $html .=    '<td>';
        $html .=        'Payment Method';
        $html .=    '</td>';
        $html .=    '<td>';
        $html .=        'Check #';
        $html .=    '</td>';
        $html .= '</tr>';
        $html .= '<tr class="details">';
        $html .=    '<td>';
        $html .=        'Check';
        $html .=    '</td>';
        $html .=    '<td>';
        $html .=        $header['checkNumber'];
        $html .=    '</td>';
        $html .= '</tr>';
        return $html;
    }

    private function itemPriceHeading() {
        $html =  '<tr class="heading">';
        $html .=    '<td>';
        $html .=        'Item';
        $html .=    '</td>';
        $html .=    '<td>';
        $html .=        'Price';
        $html .=    '</td>';
        $html .= '</tr>';
        return $html;
    }
}

?>
