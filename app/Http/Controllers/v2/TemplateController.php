<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;
use App\v2\TemplateRemarks;

use App\v2\Scorecard;
use App\v2\ScorecardColumn;
use App\v2\ScorecardContent;


class TemplateController extends Controller
{


    public function create(Request $request)
    {

        $templates = Template::where('is_active',1)->get();

        return view('templates.create',compact('templates'));
    }

    public function store(Request $request)
    {

        $this->validate($request,
        [
            'name'       => 'required',
          
        ],
            $messages = array('name.required' => 'Template Name is Required!')
        );
       

        $template = Template::create(['name'=> $request->name,
        'default_target_score'=> $request->default_target_score]);
        return redirect()->route('template.column.create', [$template->id]);
        // return redirect()->back()->with('with_success', 'Template created succesfully!'); 
    }

    public function update(Request $request,$templateId)
    {
        $template = Template::findorfail($templateId);

        $template->update(['name'=> $request->name,
        'default_target_score'=> $request->default_target_score]);

        return redirect()->back()->with('with_success', 'Template updated succesfully!'); 
    }

    public function destroy($templateId)
    {
        $template = Template::findorfail($templateId);

        $template->update(['is_active'=>0]);

        return redirect()->back()->with('with_success', 'Template deleted succesfully!'); 
    }


     /**
     * 
     * 
     *  COLUMN
     * 
     */

    public function createColumn(Request $request,$templateId)
    {
        $template = Template::findorfail($templateId);
        
        $columns =  TemplateColumn::where('template_id',$templateId)->get();

        return view('templates.column.create',compact('template','columns'));
    }

    public function storecolumn(Request $request,$templateId)
    {
      
        $has_existing_val = TemplateColumn::where('template_id',$templateId)->orderBy('id','desc')->first();
        
        if($has_existing_val)
        {
            $template = TemplateColumn::create(['template_id'=> $templateId,
            'column_name'=> $request['column_name'],
            'column_position'=> $has_existing_val->column_position + 1]);

        }else{
            $data = $request->all();

            $colums = $data['columns'];

            //insert using foreach loop
            foreach($colums as $key => $input) {
                $template = TemplateColumn::create(['template_id'=> $templateId,
                'column_name'=> $colums[$key],
                'column_position'=> $key]);
            }

        }//if has existing val
        
      
        // return redirect()->route('template.content.create', [$templateId]);

        return redirect()->back()->with('with_success', 'Added succesfully!'); 
    }

    public function updateColumn(Request $request,$columnId)
    {
        $this->validate($request,
        [
            'column_name'       => 'required',
        ]);
      
                
        $column = TemplateColumn::findorfail($columnId);

        $column->update(['column_name'=>$request['column_name']]);

        return redirect()->back()->with('with_success', 'Column name updated succesfully!'); 
    }

    public function destroyColumn(Request $request,$templateId,$columnPosition,$columnId)
    {
        $templateContent = TemplateContent::where('template_id',$templateId)
        ->where('column_position',$columnPosition)->delete();

        $column = TemplateColumn::findorfail($columnId);
        $column->delete();

        // $templateContent = TemplateContent::where('template_id',$templateId)
        // // ->where('column_position',$columnPosition)
        // ->distinct()
        // ->get();

       $templateContent_indexed =  \DB::table('template_col_content')
       ->where('template_id',$templateId)->distinct()->get(['row_position']);
        //  dd($templateContent);

    //    return  array_splice($templateContent->toArray(), 0, 0);

        // $reindexed_array = array_values($templateContent->toArray());
        //  dd($reindexed_array);

        // dd($reindexed_array[0]['row_position']);

            foreach($templateContent_indexed as $key => $input) {
                $aaa =  \DB::table('template_col_content')
                ->where('template_id',$templateId)
                ->where('row_position',$input->row_position)->get();
                //  dd($bbb);
                foreach($aaa as $keys => $value){
                    // foreach($content->column_position as $cp){
                $kk = TemplateContent::findorfail($value->id);
                    // ->where('row_position',$input->row_position)
                   $kk->update(['column_position'=> $keys]);
                    // echo $value->id . "<br>";
                // }
                }
               

                // echo $input->row_position;
        
            }

            $templateColumn_indexed =  \DB::table('template_column')
            ->where('template_id',$templateId)->get();

            foreach($templateColumn_indexed as $key => $input) {
                     $bbb =  \DB::table('template_column')
                     ->where('template_id',$templateId)->get();
                     //  dd($bbb);
                     foreach($bbb as $keys => $value){
                         // foreach($content->column_position as $cp){
                     $ss = TemplateColumn::findorfail($value->id);
                         // ->where('row_position',$input->row_position)
                        $ss->update(['column_position'=> $keys]);
                         // echo $value->id . "<br>";
                     // }
                     }
                    
     
                     // echo $input->row_position;
             
                 }

    return redirect()->back()->with('with_success', 'Column deleted succesfully!'); 
    }


    public function columnFillable(Request $request,$columnId)
    {
        $column = TemplateColumn::findorfail($columnId);
        $column->update(['is_fillable' => $request['is_fillable'] ]);

        $scorecardColumn = ScorecardColumn::where('parent_template_column_id',$columnId);

        if($scorecardColumn )
        {
            $scorecardColumn->update(['is_fillable' => $request['is_fillable'] ]);
        }
   

        
        return redirect()->back()->with('with_success', 'Set succesfully!'); 
    }

    public function columnFinalScore(Request $request,$columnId)
    {
        $column = TemplateColumn::findorfail($columnId);
        $column->update(['is_final_score' => $request['is_final_score'] ]);

        $scorecardColumn = ScorecardColumn::where('parent_template_column_id',$columnId);

        if($scorecardColumn )
        {
            $scorecardColumn->update(['is_final_score' => $request['is_final_score'] ]);
        }
   

        
        return redirect()->back()->with('with_success', 'Set succesfully!'); 
    }

    

    /**
     * 
     * 
     *  CONTENT
     * 
     */

    public function createContent(Request $request,$templateId)
    {
        $template = Template::findorfail($templateId);
        $templatecolumn = TemplateColumn::where('template_id',$templateId)->get();
        $templatecontent_lastrow = TemplateContent::where('template_id',$templateId)->orderBy('row_position','desc')->first();
        $templatecontent = TemplateContent::where('template_id',$templateId)->get();

        return view('templates.content.create',compact('template','templatecolumn','templatecontent_lastrow','templatecontent'));
    }

    public function storecreateContent(Request $request,$templateId)
    {
        $data = $request->all();
        
        $content = $data['content'];
        $row_position = $data['row_position'];
        $column_position = $data['column_position'];

        //insert using foreach loop
        foreach($content as $key => $input) {
            $template = TemplateContent::create(['template_id'=> $templateId,
            // 'content'=> (empty($content[$key]))? " " : $content[$key],
            'content'=> $content[$key],
            'row_position'=> $row_position,
            'column_position'=> $column_position[$key]
            ]);
        }
      
        return redirect()->route('template.content.create', [$templateId]);
    }


    public function updateContent(Request $request,$templateId,$rowPosition,$columnPosition)
    {
        $this->validate($request,
        [
            'content'       => 'required',
        ]);
      
                
        $content = TemplateContent::where('template_id',$templateId)
        ->where('row_position',$rowPosition)
        ->where('column_position',$columnPosition)
        ->first();

        $content->update(['content'=>$request['content']]);

        return redirect()->back()->with('with_success', 'Content updated succesfully!'); 
    }



    public function destroyContent($templateContentId)
    {
        // return $templateContentId;
        $templateContent = TemplateContent::findorfail($templateContentId);
        $templateContent->update(['content'=> NULL]);

        return redirect()->back()->with('with_success', 'Content delete succesfully!'); 
    }

    public function destroyContentRow($templateId,$rowPosition)
    {
        $templateContent = TemplateContent::where('template_id',$templateId)
        ->where('row_position',$rowPosition)->delete();

        $templateContent_indexed =  \DB::table('template_col_content')
        ->where('template_id',$templateId)->distinct()->get(['row_position']);
        
        //Reindex row numbering in DB: template_col_content
        foreach($templateContent_indexed as $key => $input) {
                     \DB::table('template_col_content')
                     ->where('template_id',$templateId)
                     ->where('row_position',$input->row_position)
                     ->update(['row_position'=>$key]);
              
                 }


        // $templateContent_indexed2 =  \DB::table('template_col_content')
        //          ->where('template_id',$templateId)->distinct()->get(['row_position']);

        // //Reindex column after row reindex

        // foreach($templateContent_indexed2 as $key => $input) {
        //     $aaa =  \DB::table('template_col_content')
        //     ->where('row_position',$input->row_position)->get();
        //     //  dd($bbb);
        //     foreach($aaa as $keys => $value){
        //         // foreach($content->column_position as $cp){
        //     $kk = TemplateContent::findorfail($value->id);
        //         // ->where('row_position',$input->row_position)
        //        $kk->update(['column_position'=> $keys]);
        //         // echo $value->id . "<br>";
        //     // }
        //     }
        // }


        return redirect()->back()->with('with_success', 'Row deleted succesfully!'); 
    }
    /**
     * 
     * 
     *  USER REMARKS
     * 
     */
    public function createRemarks(Request $request,$templateId)
    {
        $template = Template::findorfail($templateId);

        $templateRemarks = TemplateRemarks::where('template_id',$templateId)->get();
        
        return view('templates.remarks.create',compact('template','templateRemarks'));
    }


    public function storeRemarks(Request $request,$templateId)
    {
        $this->validate($request,
        [
            'name'       => 'required',
        ]);

        $template = TemplateRemarks::create(['template_id'=> $templateId,
        'name'=> $request['name']]);

        
      
        return redirect()->back()->with('with_success', 'Added succesfully!'); 
    }

    public function updateRemarks(Request $request,$remarksId)
    {

        $this->validate($request,
        [
            'name'       => 'required',
        ]);
                
        $remarks = TemplateRemarks::findorfail($remarksId);

        $remarks->update(['name'=>$request['name']]);

        return redirect()->back()->with('with_success', 'Remarks updated succesfully!'); 
    }


    public function destroyRemarks($remarksId)
    {
        $remarks = TemplateRemarks::findorfail($remarksId);
        $remarks->delete();

        return redirect()->back()->with('with_success', 'Remarks deleted succesfully!'); 
   

    }
    

    /**
     * 
     * 
     *  Preview
     * 
     */
    public function preview(Request $request,$templateId,$from)
    {
        $template = Template::findorfail($templateId);
        
        //Check if Score is Deleted
         if($template->is_deleted == 1)
         {
             return \Redirect::back()->withErrors(['Error on Scorecard print']);
         }

        $role = []; //Role::findorfail($roleId);

        $template_column =   TemplateColumn::where('template_id',$template->id)->get();

        $templatecontent_lastrow = TemplateContent::where('template_id',$template->id)->orderBy('row_position','desc')->first();
        $templatecontent = TemplateContent::where('template_id',$template->id)->get();
       
        $towerhead =[];// Setting::where('setting','towerhead')->first();

        $template_remarks =   TemplateRemarks::where('template_id',$template->id)->get();
    
        $from = $from;
        return view('templates.preview',compact('role','template_column','templatecontent_lastrow','templatecontent','template','template_remarks','towerhead','from'));
   
    }

    
}
