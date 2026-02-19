<?php

namespace Tests\Feature;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    // TÂCHE : trouvez pourquoi cette relation échoue et corrigez le modèle Eloquent (Model)
    public function test_user_create_task()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/tasks', [
            'name' => 'Some task'
        ]);
        $response->assertStatus(200);
    }

    // TÂCHE : cette table génère une erreur, corrigez-la
    public function test_task_with_no_user()
    {
        Task::create(['name' => 'Some task']);

        $response = $this->get('/tasks');
        $response->assertSeeText('Some task');
        $response->assertStatus(200);
    }

    // TÂCHE : définissez la relation à deux niveaux dans le modèle User (Model)
    public function test_show_users_comments()
    {
        $user = User::factory()->create();
        $task = Task::create([
            'users_id' => $user->id,
            'name' => 'Some task'
        ]);
        Comment::create([
            'task_id' => $task->id,
            'name' => 'Some name',
            'comment' => 'Some comment'
        ]);

        $response = $this->get('/users/' . $user->id);
        $response->assertStatus(200);
    }

    // TÂCHE : corrigez le nom de la table pivot (pivot table) dans la liste
    public function test_show_roles_with_users()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Admin']);
        DB::table('users_roles')->insert([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        $response = $this->get('/roles');
        $response->assertStatus(200);
    }

    // TÂCHE : corrigez la table pivot (pivot table) avec des champs supplémentaires
    public function test_teams_with_users()
    {
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team 1']);
        $createdAt = now()->toDateTimeString();
        $position = 'Manager';
        DB::table('team_user')->insert([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'position' => $position,
            'created_at' => $createdAt
        ]);

        $response = $this->get('/teams');
        $response->assertSee($createdAt);
        $response->assertSee($position);
    }

    // TÂCHE : calculez la moyenne d'un champ via la relation (relationship)
    public function test_countries_with_team_size()
    {
        $country = Country::create(['name' => 'United Kingdom']);
        Team::create([
            'name' => 'Team 1',
            'country_id' => $country->id,
            'size' => 3
        ]);
        Team::create([
            'name' => 'Team 2',
            'country_id' => $country->id,
            'size' => 5
        ]);

        $response = $this->get('/countries');
        $response->assertSee('avg team size 4');
        $response->assertStatus(200);
    }

    // TÂCHE : définissez la relation polymorphique (polymorphic relationship) dans le modèle Attachment
    public function test_attachments_polymorphic()
    {
        $task = Task::create(['name' => 'Some task']);
        $comment = Comment::create([
            'task_id' => $task->id,
            'name' => 'Some name',
            'comment' => 'Some comment'
        ]);
        Attachment::create([
            'filename' => 'something.jpg',
            'attachable_id' => $task->id,
            'attachable_type' => Task::class
        ]);
        Attachment::create([
            'filename' => 'something.pdf',
            'attachable_id' => $comment->id,
            'attachable_type' => Comment::class
        ]);

        $response = $this->get('/attachments');
        $response->assertStatus(200);
        $response->assertSee('something.jpg');
        $response->assertSee('something.pdf');
        $response->assertSee('Task');
        $response->assertSee('Comment');
    }

    // TÂCHE : ajoutez un enregistrement via la relation belongsToMany
    public function test_belongstomany_add()
    {
        $user = User::factory()->create();
        $project = Project::create(['name' => 'Some project']);

        $response = $this->actingAs($user)->post('/projects', [
            'project_id' => $project->id,
            'start_date' => now()->toDateString()
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'start_date' => now()->toDateString()
        ]);
    }

    // TÂCHE : affichez uniquement les utilisateurs ayant au moins un projet
    public function test_filter_users()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project = Project::create(['name' => 'Some project']);
        DB::table('project_user')->insert([
            'project_id' => $project->id,
            'user_id' => $user1->id,
            'start_date' => now()->toDateString()
        ]);

        $response = $this->get('/users');
        $response->assertSee($user1->email);
        $response->assertDontSee($user2->email);
    }
}
