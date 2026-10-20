<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Institutes' => [
                'view_institutes' => 'View institutes',
                'create_institutes' => 'Create institutes',
                'edit_institutes' => 'Edit institutes',
                'delete_institutes' => 'Delete institutes',
                'manage_institute_status' => 'Activate or deactivate institutes',
            ],
            'Users' => [
                'view_users' => 'View users',
                'create_users' => 'Create users',
                'edit_users' => 'Edit users',
                'delete_users' => 'Delete users',
                'manage_user_status' => 'Activate or deactivate users',
            ],
            'Classes' => [
                'view_classes' => 'View classes',
                'create_classes' => 'Create classes',
                'edit_classes' => 'Edit classes',
                'delete_classes' => 'Delete classes',
            ],
            'Subjects' => [
                'view_subjects' => 'View subjects',
                'create_subjects' => 'Create subjects',
                'edit_subjects' => 'Edit subjects',
                'delete_subjects' => 'Delete subjects',
            ],
            'Teachers' => [
                'view_teachers' => 'View teachers',
                'create_teachers' => 'Create teachers',
                'edit_teachers' => 'Edit teachers',
                'delete_teachers' => 'Delete teachers',
                'assign_teacher_classes' => 'Assign classes to teachers',
                'assign_teacher_subjects' => 'Assign subjects to teachers',
            ],
            'Students' => [
                'view_students' => 'View students',
                'create_students' => 'Create students',
                'edit_students' => 'Edit students',
                'delete_students' => 'Delete students',
                'assign_student_classes' => 'Assign students to classes',
            ],
            'Quizzes' => [
                'view_quizzes' => 'View quizzes',
                'create_quizzes' => 'Create quizzes',
                'edit_quizzes' => 'Edit quizzes',
                'delete_quizzes' => 'Delete quizzes',
                'publish_quizzes' => 'Publish quizzes',
                'unpublish_quizzes' => 'Unpublish quizzes',
            ],
            'Questions' => [
                'view_questions' => 'View questions',
                'create_questions' => 'Create questions',
                'edit_questions' => 'Edit questions',
                'delete_questions' => 'Delete questions',
            ],
            'Options' => [
                'view_options' => 'View answer options',
                'create_options' => 'Create answer options',
                'edit_options' => 'Edit answer options',
                'delete_options' => 'Delete answer options',
            ],
            'Quiz Attempts' => [
                'view_attempts' => 'View quiz attempts',
                'take_quizzes' => 'Attempt quizzes',
                'submit_quizzes' => 'Submit quiz attempts',
            ],
            'Results' => [
                'view_results' => 'View results',
                'view_own_results' => 'View own results',
                'view_reports' => 'View reports',
            ],
            'System Settings' => [
                'manage_permissions' => 'Assign permissions to roles',
            ],
        ];
        foreach ($permissions as $module => $actions) {
            foreach ($actions as $name => $description) {
                Permission::updateOrCreate(
                ['name'=>$name],
                ['module'=>$module,
                'description'=>$description
                ]
                );
                # code...
            }
            # code...
        }
    }
}
