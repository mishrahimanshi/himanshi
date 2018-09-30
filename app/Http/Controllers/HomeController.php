<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\UserSkills;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){

            $userid = Auth::user()->id;
            // Authentication passed...



            $user_info = DB::select(DB::raw("SELECT `u`.`id`,`us`.`skills_id`,`s`.`skill_name`,`s`.`id` FROM `users` AS u JOIN `userskills` AS us ON `u`.`id` = `us`.`user_id` JOIN `skills` AS s ON (`us`.`skills_id` = `s`.`parent_id` OR `us`.`skills_id` = `s`.`id`) WHERE `u`.`id` =$userid "));

            //  $related_skills = DB::table('skills')->whereIn('parent_id',$user_info)->get();



            $skills= array();
            $i = 0;
            foreach ($user_info as $key){
                $skills[$i] = $key->id;
                $i++;
            }
            //$skills = join("','",$skills);
            /* $jobs = DB::table('jobs_skills')->select('jobs_skills.job_id','jobs_skills.skills_id','jobs.job_title','jobs.id')
                 ->join('jobs', 'jobs_skills.job_id','=','jobs.id')
                     ->whereIn('skills_id',$skills)
                     ->groupBy('jobs.id')
                     ->get();*/

            $jobs = DB::table('jobs_skills')
                ->select(DB::raw('DISTINCT job_id'))
                ->whereIn('skills_id',$skills)
                ->get()->toArray();

            $query = DB::table('jobs')
                ->join('jobs_skills','jobs_skills','=','')

          /*  $jobs_name = DB::table('jobs')
                ->select('job_title')*/


            echo "<pre>";
            print_r($jobs);die;



            $jobs = DB::select(DB::raw("SELECT DISTINCT `jobs_skills`.`job_id`,`jobs`.`id`,`jobs`.`job_title`,`jobs`.`job_description`,`jobs`.`company_name`,`jobs`.`location` FROM `jobs_skills` INNER JOIN `jobs` ON `jobs_skills`.`job_id` = `jobs`.`id` WHERE `jobs_skills`.`skills_id` IN ('".$skills."')"));
            return view('home')->with('job',$jobs);
        }else{
            return back();
        }

    }
}
