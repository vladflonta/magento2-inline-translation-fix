# Magento 2 Inline Translation Fix

Fixes inline translation from within script tag elements.

## Installation steps

1. Get the module via composer
   ```
   composer require "vladflonta/magento2-inline-translation-fix":"~1.0"
   ```

   or via git 
   ```
   git clone https://github.com/vladflonta/magento2-inline-translation-fix app/code/VladFlonta/InlineTranslationFix
   ```

2. Enable module

```
bin/magento module:enable VladFlonta_InlineTranslationFix
bin/magento setup:upgrade
```

## License

This project is licensed under the [Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)
