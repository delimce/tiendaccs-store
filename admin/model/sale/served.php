<?php
class ModelSaleServed extends Model
{

    const PRICE_KG = 10000;                 

    /**
     * @return array
     */
    public function getLocalization()
    {
        $query = $this->db->query("SELECT DISTINCT
        z.zone_id,
        'show' AS z_display,
        'show' AS m_display,
        z.`name` AS zone,
        m.municipio_id,
        m.`name` AS mun,
    GROUP_CONCAT(p.parroquia_id,'-',p.`name`)	 AS parroquia 
    FROM
        oc_zone AS z
        INNER JOIN op_municipio AS m ON z.zone_id = m.zone_id
        INNER JOIN op_parroquia AS p ON m.municipio_id = p.municipio_id 
    WHERE
        z.country_id = 229 
        AND z.`status_served` = 1 
        AND m.`status` = 1 
        AND p.`status` = 1 
            GROUP BY m.municipio_id
    ORDER BY
        z.`name` ASC,
        m.`name` ASC
    ");

        return $query->rows;
    }

    /**
     * @return array|boolean
     */
    public function getServedZones()
    {
        $query = $this->db->query("select * from op_served_zone");
        return $query->rows ?? false;
    }


    public function addServedZone($data)
    {
        $this->db->query("INSERT INTO op_served_zone SET
         level = '" . $this->db->escape($data['level']) . "',
         level_id = '" . $this->db->escape($data['level_id']) . "',
         name = '" . $this->db->escape($data['name']) . "',
         price_kg = '" . self::PRICE_KG . "',
         date_added = NOW()");

        return $this->db->getLastId();
    }

    public function removeServedZone($data)
    {
        $this->db->query("delete from op_served_zone where id = {$data['served_id']}");
    }
}
