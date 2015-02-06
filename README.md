# Barcode Printer

Barcode Printer is a simple tool to create and print barcodes. Just set your desired configuration, check the result and print :)

You can use Barcode Printer three ways:
  - Using the full editor: /barcode/index.php
  - Directly calling the desired configuration, using the appropriate GET variables: /barcode/index.php?digits=10&howManyCodes=12&etc
  - Directly linking the final barcodeImage: &lt;img src='/barcode/barcode.php?codetype=code128&size=150&text=testing'&gt;

Supported barcodes format are:
  - code128
  - code39
  - code25
  - codabar
  - qrcode (thanks to Google chart API)

## Contributing

Your feedback is precious! Don't hesitate to open a [GitHub Issue](https://github.com/ToX82/barcode-printer/issues) for any problem or question you may have.

All contributions are welcome. If you extend it, please create a pull request so that I can update it for everyone.