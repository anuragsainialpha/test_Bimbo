<style>
body
{
	font: Tahoma, Geneva, sans-serif;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: middle;
  border-top: 1px solid #eceeef;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #eceeef;
}

.table tbody + tbody {
  border-top: 2px solid #eceeef;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #000;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-success,
.table-success > th,
.table-success > td {
  background-color: #dff0d8;
}

.table-hover .table-success:hover {
  background-color: #d0e9c6;
}

.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
  background-color: #d0e9c6;
}

.table-info,
.table-info > th,
.table-info > td {
  background-color: #d9edf7;
}

.table-hover .table-info:hover {
  background-color: #c4e3f3;
}

.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
  background-color: #c4e3f3;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #fcf8e3;
}

.table-hover .table-warning:hover {
  background-color: #faf2cc;
}

.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
  background-color: #faf2cc;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f2dede;
}

.table-hover .table-danger:hover {
  background-color: #ebcccc;
}

.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
  background-color: #ebcccc;
}

.thead-inverse th {
  color: #fff;
  background-color: #292b2c;
}

.thead-default th {
  color: #464a4c;
  background-color: #eceeef;
}

.table-inverse {
  color: #fff;
  background-color: #292b2c;
}

.table-inverse th,
.table-inverse td,
.table-inverse thead th {
  border-color: #fff;
}

.table-inverse.table-bordered {
  border: 0;
}

.table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}

.table-responsive.table-bordered {
  border: 0;
}

</style>
<table class="table table-bordered" style="width:100%" cellpadding="0" cellspacing="0">
   <thead>
      <tr>
         <td style="background:#000; color:#FFF; text-align:center; height:30px; padding:0px">
            <h2 style="margin:0px">Bimbo Bakeries Cicero</h2>
         </td>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>
         	<table cellpadding="0" cellspacing="0" style="width:100%">
            	<tr>
                	<td style="border:0px; width:25%">
                    	<h1><b>IB LPN #</b></h1>
                    </td>
                    <td style="border:0px">
                    	<center><img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data={{ $info_LpnReceipt->lpn_nbr }}&code=Code128&dpi=96&dataseparator='/>  </center>
                    </td>
                </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td style="background:#000;  text-align:center;  color:#FFF; padding:0px">
            <h4 style="margin:0px">
            Receipt Information
            <h4>
         </td>
      </tr>
      <tr>
         <td style="text-align:center;">
            <h2>
            <b>IB SHIPMENT # {{ $info_Receipt->wms_asn_nbr }}</b>
            <h2>
         </td>
      </tr>
      <tr>
         <td style="padding:0px">	
         	<table class="table table-bordered" width="100%"  style="margin:0px" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:50%">
                    	Receipt Date: {{ date('m/d/Y') }}&nbsp;&nbsp;&nbsp;{{ date('H:i') }}
                    </td>
                    <td>
                    	Total Quantity Received: <b>{{ $info_LpnReceipt->current_qty }}</b>
                    </td>
                </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td style="background:#000;  text-align:center;  color:#FFF; padding:0px">
            <h4 style="margin:0px">
            Item Information
            <h4>
         </td>
      </tr>
      <tr>
         <td style="padding:0px">	
         	<table class="table table-bordered" width="100%"  style="margin:0px" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:30%; padding:0px">
                    	<h1 style="margin:0px">Item: {{ $info_LpnReceipt->item_code }}</h1>
                    </td>
                	<td style="padding:0px; text-align:center">
                    	<h1 style="margin:0px">Description</h1>
                    </td>
                </tr>
                <tr>
                	<td>
                    	<center>
                         <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data={{ $info_LpnReceipt->item_code }}&code=Code128&dpi=96&dataseparator='/></center>
                    </td>
                    <td>
                    	Description
                        {{ $info_LpnReceipt->OwmItem()->First()->description }}
                    </td>
                </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td style="padding:0px">	
         	<table class="table table-bordered" width="100%" style="margin:0px" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:15%">
                    	<center>Lot # {{ $info_LpnReceipt->batch_nbr }}</center>

                    </td>
                    <td rowspan="2">
                    	<center>
                        <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data={{ $info_LpnReceipt->batch_nbr }}&code=Code128&dpi=96&dataseparator='/></center>
                    </td>
                </tr>
                <tr>
                	<td>
                    	<center>
                        Expiration Date:<br>
                        <h3 style="margin:0px">{{ date('m/d/Y', strtotime($info_LpnReceipt->expire_date)) }}</h3>
                        </center>
                    </td>
                </tr>
                
            </table>
         </td>
      </tr>
      <tr>
         <td style="padding:0px">
         	<table class="table table-bordered" width="100%"  style="margin:0px" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="border:0px; border-right:5px solid #000; width:50%">
                    	<center><b>BUSS CODE</b><br />
                        <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data={{ $info_LpnReceipt->OwmItem()->First()->external_style }}&code=Code128&dpi=96&dataseparator='/></center>
                    </td>
                    <td style="border:0px;">
                    	Weight LPN:<br />
                        <center><h1>{{ $info_LpnReceipt->OwmItem()->First()->unit_weight * $info_LpnReceipt->current_qty }}</h1></center>
                    </td>
                </tr>
            </table>	
         </td>
      </tr>
   </tbody>
</table>