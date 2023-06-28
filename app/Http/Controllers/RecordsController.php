<?php
  
namespace App\Http\Controllers;
  
use App\Models\Records;
use Illuminate\Http\Request;
  
class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Records::latest()->paginate(5);
    
        return view('records.index',compact('records'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('records.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        Records::create($input);
     
        return redirect()->route('records.index')
                        ->with('success','Records created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Records  $Records
     * @return \Illuminate\Http\Response
     */
    public function show($records)
    {
        $records=Records::find($records);

        return view('records.show',compact('records'));

    }
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Records  $Records
     * @return \Illuminate\Http\Response
     */
    public function edit($records)
    {
        $records=Records::find($records);
        return view('records.edit',compact('records'));

        dd($records);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Records  $Records
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$records)
    {
        
            $request->validate([
            'name' => 'required',
            'email' => 'required'
            // 'image' => 'required'
             
        ]);
  
        $input = $request->all();


        $records=Records::find($records);
        
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
          
        $records->update($input);
    
        return redirect()->route('records.index')
                        ->with('success','Records updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Records  $Records
     * @return \Illuminate\Http\Response
     */
    public function destroy( $records)
    {

         $records=Records::find($records);
       

        $records->delete();
     
        return redirect()->route('records.index')
                        ->with('success','Records deleted successfully');
    }
}