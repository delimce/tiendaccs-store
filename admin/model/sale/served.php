<?php
class ModelSaleServed extends Model {

    public function getLocalization() {
        $query = $this->db->query("SELECT DISTINCT
        z.zone_id,
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
        AND m.`status` = 1 
        AND m.`status` = 1 
        AND p.`status` = 1 
            GROUP BY m.municipio_id
    ORDER BY
        z.`name` ASC,
        m.`name` ASC
    ");

		return $query->rows;
	}

}