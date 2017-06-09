<?php
class ControllerAccountWkocuvdssologin extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->model('account/wkocuvdssologin');

        if (($this->request->server['REQUEST_METHOD'] != 'POST')) {
            if (!isset($this->request->get['client_id']) || !isset($this->request->get['redirect_url']) || !$this->request->get['client_id'] || !$this->request->get['redirect_url']) {
                $this->response->redirect($this->url->link('common/home', '', 'SSL'));
            } else {
                if (!$this->model_account_wkocuvdssologin->getApp($this->request->get['client_id'], $this->request->get['redirect_url'])) {
                    $this->response->redirect($this->url->link('common/home', '', 'SSL'));
                }
            }
        }

        $json = array();

        $appdetails = $this->model_account_wkocuvdssologin->getApp($this->request->get['client_id'], $this->request->get['redirect_url']);

        $this->load->model('account/customer');

        if ($this->customer->isLogged()) {
            $this->session->data['apptoken'] = md5(mt_rand());

            $this->response->redirect($this->url->link('account/wkocuvdssologin/authorize', 'client_id=' . $this->request->get['client_id'] . '&redirect_url=' . $this->request->get['redirect_url'] . '&cancel_url=' . $appdetails['cancel_url'], 'SSL'));
        }

        $this->load->language('account/wkocuvdssologin');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // Unset guest
            unset($this->session->data['guest']);

            // Default Shipping Address
            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if (version_compare('VERSION','>=','2.1.0.0')) {
              // Wishlist
              if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
                  $this->load->model('account/wishlist');

                  foreach ($this->session->data['wishlist'] as $key => $product_id) {
                      $this->model_account_wishlist->addWishlist($product_id);

                      unset($this->session->data['wishlist'][$key]);
                  }
              }
            }

            $this->session->data['apptoken'] = md5(mt_rand());

            $this->response->redirect($this->url->link('account/wkocuvdssologin/authorize', 'client_id=' . $this->request->get['client_id'] . '&redirect_url=' . $this->request->get['redirect_url'] . '&cancel_url=' . $appdetails['cancel_url'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_new_customer'] = $this->language->get('text_new_customer');
        $data['text_register'] = $this->language->get('text_register');
        $data['text_register_account'] = $this->language->get('text_register_account');
        $data['text_returning_customer'] = $this->language->get('text_returning_customer');
        $data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
        $data['text_forgotten'] = $this->language->get('text_forgotten');

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_password'] = $this->language->get('entry_password');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_login'] = $this->language->get('button_login');

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $url = '';

        if (isset($this->request->get['client_id']) && $this->request->get['client_id']) {
            $url .= '&client_id='.$this->request->get['client_id'];
        }

        if (isset($this->request->get['redirect_url']) && $this->request->get['redirect_url']) {
            $url .= '&redirect_url='.$this->request->get['redirect_url'];
        }

        $data['action'] = $this->url->link('account/wkocuvdssologin', $url, 'SSL');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wkocuvdssologin.tpl')) {
          $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/wkocuvdssologin.tpl' , $data));
        } else {
          $this->response->setOutput($this->load->view('default/template/account/wkocuvdssologin.tpl' , $data));
        }
    }

    protected function validate()
    {
        // Check how many login attempts have been made.
        $login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

        if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->error['warning'] = $this->language->get('error_attempts');
        }

        // Check if customer has been approved.
        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = $this->language->get('error_approved');
        }

        if (!$this->error) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                $this->error['warning'] = $this->language->get('error_login');

                $this->model_account_customer->addLoginAttempt($this->request->post['email']);
            } else {
                $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
            }
        }

        return !$this->error;
    }

    public function authorize()
    {
        $this->load->model('account/wkocuvdssologin');

        $data = array_merge($this->load->language('account/wkocuvdssologin'));

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->session->data['apptoken']) && ($this->request->get['client_id']) && $this->request->get['client_id'] && isset($this->request->get['redirect_url']) && $this->request->get['redirect_url'] && isset($this->request->get['cancel_url']) && $this->request->get['cancel_url']) {
            $appdetails = $this->model_account_wkocuvdssologin->getApp($this->request->get['client_id'], $this->request->get['redirect_url']);

            if ($appdetails) {
                $apptoken = $this->session->data['apptoken'];

                $client_secret = $appdetails['client_secret'];

                $this->model_account_wkocuvdssologin->addCustomerToken($apptoken, $client_secret);

                $data['text_app'] = sprintf($this->language->get('text_app'), $appdetails['name']);

                if (strpos($this->request->get['redirect_url'],"?")) {
                  $data['redirect_url'] = $this->request->get['redirect_url'] . "&apptoken=".$apptoken;
                } else {
                  $data['redirect_url'] = $this->request->get['redirect_url'] . "?apptoken=".$apptoken;
                }

                $data['cancel_url'] = $this->request->get['cancel_url'];

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/authorize.tpl')) {
            			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/authorize.tpl' , $data));
            		} else {
            			$this->response->setOutput($this->load->view('default/template/account/authorize.tpl' , $data));
            		}
            } else {
                $this->response->redirect($this->url->link('common/home', '', 'SSL'));
            }
        } else {
            $this->response->redirect($this->url->link('common/home', '', 'SSL'));
        }
    }

    public function getJWTToken()
    {
        require 'system/library/jwt/src/JWT.php';

        $this->load->model('account/wkocuvdssologin');

        $json = array();

        $token = '';

        if (isset($this->request->get['apptoken']) && $this->request->get['apptoken']) {
            $token = $this->request->get['apptoken'];
        } elseif (isset($this->request->post['apptoken']) && $this->request->post['apptoken']) {
            $token = $this->request->post['apptoken'];
        }

        if (!$token) {
            $json['error'] = 'Invalid App Token';
        } else {

            $customer_info = $this->model_account_wkocuvdssologin->getCustomerDetail($token);

            $app_info = $this->model_account_wkocuvdssologin->getAppInfo($token);

            if ($customer_info) {

                $date = new DateTime(date('Y-m-d H:i:s'));

                $date->modify("+1 hours");

                $date_expire = strtotime($date->format("Y-m-d H:i:s"));

                $redirect_url = explode('.com',$app_info['redirect_url']);

                $payload_array = array(
                  'iss' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER,
                  'sub' => 'JWT Token',
                  'aud' => isset($redirect_url[1]) ? $redirect_url[0].'.com' : $redirect_url[0],
                  'exp' => $date_expire,
                  'nbf' => strtotime(date('Y-m-d H:i:s')),
                  'iat' => strtotime(date('Y-m-d H:i:s')),
                  //'jti' => ,
                  'name' =>  $customer_info['name'],
                  'email' => $customer_info['email'],
                );

                $payload = json_encode($payload_array);

                $json['success'] = true;

                $json['jwt_token'] = Firebase\JWT\JWT::encode($payload, $customer_info['client_secret']);

                $this->model_account_wkocuvdssologin->deleteCustomerDetail($token);
            } else {
                $json['success'] = false;
                $json['error'] = 'Invalid App Token';
            }
        }

        $this->response->addHeader('Content-Type: application/json');

        $this->response->setOutput(json_encode($json));
    }
}
