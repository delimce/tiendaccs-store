<?php
class ModelLocalisationParroquia extends Model
{
    public function getParroquia($parroquia_id)
    {
        $query = $this->db->query("SELECT * FROM op_parroquia WHERE parroquia_id = '" . intval($parroquia_id) . "' AND status = '1'");
        return $query->row;
    }

    public function getParroquiasByMunicipioId($municipio_id)
    {
        $par_data = $this->cache->get('parroquia.' . intval($municipio_id));
        if (!$par_data) {
            $query = $this->db->query("SELECT * FROM op_parroquia WHERE municipio_id = '" . intval($municipio_id) . "' AND status = '1' ORDER BY name");
            $par_data = $query->rows;
            $this->cache->set('municipio.' . intval($municipio_id), $par_data);
        }
        return $par_data;
    }

}