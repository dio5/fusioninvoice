<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/style.css">

    <style>
        * {
            margin: 0px;
            padding: 5px;
        }

        body {
            color: #000 !important;
        }

        table {
            width: 100%;
        }

        #header {
            padding: 0 0 30px;
        }

        #header table {
            width: 100%;
            padding: 0px;
        }

        #header table td, .amount-summary td {
            vertical-align: text-top;
            padding: 5px;
        }

        #company-name {
            color: #000;
            font-size: 14px;
        }

        #invoice-to td {
            text-align: left;
            vertical-align: top;
        }

        #invoice-to {
            padding: 0 0 20px;
            font-size: 16px;

        }

        #invoice-to-right-table td {
            padding-right: 5px;
            padding-left: 5px;
            text-align: right;
            vertical-align: top;
        }

        .seperator {
            height: 25px;
        }

        .top-border {
            border-top: none;
        }

        .no-bottom-border {
            border: none !important;
            background-color: white !important;
        }

        .table-striped tr {
            border: 1px solid #eaeaea;
        }

        #invoice-items table.table-striped th,
        #invoice-items table.table-striped td {
            padding: 12px 15px;
        }
    </style>

</head>
<body>
<div id="header">
    <table>
        <tr>
            <td id="company-name">
                <?php echo invoice_logo_pdf(); ?>
                <h2><?php echo $invoice->user_name; ?></h2>
                <br>

                <p>
                    <?php if ($invoice->user_address_1) {
                        echo $invoice->user_address_1 . '<br>';
                    } ?>
                    <?php if ($invoice->user_address_2) {
                        echo $invoice->user_address_2 . '<br>';
                    } ?>
                    <?php if ($invoice->user_city && $invoice->user_zip) {
                        echo $invoice->user_zip . ' ' . $invoice->user_city . '<br>';
                    } ?>
                    <?php if ($invoice->user_email) {
                        echo $invoice->user_email . '<br>';
                    } ?>
                    <?php if ($invoice->user_phone) { ?><?php echo $invoice->user_phone; ?><br><?php } ?>
                    <?php if ($invoice->user_fax) { ?><abbr>F:</abbr><?php echo $invoice->user_fax; ?><?php } ?>
                </p>
            </td>
            <td style="text-align: right;">
                <h3><?php echo lang('invoice'); ?> <?php echo $invoice->invoice_number; ?></h3>
                <br>

                <p>
                    <?php if ($invoice->user_custom_vat) {
                        echo "VAT: " . $invoice->user_custom_vat . '<br>';
                    } ?>
                    <?php if ($invoice->user_custom_iban) {
                        echo "IBAN: " . $invoice->user_custom_iban . '<br>';
                    } ?>
                    <?php if ($invoice->user_custom_bic) {
                        echo "BIC: " . $invoice->user_custom_bic . '<br>';
                    } ?>
                </p>
            </td>
        </tr>
    </table>
</div>
<div id="invoice-to">
    <table style="width: 100%;">
        <tr>
            <td style="padding-left: 5px;">
                <h5><?php echo lang('bill_to'); ?>:</h5>

                <p><?php echo $invoice->client_name; ?><br>
                    <?php if ($invoice->client_address_1) {
                        echo $invoice->client_address_1 . '<br>';
                    } ?>
                    <?php if ($invoice->client_address_2) {
                        echo $invoice->client_address_2 . '<br>';
                    } ?>
                    <?php if ($invoice->client_city) {
                        echo $invoice->client_city . ' ';
                    } ?>
                    <?php if ($invoice->client_state) {
                        echo $invoice->client_state . ' ';
                    } ?>
                    <?php if ($invoice->client_zip) {
                        echo $invoice->client_zip . '<br>';
                    } ?>
                    <?php if ($invoice->client_email) {
                        echo $invoice->client_email . '<br>';
                    } ?>
                    <?php if ($invoice->client_phone) {
                        echo $invoice->client_phone;
                    } ?>
                </p>
            </td>
            <td style="width:40%;"></td>
            <td style="text-align: right;">
                <table id="invoice-to-right-table">
                    <tbody>
                    <tr>
                        <td><?php echo lang('invoice_date'); ?>:</td>
                        <td><?php echo date_from_mysql($invoice->invoice_date_created, TRUE); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo lang('due_date'); ?>:</td>
                        <td><?php echo date_from_mysql($invoice->invoice_date_due, TRUE); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo lang('amount_due'); ?>:</td>
                        <td><?php echo format_currency($invoice->invoice_balance); ?></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id="invoice-items">
    <table class="table table-striped" style="width: 100%;">
        <thead>
        <tr>
            <th><?php echo lang('item'); ?></th>
            <th>&nbsp;</th>
            <th style="text-align: right;"><?php echo lang('qty'); ?></th>
            <th style="text-align: right;"><?php echo lang('price'); ?></th>
            <th style="text-align: right;"><?php echo lang('total'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?php echo $item->item_name; ?></td>
                <td><?php echo nl2br($item->item_description); ?></td>
                <td style="text-align: right;"><?php echo format_amount($item->item_quantity); ?></td>
                <td style="text-align: right;"><?php echo format_currency($item->item_price); ?></td>
                <td style="text-align: right;"><?php echo format_currency($item->item_subtotal); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <table>
        <tr>
            <td style="text-align: right; border: 1px solid #eaeaea;">
                <table class="amount-summary">
                    <tr>
                        <td style="text-align: right;"><?php echo lang('subtotal'); ?>:</td>
                        <td style="text-align: right;"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                    </tr>
                    <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                        <tr>
                            <td style="text-align: right;"><?php echo lang('item_tax'); ?></td>
                            <td style="text-align: right;"><?php echo format_currency($invoice->invoice_item_tax_total); ?></td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $invoice_tax_rate->invoice_tax_rate_name . ' ' . $invoice_tax_rate->invoice_tax_rate_percent; ?>
                                %
                            </td>
                            <td style="text-align: right;"><?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td style="text-align: right;"><?php echo lang('total'); ?>:</td>
                        <td style="text-align: right;"><?php echo format_currency($invoice->invoice_total); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><?php echo lang('paid'); ?>:</td>
                        <td style="text-align: right;"><?php echo format_currency($invoice->invoice_paid) ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><?php echo lang('balance'); ?>:</td>
                        <td style="text-align: right;">
                            <strong><?php echo format_currency($invoice->invoice_balance) ?></strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="seperator"></div>
    <?php if ($invoice->invoice_terms) { ?>
        <h4><?php echo lang('terms'); ?></h4>
        <p><?php echo nl2br($invoice->invoice_terms); ?></p>
    <?php } ?>
    <h4>
        All payments must be received within 14 days of invoice by (international) bank transfer.
    </h4>

    <p>
        Vrijstelling van BTW overeenkomstig artikel 39, paragraaf 1,1°, van het BTW-wetboek<br>
        Vrijstelling BTW wegens intracommunautaire levering van diensten.
    </p>


    <h5>Bank information:</h5>

    <p>
        ING België / Regio Oost-Vlaanderen / Gebied Gent<br>
        Agentschap Gent Zuid<br>
        Graaf Van Vlaanderenplein 7, 9000 Gent Belgium<br>
        Tel. 00 32 9 267 35 10 Fax. 00 32 9 267 35 18<br>
        Email: gent.zuid@ing.be<br>
    </p>

</div>
</body>
</html>