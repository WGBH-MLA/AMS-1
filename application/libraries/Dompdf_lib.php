<?php

//define('DOM_PDF_HOME', dirname(dirname(__FILE__)));
//require_once(DOM_PDF_HOME . '/third_party/dompdf/dompdf_config.inc.php');
class Dompdf_lib
{

	var $_dompdf = NULL;

	function __construct()
	{
		require_once("dompdf/dompdf_config.inc.php");
		if (is_null($this->_dompdf))
		{
			$this->_dompdf = new DOMPDF();
		}
	}

	function convert_html_to_pdf($data, $filename = 'sample.pdf', $stream = TRUE)
	{

		$html = '<center><h2>Digitization Statistics</h2></center>';
		if (count($data['dsd_report']) > 0)
		{
			$html .='<div style="page-break-after: always;"><br/><div style="padding:5px;background-color:#5BC15B;font-size:18px;">Scheduled for Digitization</div><br/>';
			$html .='<table style="width:100%;><thead style="font-weight:bold;"><tr><td></td><td style="border-bottom:2px solid black;">Nominated Assets</td><td style="border-bottom:2px solid black;">City</td><td style="border-bottom:2px solid black;">State</td></tr></thead><tbody>';
			$total = 0;
			foreach ($data['dsd_report'] as $value)
			{
				$html .='<tr>';
				$html .='<td>' . $value->station_name . '</td>';
				$html .='<td>' . number_format($value->total) . '</td>';
				$html .='<td>' . $value->city . '</td>';
				$html .='<td>' . $value->state . '</td>';
				$html .='</tr>';
				$total = $total + $value->total;
			}
			$html .='<tr><td style="text-align:center;">Total</td><td style="border-top:2px solid black;">' . number_format($total) . '</td><td style="border-top:2px solid black;"></td><td style="border-top:2px solid black;"></td></tr>';
			$html .='</tbody></table></div>';
		}
		if (count($data['material_at_crawford_report']) > 0)
		{
			$html .='<div style="page-break-after: always;"><br/><div><h4 style="background-color:#748C47;">Materials at Crawford</h4></div><br/>';
			$html .='<table style="width:100%;><thead style="font-weight:bold;"><tr><td></td><td style="border-bottom:2px solid black;">Nominated Assets</td><td style="border-bottom:2px solid black;">City</td><td style="border-bottom:2px solid black;">State</td></tr></thead><tbody>';
			$total = 0;
			foreach ($data['material_at_crawford_report'] as $value)
			{
				$html .='<tr>';
				$html .='<td>' . $value->station_name . '</td>';
				$html .='<td>' . number_format($value->total) . '</td>';
				$html .='<td>' . $value->city . '</td>';
				$html .='<td>' . $value->state . '</td>';
				$html .='</tr>';
				$total = $total + $value->total;
			}
			$html .='<tr><td style="text-align:center;">Total</td><td style="border-top:2px solid black;">' . number_format($total) . '</td><td style="border-top:2px solid black;"></td><td style="border-top:2px solid black;"></td></tr>';
			$html .='</tbody></table></div>';
		}
		if (count($data['shipment_report']) > 0)
		{
			$html .='<div style="page-break-after: always;"><br/><div><h4 style="background-color:#748C47;">Files Delivered for Verification</h4></div><br/>';
			$html .='<table style="width:100%;><thead style="font-weight:bold;"><tr><td></td><td style="border-bottom:2px solid black;">Nominated Assets</td><td style="border-bottom:2px solid black;">City</td><td style="border-bottom:2px solid black;">State</td></tr></thead><tbody>';
			$total = 0;
			foreach ($data['shipment_report'] as $value)
			{
				$html .='<tr>';
				$html .='<td>' . $value->station_name . '</td>';
				$html .='<td>' . number_format($value->total) . '</td>';
				$html .='<td>' . $value->city . '</td>';
				$html .='<td>' . $value->state . '</td>';
				$html .='</tr>';
				$total = $total + $value->total;
			}
			$html .='<tr><td style="text-align:center;">Total</td><td style="border-top:2px solid black;">' . number_format($total) . '</td><td style="border-top:2px solid black;"></td><td style="border-top:2px solid black;"></td></tr>';
			$html .='</tbody></table></div>';
		}
		if (count($data['hd_return_report']) > 0)
		{

			$html .='<div style="page-break-after: always;"><br/><div><h4 style="background-color:#748C47;">Verified/Complete</h4></div><br/>';
			$html .='<table style="width:100%;><thead style="font-weight:bold;"><tr><td>Station Names</td></tr></thead><tbody>';
			foreach ($data['hd_return_report'] as $value)
			{
				$html .='<tr>';
				$html .='<td>' . $value->station_name . '</td>';

				$html .='</tr>';
			}
			$html .='</tbody></table></div>';
		}

		$this->_dompdf->load_html($html);
		$this->_dompdf->render();
		return $this->_dompdf->stream($filename, array("Attachment" => 0));
//        return $this->_dompdf->stream($filename);
//        if ($stream) {
//            $this->_dompdf->stream($filename);
//        } else {
		return $this->_dompdf->output();
//        }
	}

}

?>