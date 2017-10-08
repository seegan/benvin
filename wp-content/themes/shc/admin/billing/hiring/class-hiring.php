<?php
class Hiring {

	function __construct() {
	    if( isset($_POST['action']) ) {
	    	$params = array();
			parse_str($_POST['data'], $params);
	        $this->cpage = 1;
	        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
	        $this->lot_no = isset($params['lot_no']) ? $params['lot_no'] : '';
	        $this->product_name = isset($params['product_name']) ? $params['product_name'] : '';
	        $this->product_type = isset($params['product_type']) ? $params['product_type'] : '';
	    } else {
	        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
	        $this->lot_no = isset( $_GET['lot_no'] ) ? $_GET['lot_no']  : '';
	        $this->product_name = isset( $_GET['product_name'] ) ? $_GET['product_name']  : '';
	        $this->product_type = isset( $_GET['product_type'] ) ? $_GET['product_type']  : '';
	    }
	}

	function get_HiringItems($master_id = 0, $bill_from, $bill_to) {
		global $wpdb;
		$lots_table = $wpdb->prefix.'shc_lots';
		$delivery_table = $wpdb->prefix.'shc_delivery';
		$delivery_detail = $wpdb->prefix.'shc_delivery_detail';
		$return_table = $wpdb->prefix.'shc_return';
		$return_detail = $wpdb->prefix.'shc_return_detail';


	



		$return_query = "SELECT r.id FROM wp_shc_return as r WHERE ( CAST(r.return_date AS date) BETWEEN '${bill_from}' and '${bill_to}')  AND r.master_id = ${master_id} AND r.active = 1";

		$deposit_query = "SELECT d.id FROM wp_shc_deposit as d WHERE ( CAST(d.deposit_date AS date) BETWEEN '${bill_from}' and '${bill_to}') AND d.master_id = ${master_id} AND d.active = 1"; 



        $vat_transport_query = "SELECT SUM(u.unloading_charge) as unloading_charge FROM ( ${return_query} ) as t1 JOIN wp_shc_unloading as u ON t1.id = u.return_id WHERE u.active = 1";

        $data['vat_transport_charges'] = 0.00;
        $vat_transport_charge = $wpdb->get_row($vat_transport_query);
        if( $vat_transport_charge && $vat_transport_charge->unloading_charge ) {
            $data['vat_transport_charges'] = $vat_transport_charge->unloading_charge;
        }


		$loading_charge_query = "SELECT ( CASE WHEN SUM(l.loading_charge) is null THEN 0 ELSE SUM(l.loading_charge) END ) as loading_charge FROM ( ${deposit_query} ) as t2 JOIN wp_shc_loading as l ON t2.id = l.deposit_id WHERE l.active = 1";


        $unloading_charge_query = "SELECT SUM(ud.charge_amt) as unloading FROM ( SELECT u.id FROM ( ${return_query} ) as t1 JOIN wp_shc_unloading as u ON t1.id = u.return_id WHERE u.active = 1 ) f JOIN wp_shc_unloading_detail as ud ON f.id = ud.unloading_id WHERE ud.active = 1 AND ud.charge_for = 'unloading'";
        $transportation_charge_query = "SELECT SUM(ud.charge_amt) as transportation FROM ( SELECT u.id FROM ( ${return_query} ) as t1 JOIN wp_shc_unloading as u ON t1.id = u.return_id WHERE u.active = 1 ) f JOIN wp_shc_unloading_detail as ud ON f.id = ud.unloading_id WHERE ud.active = 1 AND ud.charge_for = 'transportation'";
        $damage_charge_query = "SELECT SUM(ud.charge_amt) as damage FROM ( SELECT u.id FROM ( ${return_query} ) as t1 JOIN wp_shc_unloading as u ON t1.id = u.return_id WHERE u.active = 1 ) f JOIN wp_shc_unloading_detail as ud ON f.id = ud.unloading_id WHERE ud.active = 1 AND ud.charge_for = 'damage'";


        $lost_charge_query = "SELECT SUM(l.lost_total) as lost FROM  ( ${return_query} ) as t1 JOIN wp_shc_lost as l ON t1.id = l.return_id WHERE l.active = 1 ";


        $data['unloading_charges'] = 0.00;
        $unloading_charge = $wpdb->get_row($unloading_charge_query);
        if( $unloading_charge && $unloading_charge->unloading ) {
            $data['unloading_charges'] = $unloading_charge->unloading;
        }

        $data['transportation_charges'] = 0.00;
        $transportation_charge = $wpdb->get_row($transportation_charge_query);
        if( $transportation_charge && $transportation_charge->transportation ) {
            $data['transportation_charges'] = $transportation_charge->transportation;
        }

        $data['damage_charges'] = 0.00;
        $damage_charge = $wpdb->get_row($damage_charge_query);
        if( $damage_charge && $damage_charge->damage ) {
            $data['damage_charges'] = $damage_charge->damage;
        }

        $data['loading_charges'] = 0.00;
        $loading_charge = $wpdb->get_row($loading_charge_query);
        if( $loading_charge && $loading_charge->loading_charge ) {
            $data['loading_charges'] = $loading_charge->loading_charge;
        }

        $data['lost_charges'] = 0.00;
        $lost_charge = $wpdb->get_row($lost_charge_query);
        if( $lost_charge && $lost_charge->lost ) {
            $data['lost_charges'] = $lost_charge->lost;
        }

        $data['delivery_charges'] = ($data['unloading_charges'] + $data['loading_charges'] + $data['transportation_charges']);





        $data['return_ids'] = false;
        $return_ids = $wpdb->get_results($return_query, ARRAY_A);

        if($return_ids) {
        	$rids = Array();
			foreach($return_ids as $r) $rids[] = $r['id'];
            $data['return_ids'] = implode (", ", $rids);
        }

		$query = "
SELECT bill.id, bill.master_id, bill.lot_id, bill.bill_qty, 

( 
	CASE 
	WHEN DATE(sdd.delivery_date) > DATE(bill.bill_from)
	THEN sdd.delivery_date
	ELSE bill.bill_from
	END
) as bill_from,
bill.bill_to,

DATEDIFF (

    DATE(bill.bill_to) , DATE
    

    ( 
		CASE 
		WHEN DATE(sdd.delivery_date) > DATE(bill.bill_from)
		THEN sdd.delivery_date
		ELSE bill.bill_from
		END
    )
    
)+1 as bill_days,



DATEDIFF (
    DATE(bill.bill_to) , DATE(sdd.delivery_date)
)+1 as total_days,


(

( DATEDIFF (

    DATE(bill.bill_to) , DATE
    

    ( 
	CASE 
	WHEN DATE(sdd.delivery_date) > DATE(bill.bill_from)
	THEN sdd.delivery_date
	ELSE bill.bill_from
	END
    )
    
)+1 ) * sdd.rate_per_unit * bill.bill_qty



) as bill_amount ,

got_return,



l.product_name, l.product_type, sdd.rate_per_unit, sdd.delivery_date,


 ( CASE 
 WHEN bill.got_return = 'yes' AND ( DATEDIFF ( DATE(bill.bill_to) , DATE(sdd.delivery_date) )+1 ) < 30
 
 THEN 'yes'
 
 ELSE 'no'
 
END ) as min_bill,

 ( CASE 
 WHEN bill.got_return = 'yes' AND ( DATEDIFF ( DATE(bill.bill_to) , DATE(sdd.delivery_date) )+1 ) < 30
 
 THEN (30*sdd.rate_per_unit * bill.bill_qty)
 
 ELSE 0
 
END ) as min_bill_amt,


 ( CASE 
 WHEN bill.got_return = 'yes' AND ( DATEDIFF ( DATE(bill.bill_to) , DATE(sdd.delivery_date) )+1 ) < 30
 
 THEN (30*sdd.rate_per_unit * bill.bill_qty) - 

  	(
        (
            DATEDIFF (
                DATE(bill.bill_to) , DATE(sdd.delivery_date)
            )+1
        ) 
        -
        (
            DATEDIFF (

                DATE(bill.bill_to) , DATE


                ( 
                    CASE 
                    WHEN DATE(sdd.delivery_date) > DATE(bill.bill_from)
                    THEN sdd.delivery_date
                    ELSE bill.bill_from
                    END
                )

            )+1
        )
	) * sdd.rate_per_unit * bill.bill_qty
 
 ELSE 0
 
END ) as min_bill_bal
 


FROM 

(
    
    
    SELECT t1.* FROM (
    
SELECT dd1.id, dd1.master_id, dd1.lot_id, 

(
  	dd1.qty - 
    (
        CASE 
        WHEN rr1.tot_qty IS NULL
        THEN 0
        ELSE rr1.tot_qty
        END
	)
) as bill_qty,

DATE('${bill_from}') as bill_from,
DATE('${bill_to}') as bill_to,
'no' as got_return

FROM 

(
 
    SELECT d1.*, 

( d1.qty - (CASE 
 WHEN r1.qty IS NULL
 THEN 0
 ELSE r1.qty
END )  ) as this_month_qty

FROM 

(
 SELECT dd.* FROM wp_shc_delivery as d JOIN wp_shc_delivery_detail as dd ON d.id = dd.delivery_id WHERE d.active = 1 AND dd.active = 1 AND dd.master_id = ${master_id} AND dd.delivery_date <= DATE('${bill_to}')
) as d1 

LEFT JOIN 

(
SELECT a.* FROM (SELECT fr.master_id, fr.delivery_detail_id, fr.lot_id, SUM(fr.qty) as qty, fr.return_date FROM ( SELECT rd.master_id, rd.delivery_detail_id, rd.lot_id, SUM(rd.qty) as qty, rd.return_date FROM wp_shc_return as r JOIN wp_shc_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND rd.active = 1 AND r.master_id = ${master_id} GROUP BY rd.return_date, rd.delivery_detail_id ) as fr GROUP BY ( fr.return_date < date('${bill_from}')), fr.delivery_detail_id ) as a WHERE a.return_date < date('${bill_from}')    
) as r1

ON d1.id = r1.delivery_detail_id WHERE 

( d1.qty - (CASE 
 WHEN r1.qty IS NULL
 THEN 0
 ELSE r1.qty
END )  ) > 0
    
) as dd1 

LEFT JOIN 


(
    
 SELECT b.master_id, b.delivery_detail_id, b.lot_id, SUM(b.qty) tot_qty FROM (
SELECT rd.master_id, rd.delivery_detail_id, rd.lot_id, SUM(rd.qty) as qty, rd.return_date FROM wp_shc_return as r JOIN wp_shc_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND rd.active = 1 AND r.master_id = ${master_id} GROUP BY rd.return_date, rd.delivery_detail_id
) as b WHERE  b.return_date <= date('${bill_to}') GROUP BY b.delivery_detail_id
    
) as rr1

ON dd1.id = rr1.delivery_detail_id
    
) as t1

UNION ALL

select t2.* FROM (

SELECT b.delivery_detail_id as id, b.master_id, b.lot_id, b.qty as bill_qty, DATE('${bill_from}') as bill_from, b.return_date as bill_to, 'yes' as got_return FROM (
SELECT rd.master_id, rd.delivery_detail_id, rd.lot_id, SUM(rd.qty) as qty, rd.return_date FROM wp_shc_return as r JOIN wp_shc_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND rd.active = 1 AND r.master_id = ${master_id} GROUP BY rd.return_date, rd.delivery_detail_id
) as b WHERE  b.return_date <= date('${bill_to}')

) as t2
    
) as bill


JOIN wp_shc_lots as l 

ON l.id = bill.lot_id

JOIN  wp_shc_delivery_detail as sdd

ON bill.id = sdd.id WHERE bill.bill_qty > 0 AND



( DATEDIFF (

    DATE(bill.bill_to) , DATE
    

    ( 
	CASE 
	WHEN DATE(sdd.delivery_date) > DATE(bill.bill_from)
	THEN sdd.delivery_date
	ELSE bill.bill_from
	END
    )
    
)+1 ) > 0 


 ORDER BY sdd.lot_id ASC, bill.bill_to DESC, bill.bill_qty DESC
		";


		$query1 = "SELECT fdf.id, fdf.master_id, fdf.lot_id, SUM(fdf.bill_qty) as bill_qty, fdf.bill_from, fdf.bill_to, fdf.bill_days, fdf.total_days, SUM(fdf.bill_amount) as bill_amount, fdf.got_return, fdf.product_name, fdf.product_type, fdf.rate_per_unit, fdf.delivery_date, fdf.min_bill, fdf.min_bill_amt, fdf.min_bill_bal FROM (".$query.") as fdf WHERE fdf.got_return = 'no' GROUP BY fdf.lot_id, fdf.bill_days, fdf.rate_per_unit";

		$query2 = "SELECT fdf.id, fdf.master_id, fdf.lot_id, fdf.bill_qty as bill_qty, fdf.bill_from, fdf.bill_to, fdf.bill_days, fdf.total_days, fdf.bill_amount, fdf.got_return, fdf.product_name, fdf.product_type, fdf.rate_per_unit, fdf.delivery_date, fdf.min_bill, fdf.min_bill_amt, fdf.min_bill_bal FROM (".$query.") as fdf WHERE fdf.got_return = 'yes'";

		$final_query = "SELECT * FROM (".$query1 .' UNION ALL '.$query2.") as full ORDER BY full.lot_id";
		//$final_query = $query1 .' UNION ALL '.$query2;


		$data['hiring_detail'] = $wpdb->get_results($final_query);
		return $data;
	}




	function get_BillHiringData($master_id = 0, $bill_id = 0) {
		global $wpdb;
	
		$hiring_table = $wpdb->prefix.'shc_hiring';
		$hiring_detail_table = $wpdb->prefix.'shc_hiring_detail';
		$lot_table = $wpdb->prefix.'shc_lots';

		$hiring_query = "SELECT * FROM ${hiring_table} WHERE active = 1 AND id = ${bill_id} AND master_id = ${master_id}";
		$hiring_data = $wpdb->get_row($hiring_query);
		if($hiring_data) {
			$data['hiring_data'] = $hiring_data;

			/*$detail_query = "SELECT hd.*, l.product_name, l.product_type FROM ${hiring_detail_table} as hd JOIN ${lot_table} as l ON hd.lot_id = l.id WHERE hd.hiring_bill_id = ${bill_id} AND hd.active = 1";*/

			$detail_query = "SELECT hd.lot_id, SUM(hd.qty) as qty, hd.bill_from, hd.bill_to, hd.bill_days, hd.rate_per_day, SUM(hd.amount) as amount, hd.min_checked, SUM(hd.hiring_amt) as hiring_amt,   l.product_name, l.product_type FROM ${hiring_detail_table} as hd JOIN ${lot_table} as l ON hd.lot_id = l.id WHERE hd.hiring_bill_id = ${bill_id} AND hd.active = 1 GROUP BY hd.lot_id, hd.bill_days, hd.rate_per_day, hd.min_checked, hd.bill_from, hd.bill_to";

			$data['hiring_detail'] = $wpdb->get_results($detail_query);

			return $data;
		}
		return false;
	}


	function get_BillHiringDataPrint($bill_id = 0) {
		global $wpdb;
	
		$hiring_table = $wpdb->prefix.'shc_hiring';
		$hiring_detail_table = $wpdb->prefix.'shc_hiring_detail';
		$lot_table = $wpdb->prefix.'shc_lots';
		$hiring_gst = $wpdb->prefix.'shc_hiring_gst';

		$hiring_query = "SELECT * FROM ${hiring_table} WHERE active = 1 AND id = ${bill_id}";
		$hiring_data = $wpdb->get_row($hiring_query);

		if($hiring_data) {
			$data['hiring_data'] = $hiring_data;

			/*$detail_query = "SELECT hd.*, l.product_name, l.product_type FROM ${hiring_detail_table} as hd JOIN ${lot_table} as l ON hd.lot_id = l.id WHERE hd.hiring_bill_id = ${bill_id} AND hd.active = 1";*/

			$detail_query = "SELECT hd.lot_id, SUM(hd.qty) as qty, hd.bill_from, hd.bill_to, hd.bill_days, hd.rate_per_day, SUM(hd.amount) as amount, hd.min_checked, SUM(hd.hiring_amt) as hiring_amt,   l.product_name, l.product_type FROM ${hiring_detail_table} as hd JOIN ${lot_table} as l ON hd.lot_id = l.id WHERE hd.hiring_bill_id = ${bill_id} AND hd.active = 1 GROUP BY hd.lot_id, hd.bill_days, hd.rate_per_day, hd.min_checked, hd.bill_from, hd.bill_to";

			$data['hiring_detail'] = $wpdb->get_results($detail_query);



			$hiring_gst_query = "SELECT * FROM ${hiring_gst} WHERE hiring_id = ${bill_id} AND active = 1";
			$data['hiring_gst_detail'] = $wpdb->get_results($hiring_gst_query);


			return $data;
		}
		return false;
	}


}



?>