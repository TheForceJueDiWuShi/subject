<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_message extends MY_Model {

    private $_table = 't_message';

    public function __construct() {
        parent::__construct($this->_table);
    }
}