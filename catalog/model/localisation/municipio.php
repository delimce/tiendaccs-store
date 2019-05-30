<?php
class ModelLocalisationMunicipio extends Model
{

    public function getMunicipio($municipio_id)
    {
        $query = $this->db->query("SELECT * FROM op_municipio WHERE municipio_id = '" . intval($municipio_id) . "' AND status = '1'");
        return $query->row;
    }

    public function getMunicipiosByZoneId($zone_id)
    {

        $mun_data = $this->cache->get('municipio.' . intval($zone_id));

        if (!$mun_data) {
            $query = $this->db->query("SELECT * FROM op_municipio WHERE zone_id = '" . intval($zone_id) . "' AND status = '1' ORDER BY name");
            $mun_data = $query->rows;
            $this->cache->set('municipio.' . intval($zone_id), $mun_data);
        }
        return $mun_data;
    }
}
