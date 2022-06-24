<?php

namespace App\Http\Controllers;

use App\Signature;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Scorecard\Agent as agentScoreCard;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signatures = Signature::query()
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at','DESC')
                ->get();
        return view('signatures.list',compact('signatures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('signatures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'filename' => 'required',
            'signed' => 'required',
        ],
        [
            'filename.required' => 'Filename is required',
            'signed.required' => 'Please DRAW signature on Canvas',
        ]
        );

        $auth_id = Auth::user()->id;

        Storage::disk('public')->makeDirectory($auth_id."/signatures" . "/");

        $folderPath = public_path("storage/".$auth_id."/signatures" . "/");

        $image_parts = explode(";base64,", $request['signed']);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        // $file = $folderPath . uniqid() . '.'.$image_type;

            $file = $folderPath . $request['filename'] . '.'.$image_type;


        $filename_type =  $request['filename'] . '.'.$image_type;
    //    return  $file =  $image_base64->storeAs('/public/hr_forms/',$filename);


        $last = Signature::where('user_id',Auth::user()->id)
        ->orderBy('created_at','DESC')->first();
        if(!$last)
        {
            $request['is_default'] = 1;
        }elseif( $request['is_default'] == 1)
        {
            Signature::where('user_id',Auth::user()->id)->update(['is_default'=>0]);
        }else{
            $request['is_default'] = 0;
        }

        file_put_contents($file, $image_base64);


        $image_resize = Image::make($file);
        $image_resize->resize(180, 80);
        $image_resize->save(public_path("storage/".$auth_id."/signatures" . "/" .$filename_type));

        Signature::create(['user_id' => $auth_id,
        'filename' => $request['filename'],
        'is_default' => $request['is_default'],
        'file' => $filename_type ]);

        //Generate PDF
        // $this->generatePDF($request['filename'],$filename_type);

        return redirect()->back()->with(['with_success'=> "Signature Created Successfully!"]);
    }

    public function uploadSignature()
    {
        return view('signatures.upload');
    }

    public function uploadStoreSignature(Request $request)
    {
        $this->validate($request,
        [
            'attach' => 'required',
         ],
        [
            'attach.required' => 'Signature file is required',
         ]
        );


        $last = Signature::where('user_id',Auth::user()->id)
        ->orderBy('created_at','DESC')->first();
        if(!$last)
        {
            $request['is_default'] = 1;
        }
        elseif( $request['is_default'] == 1)
        {
            Signature::where('user_id',Auth::user()->id)->update(['is_default'=>0]);
        }else
        {
            $request['is_default'] = 0;
        }

        if($request->hasFile('attach')) {

            $attachment   = $request->file('attach');

            // foreach($request->file('attach') as $attachment)
            // {
                $filename =   $attachment->getClientOriginalName();
                $attachment->storeAs("public/" . Auth::user()->id . "/signatures",$filename);



                $image_resize = Image::make($attachment->getRealPath());
                $image_resize->resize(180, 80);
                $image_resize->save(public_path("storage/".Auth::user()->id."/signatures" . "/" .$filename));
            // }

        };

        Signature::create(
            [
                'user_id' => Auth::user()->id,
                'filename' =>   $filename,
                'file' => $filename,
                'is_default' => $request['is_default'],
                'is_uploaded' => 1,
            ]
        );

        return redirect()->back()->with(['with_success'=> "Signature Uploaded Successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_used = agentScoreCard::where('agent_signature_id',$id)
            ->orWhere(function($query) use($id)
            {
                $query->orwhere('tl_signature_id',$id)
                    ->orwhere('manager_signature_id',$id);
            })
            ->first();

        if($is_used)
        {
            return redirect()->back()->withErrors("Signature cannot be deleted due to usage to sign scorecard.");
        }

        $signature = Signature::findorfail($id);
        $signature->delete();

        return redirect()->back()->with('with_success',"Signature deleted successfully!");
    }

    public function setDefaultSignature($id)
    {
        $signature = Signature::where('user_id',Auth::user()->id)
            ->where('id',$id)->first();

        if($signature->is_default)
        {
            return redirect()->back()->withErrors("Signature is already set to default!");
        }

        if($signature)
        {
            Signature::where('user_id',Auth::user()->id)->update(['is_default'=>0]);
            $signature->update(['is_default'=>1]);

            return redirect()->back()->with(['with_success'=> "Signature Set as Default Successfully!"]);
        }
        else
        {
            return redirect()->back()->withErrors('Unauthorized Access');
        }
    }
}
