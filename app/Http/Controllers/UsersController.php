<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
    /*
    *  returning the register view for registering users
    */ 

    public function register()
    {
        return view('auth.register');
    }

    /*
    * storing the users into database
    */ 

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'pass' => 'required|min:5|max:20',
        ],[
			'name.required' => 'فیلد نام الزامی است.',
			'email.required'=> 'فیلد ایمیل الزامی است.',
			'role.required' => 'انتخاب نقش کاربری الزامی است.',
			'pass.required' => 'فیلد پسورد الزامی است.',
			'pass.min' 		=> 'حداقل تعداد پسورد پنچ حرف است.',
			'pass.max' 		=> 'حداکثر تعداد پسورد بیست حرف است.',
		]);
		
        $user = new User();
		$data = $request->all();
        $user -> user_name = $data['name'];
        $user -> email     = $data['email'];
        $user -> role      = $data['role'];
        $user -> password  = bcrypt($data['pass']);
        $user -> save();

       return redirect('/');
       
    }

    /*
    *  returning the login view for authentication of users
    */
    public function login()
    {
        return view('auth.login');
    }

    /*
    *  Authentication for user login
    */
    public function authenticateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'your_pass' => 'required'
        ],[
			'email.required' 	 => 'ایمیل الزامی است.',
			'your_pass.required' => 'پسورد الزامی است.'
		]);
		
		$data = $request->all();
		$user = new User();
		
		$email    = $data['email'];
        $password = $data['your_pass'];


        if (Auth::attempt(['email' => $email, 'password' => $password,'role'=>'admin'],true))
        {
            return redirect()->route('adminDashboard');

        }
            elseif (Auth::attempt(['email' => $email, 'password' => $password,'role'=>'kitchen'],true))
        {
            return redirect()->route('kitchenDashboard');

        }
            elseif (Auth::attempt(['email' => $email, 'password' => $password,'role'=>'accountant'],true))
        {
            return redirect()->route('accountantDashboard');

        }
            elseif (Auth::attempt(['email' => $email, 'password' => $password,'role'=>'order'],true))
        {
            return redirect()->route('orderDashboard');

        }
            else
        {
            return redirect('/')->with(['message'=>' لطفا اول سرور را روشن نموده سپس ایمیل و پسورد درست خود را وارد نمائید! ']);
        } 
		
    }

    // Logout the user
    public function logout(Request $request) {
      Auth::logout();
      return redirect('/');
    }

    /*
    *  The resource functions of users controller for crud
    */ 

    // showing the list of users
    public function index()
    {
		$users = User::orderby('user_id','desc')->get();
		return view('dashboard.users.index',compact('users'));
    }

    // returning the view for creating user
    public function create()
    {
		return view('dashboard.users.create');
    }

    // saving the users into database
    public function store(Request $request)
    {
		$request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'pass' => 'required|min:5|max:20',
        ],[
			'name.required' => 'فیلد نام الزامی است.',
			'email.required'=> 'فیلد ایمیل الزامی است.',
			'role.required' => 'انتخاب نقش کاربری الزامی است.',
			'pass.required' => 'فیلد پسورد الزامی است.',
			'pass.min' 		=> 'حداقل تعداد پسورد پنچ حرف است.',
			'pass.max' 		=> 'حداکثر تعداد پسورد بیست حرف است.',
		]);
		
        $user = new User();
		$data = $request->all();
        $user -> user_name = $data['name'];
        $user -> email     = $data['email'];
        $user -> role      = $data['role'];
        $user -> password  = bcrypt($data['pass']);
        $user -> save();

       return redirect()->route('users.index')->with('success','عملیات موفقانه انجام شد.');
    }

    // returing the edit view 
    public function edit($id)
    {
		$user = User::find($id);
		return view('dashboard.users.update',compact('user'));
    }

    //saving the new changes of user into database
    public function update(Request $request, $id)
    {
		$request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'pass' => 'required|min:5|max:20',
            'new_pass' => 'required|min:5|max:20',
        ],[
			'name.required' => 'فیلد نام الزامی است.',
			'email.required'=> 'فیلد ایمیل الزامی است.',
			'role.required' => 'انتخاب نقش کاربری الزامی است.',
			'pass.required' => 'فیلد پسورد الزامی است.',
			'pass.min' 		=> 'حداقل تعداد پسورد پنچ حرف است.',
			'pass.max' 		=> 'حداکثر تعداد پسورد بیست حرف است.',
			'new_pass.required' => 'فیلد پسورد جدید الزامی است.',
			'new_pass.min' 		=> 'حداقل تعداد پسورد پنچ حرف است.',
			'new_pass.max' 		=> 'حداکثر تعداد پسورد بیست حرف است.',
		]);
		
        $user = User::find($id);
		$data = $request->all();
        $user -> user_name = $data['name'];
        $user -> email     = $data['email'];
        $user -> role      = $data['role'];
        $user -> password  = bcrypt($data['pass']);
		if(!empty($data['pass']) && !empty($data['new_pass'])){ 
			if( Hash::check($data['pass'], $user->password) ){
				$user -> password = bcrypt($data['new_pass']);
			}else{
				return redirect()->back()->with('error','پسورد تایید نشده است. ');
			}
		}
        $user -> save();

       return redirect()->route('users.index')->with('success','عملیات موفقانه انجام شد.');
    }

    // delete user from datase
    public function destroy($id)
    {
		$user = User::find($id);
		$user->delete();
		return redirect()->route('users.index')->with('success','عملیات موفقانه انجام شد.');
    }

}
