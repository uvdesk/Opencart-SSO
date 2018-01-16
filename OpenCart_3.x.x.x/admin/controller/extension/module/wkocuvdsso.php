<?php

class ControllerExtensionModuleWkocuvdsso extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('extension/module/wkocuvdsso');
		$this->model_extension_module_wkocuvdsso->createTable();
	}

	public function uninstall() {
		$this->load->model('extension/module/wkocuvdsso');
		$this->model_extension_module_wkocuvdsso->dropTable();
	}

	public function index() {
		$data = array_merge($this->load->language('extension/module/wkocuvdsso'));

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('extension/module/wkocuvdsso');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_wkocuvdsso', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} elseif (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['apps'] = $this->model_extension_module_wkocuvdsso->getApp();

		if ($data['apps']) {
			foreach ($data['apps'] as $key => $app) {
				$data['apps'][$key]['edit'] = $this->url->link('extension/module/wkocuvdsso/add', 'user_token=' . $this->session->data['user_token']."&id=".$app['id'], true);
			}
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['add'] = $this->url->link('extension/module/wkocuvdsso/add', 'user_token=' . $this->session->data['user_token'], true);

		$data['delete'] = $this->url->link('extension/module/wkocuvdsso/delete', '' , true);

		$data['action'] = $this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

		$config_array = array(
			'module_wkocuvdsso_status',
		);

		foreach ($config_array as $config_val) {

			if (isset($this->request->post[$config_val])) {
				$data[$config_val] = $this->request->post[$config_val];
			} else {
				$data[$config_val] = $this->config->get($config_val);
			}

		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wkocuvdsso', $data));
	}

	public function add(){
		$data = array_merge($this->load->language('extension/module/wkocuvdsso'));

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/wkocuvdsso');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAdd()) {
			$this->model_extension_module_wkocuvdsso->add($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true));
		}

		if (($this->request->server['REQUEST_METHOD'] != 'POST') && isset($this->request->get['id']) && $this->request->get['id']) {
			$data['app'] = $this->model_extension_module_wkocuvdsso->getApp($this->request->get['id']);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_add'),
			'href' => $this->url->link('extension/module/wkocuvdsso/add', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (isset($this->request->get['id']) && $this->request->get['id']) {
			$data['action'] = $this->url->link('extension/module/wkocuvdsso/add', 'user_token=' . $this->session->data['user_token'] . '&id=' . $this->request->get['id'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/wkocuvdsso/add', 'user_token=' . $this->session->data['user_token'], true);
		}

		$data['cancel'] = $this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wkocuvdsso_form', $data));
	}

	public function delete() {
		$this->load->language('extension/module/wkocuvdsso');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['selected']) && $this->request->post['selected']){
				$this->load->model('extension/module/wkocuvdsso');

				$this->model_extension_module_wkocuvdsso->deleteApp(implode(',',$this->request->post['selected']));

				$this->session->data['success'] = $this->language->get('text_success_delete');
			} else {
				$this->session->data['warning'] = $this->language->get('error_selected');
			}
		} else {
			$this->session->data['warning'] = $this->language->get('error_permission');
		}

		$this->response->redirect($this->url->link('extension/module/wkocuvdsso', 'user_token=' . $this->session->data['user_token'], true));
	}

	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/wkocuvdsso')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateAdd() {

		if (!$this->user->hasPermission('modify', 'extension/module/wkocuvdsso')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['name'] || !$this->request->post['email'] || !$this->request->post['url'] || !$this->request->post['cancel_url']) {
			$this->error['warning'] = $this->language->get('error_field');
		}

		return !$this->error;
	}
}
