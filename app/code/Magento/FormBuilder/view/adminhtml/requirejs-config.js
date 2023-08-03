/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
var config = {
    map: {
        '*': {
            FormBuilder:"Webkul_FormBuilder/js/form-builder.min",
            formbuilderCustom:"Webkul_FormBuilder/js/formbuilderCustom",
        }
    },
    "shim": {
        "FormBuilder": ["jquery"],
        "formbuilderCustom": ["FormBuilder"]
    }
}