<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;
use Redirect,Response;
class StudentController extends Controller
{

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/

	public function index()
	{
		$students = Student::latest()->paginate(4);
		return view('students.index',compact('students'))->with('i', (request()->input('page', 1) - 1) * 4);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/

	public function create()
	{
		return view('students.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param \Illuminate\Http\Request $request
	* @return \Illuminate\Http\Response
	*/

	public function store(Request $request)
	{

		$r=$request->validate([
		'name' => 'required',
		'email' => 'required',
		'address' => 'required',
		]);

		$custId = $request->cust_id;
		Student::updateOrCreate(['id' => $custId],['name' => $request->name, 'email' => $request->email,'address'=>$request->address]);
		if(empty($request->cust_id))
			$msg = 'Student entry created successfully.';
		else
			$msg = 'Student data is updated successfully';
		return redirect()->route('students.index')->with('success',$msg);
	}

	/**
	* Display the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function show(Student $student)
	{
		return view('students.show',compact('student'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	
	public function edit($id)
	{
		$where = array('id' => $id);
		$student = Student::where($where)->first();
		return Response::json($student);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param \Illuminate\Http\Request $request
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function update(Request $request)
	{

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/

	public function destroy($id)
	{
		$cust = Student::where('id',$id)->delete();
		return Response::json($cust);
	}
}