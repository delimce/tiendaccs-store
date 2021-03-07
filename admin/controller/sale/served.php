<?php
class ControllerSaleServed extends Controller
{

    const ZONE = 'estado';
    const MUN = 'municipio';
    const PAR = 'parroquia';
    const DISPLAY_INLINE = 'show';
    const DISPLAY_NONE = 'hide';

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
        $data['no_served_selected'] = $this->language->get('no_served_selected');

        $this->load->model('sale/served');
        $localization = $this->model_sale_served->getLocalization();
        $served = $this->model_sale_served->getServedZones();

        $data['localization'] = $this->prepareLocalization($localization, $served);
        $data['served'] = $served;
        $this->response->setOutput($this->load->view('sale/served_form', $data));
    }

    /**
     * @return array
     */
    private function prepareLocalization($localization, $served)
    {
        if (!$served) {
            return $localization;
        }

        $newLocalization = array_map(function ($local) use ($served) {
            return $this->findInServedZones($local, $served);
        }, $localization);

        return $newLocalization;
    }

    private function findInServedZones($reg, $served)
    {

        foreach ($served as $s) {

            if ($s["level"] == self::ZONE && $s["level_id"] == $reg["zone_id"]) {
                $reg["z_display"] = self::DISPLAY_NONE;
            }

            if ($s["level"] == self::MUN && $s["level_id"] == $reg["municipio_id"]) {
                $reg["m_display"] = self::DISPLAY_NONE;
            }

            if ($s["level"] == self::PAR) {
                $parr = explode(",", $reg["parroquia"]);
                $reg["parroquia"] = $this->checkParr($parr, $s["level_id"]);
            }
        }

        return $reg;
    }


    private function checkParr($parr, $parId)
    {
        $result = [];
        foreach ($parr as $par) {
            $detail = explode("-", $par);
            $detail[2] = (intval($detail[0]) == intval($parId)) ? self::DISPLAY_NONE : $detail[2] ?? self::DISPLAY_INLINE;
            $result[] = implode("-", $detail);
        }
        return implode(",", $result);
    }

    public function servedList()
    {
        $this->load->model('sale/served');
        $served = $this->model_sale_served->getServedZones();
        $servedForm = '<div class="price-served">Precio por Kg.</div><br>';
        $servedForm .= '<ul>';
        array_walk($served, function ($item) use (&$servedForm) {
            $servedForm .= '<li>
                            <span class="served-item">
                                <span style="float:left">' . $item["level"] . ' ' . $item["name"] . '</span>
                                <span style="float:right" data-id="' . $item["id"] . '" data-level="' . $item["level"] . '" data-name="' . $item["name"] . '">
                                    <input class="shipping-price-input" type="number" value="' . $item["price_kg"] . '"/> 
                                    <span title="eliminar zona servida" class="remove-item">(-)</span>
                                </span>
                            </span>	
                            <br>
                        </li>';
        });

        $servedForm .= '</ul>';
        $servedForm .= '<div>
                            <br>
                            <input class="btn btn-primary" id="save-prices" name="save-prices"  type="submit" value="Guardar"/>
                            <span style="float:right;text-align:center;font-weight:bold" class="save-message"></span>
                        </div>';
        return $servedForm;
    }

    public function add()
    {

        $this->load->model('setting/setting');
        $price = $this->model_setting_setting->getSettingValue('default_price', 0);

        $this->load->model('sale/served');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->model_sale_served->addServedZone($this->request->post, $price);
            echo $this->servedList();
        }
        return false;
    }

    public function remove()
    {
        $this->load->model('sale/served');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->model_sale_served->removeServedZone($this->request->post);
            return true;
        }
        return false;
    }

    public function updatePrice()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('sale/served');
            $id = $this->request->post['id'];
            $price = $this->request->post['price'];
            $this->model_sale_served->updateServedPriceKG($id, $price);
            return true;
        }
        return false;
    }
}
