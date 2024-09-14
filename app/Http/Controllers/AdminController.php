<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    function index(){
    }    
    function about(){
        $name = "mos";
        $date = "7 ตุลาคม 2564";
        return view('about',compact('name','date'));
    }
    function blog(){
        $blogs = DB::table('blogs')->paginate(5);
        return view('blog',compact('blogs'));
    }
    function create(){
        return view('form');
    }
    function insert(Request $request){
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required'
        ],
        [
            'title.required' => 'กรุณากรอกชื่อเรื่อง',
            'title.max' => 'ชื่อเรื่องต้องมีความยาวไม่เกิน 50 ตัวอักษร',
            'content.required' => 'กรุณากรอกรายละเอียด'
        ]);

        $data=[
            'title' => $request->title,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('blogs')->insert($data);
        return redirect()->route('create_post');
    }
    function delete($id){
        DB::table('blogs')->where('id', $id)->delete();
        return redirect()->route('blog')->with('success', 'ลบบทความสำเร็จแล้ว');
    }

    function change($id){
        $blog=DB::table('blogs')->where('id',$id)->first();
        $data=[
            'status' => !$blog->status
        ];
        DB::table('blogs')->where('id',$id)->update($data);
        return redirect()->route('blog');
    }
    function update(Request $request, $id){
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required'
        ], [
            'title.required' => 'กรุณากรอกชื่อเรื่อง',
            'title.max' => 'ชื่อเรื่องต้องมีความยาวไม่เกิน 50 ตัวอักษร',
            'content.required' => 'กรุณากรอกรายละเอียด'
        ]);
    
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'updated_at' => now()
        ];
        DB::table('blogs')->where('id', $id)->update($data);
        return redirect()->route('blog')->with('success', 'อัปเดตบทความสำเร็จแล้ว');
    }
}