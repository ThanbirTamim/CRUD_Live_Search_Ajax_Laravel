<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveSearch extends Controller
{
    function index()
    {
        return view('live_search');
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('tbl_customers')->orderBy('id','desc')->get();
            echo json_encode($data);
        }
    }

    function add_data(Request $request)
    {
        if($request->ajax())
        {
            //dd("fetch");
            $data = array(
                'customername'    =>  $request->customername,
                'address'     =>  $request->address,
                'city'    =>  $request->city,
                'postalcode'     =>  $request->postalcode,
                'country'    =>  $request->country,
                'customerid'     => 200
            );
            $id = DB::table('tbl_customers')->insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Data Inserted</div>';
            }
        }
    }

    function update_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name=>$request->column_value
            );
            DB::table('tbl_customers')
                ->where('id', $request->id)
                ->update($data);
            echo '<div class="alert alert-success">Data Updated</div>';
        }
    }

    function delete_data(Request $request)
    {
        if($request->ajax())
        {
            DB::table('tbl_customers')
                ->where('id', $request->id)
                ->delete();
            echo '<div class="alert alert-success">Data Deleted</div>';
        }
    }


    function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('tbl_customers')
                    ->where('customername', 'like', '%'.$query.'%')
                    ->orWhere('address', 'like', '%'.$query.'%')
                    ->orWhere('city', 'like', '%'.$query.'%')
                    ->orWhere('postalcode', 'like', '%'.$query.'%')
                    ->orWhere('country', 'like', '%'.$query.'%')
                    ->orderBy('customerid', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('tbl_customers')
                    ->orderBy('customerid', 'desc')
                    ->get();
            }
            $total_row = $data->count();
//            if($total_row > 0)
//            {
//                foreach($data as $row)
//                {
//                    $output .= '
//                                <tr>
//                                 <td>'.$row->customername.'</td>
//                                 <td>'.$row->address.'</td>
//                                 <td>'.$row->city.'</td>
//                                 <td>'.$row->postalcode.'</td>
//                                 <td>'.$row->country.'</td>
//                                </tr>
//                                ';
//                }
//            }
//            else
//            {
//                $output = '
//       <tr>
//        <td align="center" colspan="5">No Data Found</td>
//       </tr>
//       ';
//            }
//            $data = array(
//                'table_data'  => $output,
//                'total_data'  => $total_row
//            );
            echo json_encode($data);
        }
    }
}
