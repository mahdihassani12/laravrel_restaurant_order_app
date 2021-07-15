<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use App\InsideOrderTotal;
use App\OutsideModel;
use App\Table;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Menu;

class HomeController extends Controller
{


    /*
    *   Admin Dashboard
    */
    public function index()
    {


        $category = DB::table('categories')
            ->select('*')
            ->get();
        $outTotal = DB::table('outside_order')->sum('order_amount');
        $inTotal = DB::table('inside_order')->sum('order_amount');


        $year = Carbon::now()->year;

        $arr = array();
        $arr2 = array();
        for ($i = 1; $i <= 9; $i++) {

            $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-0" . $i . "%")->sum("payment");
            $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-0" . $i . "%")->sum("payment");

        }
        //it is for student payment
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-10%")->sum("payment");
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-11%")->sum("payment");
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-12%")->sum("payment");

        //it is for student payment
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-10%")->sum("payment");
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-11%")->sum("payment");
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-12%")->sum("payment");

        $arr3 = array_map(function () {
            return array_sum(func_get_args());
        }, $arr, $arr2);
//

        return view('dashboard.welcome', compact('category','outTotal','inTotal','arr3'));
    }

    /*
    *   Kitchen Dashboard
    */
    public function kitchenDashboard()
    {
        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order', 'inside_order.total_id', '=', 'iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name', 'iot.order_id', 'identity', 'iot.status')
            ->orderByDesc('iot.order_id')
            ->groupBy('location.name', 'iot.order_id', 'identity')
            ->where('iot.status', '=', '1')
            ->get();
        $user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get();

        return view('Kitchen.insideOrder.list', compact('orders', 'user'));
    }

    /*
    *   Accountant Dashboard
    */
    public function accountantDashboard()
    {
        $orders = InsideOrderTotal::where('payment', '=', 0)->where('status', '2')->paginate(10);
        return view('Payment.insidePayment.index', compact('orders'));
    }
    /*
    *   Order Dashboard
    */
    public function orderDashboard()
    {
        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.*')
            ->where('menu.category_id', '=', 1)
            ->get();
        $categories = DB::table('categories')
            ->select('*')
            ->get();
        $tables = Table::all();
        return view('order.insideOrder.newCreate', compact('menu', 'tables', 'categories'));

    }



    public function our_backup_database(){

        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $queryTables = \DB::select(\DB::raw('SHOW TABLES'));
        foreach ( $queryTables as $table )
        {
            foreach ( $table as $tName)
            {
                $tables[]= $tName ;
            }
        }

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach($tables as $table)
        {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach($show_table_result as $show_table_row)
            {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for($count=0; $count<$total_row; $count++)
            {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= '"' . implode('","', $table_value_array) . '"'.");\n";
            }
        }
        $file_name = 'database_backup_on_' . date('Y-m-d')  . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);


    }

}
