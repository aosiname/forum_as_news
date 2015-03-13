<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 13/03/2015
 * Time: 10:43
 */
// bad attempt to change the block title using a form... NOT USED
class block_simplehtml_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('blockstring', 'block_forum_as_news'));
        $mform->setDefault('config_text', 'default value');
        $mform->setType('config_text', PARAM_RAW);

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_forum_as_news'));
        $mform->setDefault('config_title', 'default value');
        $mform->setType('config_title', PARAM_MULTILANG);

    }

    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = $this->config->title;
        } else {
            $this->config->title = 'Default title ...';
        }

        if (empty($this->config->text)) {
            $this->config->text = 'Default text ...';
        }
    }
}