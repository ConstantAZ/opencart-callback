<?php
class ControllerModuleCallback extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('module/callback');
        $this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
        $this->document->addScript('catalog/view/javascript/module/callback/callback.js');
        $this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/callback.css')) {
            $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/callback.css');
        } else {
            $this->document->addStyle('catalog/view/theme/default/stylesheet/callback.css');
        }
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['link_message'] = $this->language->get('link_message');
        $this->data['js_request_error'] = $this->language->get('js_request_error');
        $this->data['js_request_timeout'] = $this->language->get('js_request_timeout');
        $this->data['form_link'] = $this->url->link('module/callback/form');
        $this->data['description_message'] = $this->language->get('description_message');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/callback.module.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/callback.module.tpl';
        } else {
            $this->template = 'default/template/module/callback.module.tpl';
        }
        $this->response->setOutput($this->render());
    }

    public function form() {
        $this->language->load('module/callback');
        $this->document->setTitle($this->language->get('heading_title'));
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $text = sprintf($this->language->get('email_message'),
                $this->request->post['name'],
                $this->request->post['phone'],
                (trim($this->request->post['time'])!='' ? $this->request->post['time'] : ''));
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $email_to = $this->config->get('email_to');
            $email_to = empty($email_to) ? $this->config->get('config_email') : $email_to;
            $mail->setTo($email_to);
            $mail->setFrom($this->config->get('config_email'));
              $mail->setSender($this->request->post['name']);
              $mail->setSubject(strip_tags(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8')));
              $mail->setText(strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8')));
              $mail->send();
              $this->redirect($this->url->link('module/callback/success'));
        }
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['description_message'] = $this->language->get('description_message');
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_phone'] = $this->language->get('entry_phone');
        $this->data['entry_time'] = $this->language->get('entry_time');
        $this->data['entry_captcha'] = $this->language->get('entry_captcha');
        $this->data['entry_submit'] = $this->language->get('entry_submit');
        $this->data['placeholder_name'] = $this->language->get('placeholder_name');
        $this->data['placeholder_time'] = $this->language->get('placeholder_time');
        $this->data['placeholder_phone'] = $this->language->get('placeholder_phone');
        $this->data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';
        $this->data['error_phone'] = isset($this->error['phone']) ? $this->error['phone'] : '';
        $this->data['error_time'] = isset($this->error['time']) ? $this->error['time'] : '';
        $this->data['error_captcha'] = isset($this->error['captcha']) ? $this->error['captcha'] : '';
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['action'] = $this->url->link('module/callback/form');
        $this->data['name'] = isset($this->request->post['name']) ? $this->request->post['name'] : $this->customer->getFirstName();
        $this->data['phone'] = isset($this->request->post['phone']) ? $this->request->post['phone'] : $this->customer->getTelephone();
        $this->data['time'] = isset($this->request->post['time']) ? $this->request->post['time'] : '';
        $this->data['use_captcha'] = (!$this->customer->isLogged() && $this->config->get('use_captcha')) ? true : false;
        $this->data['captcha'] = isset($this->request->post['captcha']) ? $this->request->post['captcha'] : '';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/callback.form.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/callback.form.tpl';
        } else {
            $this->template = 'default/template/module/callback.form.tpl';
        }
        $this->response->setOutput($this->render());
    }

    public function success() {
        $this->language->load('module/callback');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_message'] = $this->language->get('success_message');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] = $this->url->link('common/home');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/callback.success.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/callback.success.tpl';
        } else {
            $this->template = 'default/template/module/callback.success.tpl';
        }
        $this->response->setOutput($this->render());
    }

    private function validate() {
        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
            $this->error['name'] = $this->language->get('error_name');
        }
        if(!preg_match('#^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$#', $this->request->post['phone'])){
            $this->error['phone'] = $this->language->get('error_phone');
        }
        if(!$this->customer->isLogged() && $this->config->get('use_captcha')){
            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $this->error['captcha'] = $this->language->get('error_captcha');
            }
        }
        if (!$this->error) {
            return true;
        }
        return false;
    }

    public function captcha() {
        $this->load->library('captcha');
        $captcha = new Captcha();
        $this->session->data['captcha'] = $captcha->getCode();
        $captcha->showImage();
    }
}
?>
