<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Api;

interface FormBuilderInterface
{
    /**
     * Return the all forms
     *
     * @api
     * @return array forms
     */
    public function forms();
    /**
     * Retrun the form from id
     *
     * @param int $id
     * @return []
     */
    public function formById($id);
    /**
     * Return the all response
     *
     * @api
     * @return array response
     */
    public function response();
    /**
     * Retrun the response id
     *
     * @param int $id
     * @return []
     */
    public function responseById($id);
     /**
      * Add new form via API.
      *
      * @api
      * @param string $name
      * @param string $urlKey
      * @param string $successUrl
      * @param string $status
      * @param array $forms_fields
      * @return string
      */
    public function newForm($name, $urlKey = null, $successUrl = null, $status = 1, $forms_fields = []);
}
