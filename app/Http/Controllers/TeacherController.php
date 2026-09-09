<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // 2. new Teacher() + save()
    public function createWithSave()
    {
        $teacher = new Teacher();

        $teacher->name = 'Sok Dara';
        $teacher->email = 'sok.dara@example.com';
        $teacher->phone = '012345678';
        $teacher->address = 'Phnom Penh';
        $teacher->dob = '1995-05-10';
        $teacher->gender = 'Male';
        $teacher->subject = 'Mathematics';

        $teacher->save();

        return $teacher;
    }


    // 3. Teacher::create()
    public function createWithCreate()
    {
        $teacher = Teacher::create([
            'name' => 'Srey Leak',
            'email' => 'srey.leak@example.com',
            'phone' => '098765432',
            'address' => 'Siem Reap',
            'dob' => '1997-08-15',
            'gender' => 'Female',
            'subject' => 'English',
        ]);

        return $teacher;
    }


    // 4. firstOrCreate()
    public function firstOrCreate()
    {
        $teacher = Teacher::firstOrCreate(
            [
                'email' => 'teacher@example.com'
            ],
            [
                'name' => 'First Teacher',
                'phone' => '011223344',
                'address' => 'Phnom Penh',
                'dob' => '1996-01-20',
                'gender' => 'Male',
                'subject' => 'Computer Science',
            ]
        );

        return $teacher;
    }


    // 5. find() + save()
    public function updatePhone($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher not found'
            ], 404);
        }

        $teacher->phone = '099999999';
        $teacher->save();

        return $teacher;
    }


    // 6. update()
    public function updateAddress()
    {
        Teacher::where('id', 1)
            ->update([
                'address' => 'Kandal'
            ]);

        
    }


    // 7. Mathematics -> Physics
    public function changeMathematicsToPhysics()
    {
        $count = Teacher::where(
            'subject',
            'Mathematics'
        )->update([
            'subject' => 'Physics'
        ]);

       
    }


    // 8. updateOrCreate()
    public function updateOrCreateTeacher()
    {
        $teacher = Teacher::updateOrCreate(
            [
                'email' => 'update@example.com'
            ],
            [
                'name' => 'Updated Teacher',
                'phone' => '010101010',
                'address' => 'Phnom Penh',
                'dob' => '1998-03-12',
                'gender' => 'Female',
                'subject' => 'Physics',
            ]
        );

        return $teacher;
    }


   
    public function all()
    {
        return Teacher::all();
    }


   
    public function findTeacher($id)
    {
        return Teacher::find($id);
    }


    
    public function findTeacherOrFail($id)
    {
        return Teacher::findOrFail($id);
    }


   
    public function mathematics()
    {
        return Teacher::where(
            'subject',
            'Mathematics'
        )->get();
    }


    
    public function orderByName()
    {
        return Teacher::orderBy(
            'name',
            'asc'
        )->get();
    }


    
    public function selectedMathematicsTeachers()
    {
        return Teacher::where(
            'subject',
            'Mathematics'
        )
        ->where(
            'gender',
            'Female'
        )
        ->get();
    }


    public function countTeachers()
    {
        return response()->json([
            'total_teachers' => Teacher::count()
        ]);
    }


   
    public function paginateTeachers()
    {
        return Teacher::orderBy('name')
            ->paginate(10);
    }


    
    public function searchName(Request $request)
    {
        $keyword = $request->input(
            'keyword',
            'សុភា'
        );

        return Teacher::where(
            'name',
            'like',
            '%' . $keyword . '%'
        )->get();
    }


    // 17. find() + delete()
    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);

    

        $teacher->delete();

        
    }


    public function destroyTeachers()
    {
        $deleted = Teacher::destroy([
            1,
            2,
            3
        ]);

        
    }


    
    public function deleteMathematicsTeachers()
    {
        $deleted = Teacher::where(
            'subject',
            'Mathematics'
        )->delete();

        
    }


    
    public function softDeleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacher->delete();

        
    }
}