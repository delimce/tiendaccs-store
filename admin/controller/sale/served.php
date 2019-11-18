<?php
class ControllerSaleServed extends Controller
{

    public function index()
    {
        $this->load->language('sale/served');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getForm();
    }

    public function getForm()
    {
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['served_title'] = $this->language->get('served_title');

        $this->load->model('sale/served');
        $data['localization'] = $this->model_sale_served->getLocalization();

        $this->response->setOutput($this->load->view('sale/served_form', $data));
    }
}
