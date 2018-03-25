<?php
/**
 * @package     VladFlonta\InlineTranslationFix
 * @author      Vlad Flonta
 * @copyright   Copyright © 2018
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace VladFlonta\InlineTranslationFix\Model\Inline;

class Parser extends \Magento\Translation\Model\Inline\Parser
{
    /**
     * Format translation for special tags.  Adding translate mode attribute for vde requests.
     *
     * @param string $tagHtml
     * @param string $tagName
     * @param array $trArr
     * @return string
     */
    protected function _applySpecialTagsFormat($tagHtml, $tagName, $trArr)
    {
        foreach ($trArr as &$tr) {
            $tr = str_replace('\\\\', '\\', $tr);
        }
        $specialTags = $tagHtml . '<span class="translate-inline-' . $tagName . '" ' . $this->_getHtmlAttribute(
            self::DATA_TRANSLATE,
            htmlspecialchars('[' . join(',', $trArr) . ']')
        );
        $additionalAttr = $this->_getAdditionalHtmlAttribute($tagName);
        if ($additionalAttr !== null) {
            $specialTags .= ' ' . $additionalAttr . '>';
        } else {
            $specialTags .= '>' . strtoupper($tagName);
        }
        $specialTags .= '</span>';
        return $specialTags;
    }

    /**
     * Get html element attribute
     *
     * @param string $name
     * @param string $value
     * @return string
     */
    protected function _getHtmlAttribute($name, $value)
    {
        return $name . '=' . $this->_getHtmlQuote() . $value . $this->_getHtmlQuote();
    }

    /**
     * Get html quote symbol
     *
     * @return string
     */
    protected function _getHtmlQuote()
    {
        if ($this->_isJson) {
            return '\"';
        } else {
            return '"';
        }
    }
}
