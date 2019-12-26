<?php
namespace App\Imports;
use App\EducationLevel;
use App\ExDepartment;
use App\ExPosition;
use App\PositionManagement;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Session;
use App\Candidate;
use DB;

class ImportCandidateCollection implements ToCollection
{
    public function collection(Collection $rows)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $rows = $rows->slice(1)->take(100);
        foreach ($rows as $row)
        {
            if(!empty($row[0]) && isset($row[0]) && isset($row[3]))
            {
                $name = trim($row[0]);
                $email = trim($row[3]);
                if (User::where('email', '=', $email)->exists()) {
                    //DO NOTHING
                }else{
                if (Candidate::where('email', '=', $email)->exists()) {
                    // user found
                    //no need to update
                }else{
                    $candidate = new Candidate();
                    $user_uuid = (string) Str::uuid();
                        $candidate->reference_no = 'CI'.rand(11111,99999);
                    $candidate->user_uuid = $user_uuid;
                    $candidate->created_by = $user_id;
                    $candidate->email = $email;

                        $phone = trim($row[4]);
                        $gender = trim($row[5]);
                        $age = trim($row[6]);
                        $nationality = trim($row[7]);
                        $position = trim($row[8]);
                        $location = trim($row[9]);
                        $edu_level = trim($row[10]);
                        if(!empty($edu_level))
                    {
                            $edu =EducationLevel::where('title', 'like', '%' .$edu_level. '%')->first();
                            if($edu)
                    {
                                $edu_level = $edu->id;
                    }else{
                                $edu_level = 3;//default one
                    }
                        }


                        //$is_qualified = trim($row[11]);
                        $profile_details = trim($row[11]);

                    $candidate->name = $name;
                        $candidate->last_name =  trim($row[1]);
                        $candidate->badge_id = trim($row[2]);
                    $candidate->age = $age;
                    $candidate->gender = strtolower($gender) == 'female' ? 'Female':'Male';
                    $candidate->phone = $phone;
                    $candidate->nationality = $nationality;
                    $candidate->location = $location;
                        //$candidate->is_qualified = strtolower($is_qualified) == 'no' ? 0 : 1;
                    $candidate->notes = $profile_details;
                    $candidate->education_level = $edu_level;
                        $candidate->level = $row[12] ? $row[12] : 5;
                        $candidate->expected_salary = salaryToId($row[13] ? $row[13] : 5000);
                        $candidate->fixed_salary = $row[13] ? $row[13] : 5000;
                    $candidate->company_id = Auth::user()->company_id;

                        $pos = PositionManagement::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($position). '%')->where('company_id',$company_id)->first();
                    if($pos)
                    {
                        $position_id =  $pos->id;
                    }else{
                        $position_id = 3;//default
                    }

                        //ex department
                        $exdept = trim($row[14]);
                        $ex_dept_id = 0;
                        if(!empty($exdept))
                        {
                            if(ExDepartment::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($exdept). '%')->where('company_id',$company_id)->exists())
                            {
                                $exdept =  $expos = ExDepartment::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($exdept). '%')->where('company_id',$company_id)->first();
                                $ex_dept_id = $exdept->id;
                            }else{
                                $newEx = new ExDepartment();
                                $newEx->title = $exdept;
                                $newEx->created_by = $user_id;
                                $newEx->company_id = $company_id;
                                $newEx->created_at = date('Y-m-d H:i:s');
                                if($newEx->save())
                                {
                                    $ex_dept_id = $newEx->id;
                                }
                            }
                        }
                        //ex position
                        $old_position_id = 0;
                        if(ExPosition::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($position). '%')->where('company_id',$company_id)->exists())
                        {
                            $expos = ExPosition::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($position). '%')->where('company_id',$company_id)->first();
                            $old_position_id = $expos->id;
                        }else{
                            $expos = new ExPosition();
                            $expos->title = $position;
                            $expos->created_by = $user_id;
                            $expos->company_id = $company_id;
                            $expos->dept_id = $ex_dept_id;
                            $expos->created_at = date('Y-m-d H:i:s');
                            if($expos->save())
                            {
                                $old_position_id = $expos->id;
                            }

                        }


                    $candidate->position_id =$position_id;
                        $candidate->old_position_id =$old_position_id;
                        $candidate->ex_dept_id =$ex_dept_id;
                    $candidate->created_at = date('Y-m-d H:i:s');
                    $candidate->updated_at = date('Y-m-d H:i:s');
                   if($candidate->save())
                   {

                           $user = new User();
                           $user->company_id = Auth::user()->company_id;

                       $user->name = $candidate->name;
                       $user->email = $candidate->email;
                       $user->password = Hash::make('123456789');
                       $user->user_type = 2;
                       $user->user_uuid = $user_uuid;
                       if($user->save())
                       {
                           $user->assignRole('Candidate');
                       }
                   }

                }
                }


            }
        }
    }
}
