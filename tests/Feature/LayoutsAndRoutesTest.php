<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LayoutsAndRoutesTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_and_guest_pages_render_cleanly(): void
    {
        // Homepage welcome
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('QuizVerse');
        $response->assertSee('Explore Quizzes');

        // Auth
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Authentication');

        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Join the Arena');
    }

    public function test_frontend_quiz_play_routes(): void
    {
        $response = $this->get('/quiz');
        $response->assertStatus(200);
        $response->assertSee('Frontend Quiz Arena');

        $quiz = Quiz::first();
        $this->assertNotNull($quiz);

        $response = $this->get("/quiz/{$quiz->id}");
        $response->assertStatus(200);
        $response->assertSee($quiz->title);
    }

    public function test_player_pages_render_cleanly(): void
    {
        $player = User::where('role', 'player')->first();
        $this->assertNotNull($player);

        $response = $this->actingAs($player)->get('/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($player)->get('/explore');
        $response->assertStatus(200);

        $response = $this->actingAs($player)->get('/leaderboard');
        $response->assertStatus(200);

        $response = $this->actingAs($player)->get('/profile');
        $response->assertStatus(200);

        $quiz = Quiz::first();
        if ($quiz) {
            $response = $this->actingAs($player)->get("/play/{$quiz->id}");
            $response->assertStatus(200);
        }
    }

    public function test_profile_image_upload_to_storage(): void
    {
        Storage::fake('public');
        $player = User::where('role', 'player')->first();

        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($player)->post('/profile', [
            'name' => 'Updated Player Name',
            'bio' => 'New bio description',
            'image' => $file,
        ]);

        $response->assertRedirect('/profile');
        $player->refresh();
        $this->assertEquals('Updated Player Name', $player->name);
        $this->assertStringContainsString('uploads/', $player->avatar);
        Storage::disk('public')->assertExists($player->avatar);
    }

    public function test_creator_pages_render_cleanly(): void
    {
        $creator = User::where('role', 'creator')->first();
        $this->assertNotNull($creator);

        $response = $this->actingAs($creator)->get('/creator/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($creator)->get('/creator/quizzes');
        $response->assertStatus(200);

        $response = $this->actingAs($creator)->get('/creator/quizzes/create');
        $response->assertStatus(200);

        $response = $this->actingAs($creator)->get('/creator/questions');
        $response->assertStatus(200);

        $response = $this->actingAs($creator)->get('/creator/questions/create');
        $response->assertStatus(200);
    }

    public function test_admin_pages_and_crud(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/overview');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/rbac');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/settings');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/audit');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/analytics');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/campaigns');
        $response->assertStatus(200);

        // Category Management
        $response = $this->actingAs($admin)->get('/admin/categories');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Deep Learning Neural Nets',
            'description' => 'Transformers, CNNs and backprop mechanics.',
            'icon' => 'fa-solid fa-network-wired',
        ]);
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Deep Learning Neural Nets']);

        // Quiz Management
        $response = $this->actingAs($admin)->get('/admin/quizzes');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/quizzes/create');
        $response->assertStatus(200);

        $cat = Category::first();
        $response = $this->actingAs($admin)->post('/admin/quizzes', [
            'title' => 'Quantum Computing 101',
            'category_id' => $cat->id,
            'difficulty' => 'hard',
            'question' => 'What is the quantum equivalent of a classical bit?',
            'options' => ['Qubit', 'Byte', 'Trit', 'Logic Gate'],
            'correct_answer' => 'Qubit',
            'description' => 'Superposition and entanglement principles.',
        ]);
        $response->assertRedirect('/admin/quizzes');
        $this->assertDatabaseHas('quizzes', ['title' => 'Quantum Computing 101']);
    }
}
