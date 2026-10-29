<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\PlatformSetting;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Role;
use App\Models\StaffMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $adminRole = Role::create([
            'name' => 'Super Administrator',
            'slug' => 'super-admin',
            'description' => 'Full unconstrained platform control and governance privileges.',
            'permissions' => ['all', 'manage_users', 'manage_quizzes', 'manage_settings', 'view_analytics', 'view_audit_logs', 'manage_campaigns'],
        ]);

        $contentRole = Role::create([
            'name' => 'Content Director',
            'slug' => 'content-director',
            'description' => 'Curates categories, inspects questions, and approves sponsored quizzes.',
            'permissions' => ['manage_quizzes', 'manage_categories', 'view_analytics'],
        ]);

        $safetyRole = Role::create([
            'name' => 'Trust & Safety Lead',
            'slug' => 'safety-lead',
            'description' => 'Moderates user directory, investigates flagged content, and handles account sanctions.',
            'permissions' => ['manage_users', 'view_audit_logs'],
        ]);

        // 2. Demo Users
        $admin = User::create([
            'name' => 'Alexandre Vance',
            'email' => 'admin@quizverse.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'xp' => 14850,
            'level' => 12,
            'streak' => 14,
            'coins' => 2800,
            'avatar' => null,
            'bio' => 'Lead Systems Architect & Founder at QuizVerse. Building next-gen competitive knowledge engines.',
            'is_banned' => false,
            'last_active_at' => now(),
        ]);

        StaffMember::create([
            'user_id' => $admin->id,
            'role_id' => $adminRole->id,
            'department' => 'Executive Engineering',
            'is_active' => true,
        ]);

        $creator = User::create([
            'name' => 'Dr. Elena Rostova',
            'email' => 'creator@quizverse.com',
            'password' => Hash::make('password'),
            'role' => 'creator',
            'xp' => 9820,
            'level' => 10,
            'streak' => 9,
            'coins' => 1950,
            'avatar' => null,
            'bio' => 'Astrophysicist & educator. Author of Science & Cosmos deep-dive challenges.',
            'is_banned' => false,
            'last_active_at' => now()->subMinutes(12),
        ]);

        $player = User::create([
            'name' => 'Marcus Chen',
            'email' => 'player@quizverse.com',
            'password' => Hash::make('password'),
            'role' => 'player',
            'xp' => 4750,
            'level' => 7,
            'streak' => 6,
            'coins' => 840,
            'avatar' => null,
            'bio' => 'Full-stack explorer and daily challenge competitor. Aiming for Top 10 Global Leaderboard.',
            'is_banned' => false,
            'last_active_at' => now()->subMinutes(5),
        ]);

        // 15 Other competitive players
        $playersData = [
            ['name' => 'Sophia Lin', 'email' => 'sophia.lin@dev.net', 'xp' => 23400, 'level' => 16, 'streak' => 28, 'coins' => 5400],
            ['name' => 'David Kim', 'email' => 'david.kim@quantum.org', 'xp' => 21850, 'level' => 15, 'streak' => 21, 'coins' => 4950],
            ['name' => 'Aria Thorne', 'email' => 'aria.t@cyber.io', 'xp' => 19200, 'level' => 14, 'streak' => 18, 'coins' => 4100],
            ['name' => 'Kaelen Voss', 'email' => 'voss@neural.net', 'xp' => 17650, 'level' => 13, 'streak' => 15, 'coins' => 3800],
            ['name' => 'Zoe Gallagher', 'email' => 'zoe.g@vector.dev', 'xp' => 15400, 'level' => 12, 'streak' => 11, 'coins' => 3200],
            ['name' => 'Liam O\'Connor', 'email' => 'liam.oc@matrix.io', 'xp' => 13900, 'level' => 11, 'streak' => 14, 'coins' => 2900],
            ['name' => 'Maya Patel', 'email' => 'maya.patel@horizon.edu', 'xp' => 12100, 'level' => 11, 'streak' => 8, 'coins' => 2600],
            ['name' => 'Nikolai Volkov', 'email' => 'n.volkov@kernel.org', 'xp' => 10800, 'level' => 10, 'streak' => 12, 'coins' => 2300],
            ['name' => 'Chloe Bennett', 'email' => 'chloe.b@frontend.co', 'xp' => 8950, 'level' => 9, 'streak' => 5, 'coins' => 1800],
            ['name' => 'Tariq Al-Mansoor', 'email' => 'tariq@cloudpulse.io', 'xp' => 7800, 'level' => 8, 'streak' => 7, 'coins' => 1600],
            ['name' => 'Isabella Santos', 'email' => 'isa.santos@syntax.br', 'xp' => 6400, 'level' => 8, 'streak' => 4, 'coins' => 1300],
            ['name' => 'Felix Becker', 'email' => 'felix@berlin-tech.de', 'xp' => 5200, 'level' => 7, 'streak' => 3, 'coins' => 1100],
            ['name' => 'Nia Adebayo', 'email' => 'nia.a@lagos-dev.ng', 'xp' => 3900, 'level' => 6, 'streak' => 5, 'coins' => 850],
            ['name' => 'Vikram Seth', 'email' => 'vikram@algo-nexus.in', 'xp' => 2600, 'level' => 5, 'streak' => 2, 'coins' => 600],
            ['name' => 'Emma Watson-Lee', 'email' => 'emma.wl@oxford-ai.uk', 'xp' => 1400, 'level' => 3, 'streak' => 1, 'coins' => 350],
        ];

        $playerModels = [$player];
        foreach ($playersData as $data) {
            $playerModels[] = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'player',
                'xp' => $data['xp'],
                'level' => $data['level'],
                'streak' => $data['streak'],
                'coins' => $data['coins'],
                'bio' => 'Competitive QuizVerse challenger.',
                'is_banned' => false,
                'last_active_at' => now()->subHours(rand(1, 48)),
            ]);
        }

        // 3. Categories with colored devicons and FontAwesome
        $categories = [
            [
                'name' => 'Science & Cosmos',
                'slug' => 'science-cosmos',
                'description' => 'Astrophysics, orbital mechanics, quantum phenomena, and cosmic evolution.',
                'icon' => 'fa-solid fa-flask',
                'color_theme' => 'violet',
                'bg_gradient' => 'from-violet-600/20 via-purple-600/10 to-indigo-600/20',
            ],
            [
                'name' => 'Modern Web & React',
                'slug' => 'modern-web-react',
                'description' => 'React 19, Next.js architecture, state topologies, and browser rendering engines.',
                'icon' => 'devicon-react-original colored',
                'color_theme' => 'cyan',
                'bg_gradient' => 'from-cyan-600/20 via-sky-600/10 to-blue-600/20',
            ],
            [
                'name' => 'Python & Machine Learning',
                'slug' => 'python-ai-ml',
                'description' => 'PyTorch primitives, transformers, neural optimizations, and data paradigms.',
                'icon' => 'devicon-python-plain colored',
                'color_theme' => 'emerald',
                'bg_gradient' => 'from-emerald-600/20 via-teal-600/10 to-green-600/20',
            ],
            [
                'name' => 'Cloud & Distributed Systems',
                'slug' => 'cloud-distributed-systems',
                'description' => 'Kubernetes, consensus protocols, Kafka event pipelines, and edge compute.',
                'icon' => 'devicon-docker-plain colored',
                'color_theme' => 'blue',
                'bg_gradient' => 'from-blue-600/20 via-indigo-600/10 to-violet-600/20',
            ],
            [
                'name' => 'Cybersecurity & Cryptography',
                'slug' => 'cybersecurity-cryptography',
                'description' => 'Zero-trust architecture, TLS 1.3, buffer mitigations, and post-quantum keys.',
                'icon' => 'fa-solid fa-shield-halved',
                'color_theme' => 'rose',
                'bg_gradient' => 'from-rose-600/20 via-pink-600/10 to-red-600/20',
            ],
            [
                'name' => 'Backend Architecture & Node',
                'slug' => 'backend-architecture-node',
                'description' => 'Node event loops, ACID guarantees, Redis cache layers, and DB indexing.',
                'icon' => 'devicon-nodejs-plain colored',
                'color_theme' => 'amber',
                'bg_gradient' => 'from-amber-600/20 via-yellow-600/10 to-orange-600/20',
            ],
            [
                'name' => 'Civilizations & Ancient History',
                'slug' => 'civilizations-history',
                'description' => 'Mesopotamia, Bronze Age collapses, Hellenistic strategy, and Silk Road trade.',
                'icon' => 'fa-solid fa-landmark',
                'color_theme' => 'amber',
                'bg_gradient' => 'from-amber-700/20 via-yellow-700/10 to-stone-600/20',
            ],
            [
                'name' => 'Cyberculture & Video Games',
                'slug' => 'cyberculture-gaming',
                'description' => 'Game mechanics, engine pipelines, demo-scene lore, and competitive esports history.',
                'icon' => 'fa-solid fa-gamepad',
                'color_theme' => 'violet',
                'bg_gradient' => 'from-purple-600/20 via-fuchsia-600/10 to-pink-600/20',
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::create($cat);
        }

        // 4. Quizzes & Real Questions
        $quizzesData = [
            [
                'title' => 'Quantum Frontiers & Cosmic Horizons',
                'slug' => 'quantum-frontiers-cosmic-horizons',
                'category_slug' => 'science-cosmos',
                'difficulty' => 'hard',
                'time_limit_per_question' => 25,
                'xp_reward' => 280,
                'is_featured' => true,
                'description' => 'Test your grasp on black hole event horizons, quantum entanglement, and cosmological expansion.',
                'questions' => [
                    [
                        'text' => 'What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 30,
                        'explanation' => 'The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).',
                        'options' => [
                            ['text' => 'The escape velocity equals the speed of light in vacuum', 'is_correct' => true],
                            ['text' => 'Hawking radiation completely ceases emitted particles', 'is_correct' => false],
                            ['text' => 'Matter immediately converts into high-energy dark photons', 'is_correct' => false],
                            ['text' => 'Time accelerates towards positive infinity for outside observers', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which particle is postulated to mediate the gravitational interaction in quantum field theory?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 30,
                        'explanation' => 'The graviton is the hypothetical massless spin-2 boson mediating gravitation.',
                        'options' => [
                            ['text' => 'Graviton (spin-2 massless boson)', 'is_correct' => true],
                            ['text' => 'Higgs Boson (spin-0 scalar boson)', 'is_correct' => false],
                            ['text' => 'Gluon (spin-1 color charge carrier)', 'is_correct' => false],
                            ['text' => 'Axion (spin-0 pseudo-Nambu-Goldstone boson)', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:',
                        'type' => 'multiple_choice',
                        'difficulty' => 'hard',
                        'points' => 40,
                        'explanation' => 'The CMB has a thermal black body spectrum at 2.72548 ± 0.00057 Kelvin.',
                        'options' => [
                            ['text' => '2.73 Kelvin', 'is_correct' => true],
                            ['text' => '0.55 Kelvin', 'is_correct' => false],
                            ['text' => '4.20 Kelvin', 'is_correct' => false],
                            ['text' => '7.85 Kelvin', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).',
                        'type' => 'true_false',
                        'difficulty' => 'medium',
                        'points' => 20,
                        'explanation' => 'The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.',
                        'options' => [
                            ['text' => 'False - The No-Communication Theorem forbids superluminal signaling', 'is_correct' => true],
                            ['text' => 'True - Entangled states enable immediate information broadcast', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'React 19 & Next.js Architecture Deep Dive',
                'slug' => 'react-19-nextjs-architecture',
                'category_slug' => 'modern-web-react',
                'difficulty' => 'hard',
                'time_limit_per_question' => 20,
                'xp_reward' => 240,
                'is_featured' => true,
                'description' => 'Master React Server Components, Actions, useActionState, Suspense boundaries, and selective hydration.',
                'questions' => [
                    [
                        'text' => 'In React 19, what hook replaces the conventional manual status handling pattern with form transitions?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 30,
                        'explanation' => 'useActionState allows updating state based on the result of a form action, managing pending states automatically.',
                        'options' => [
                            ['text' => 'useActionState', 'is_correct' => true],
                            ['text' => 'useFormTransition', 'is_correct' => false],
                            ['text' => 'useServerCallback', 'is_correct' => false],
                            ['text' => 'useMutationSync', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which of the following is true regarding React Server Components (RSC)?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'hard',
                        'points' => 35,
                        'explanation' => 'RSCs execute strictly on the server and their code dependencies are never shipped to the client JavaScript bundle.',
                        'options' => [
                            ['text' => 'Zero impact on client bundle size as their dependencies remain on server', 'is_correct' => true],
                            ['text' => 'They require useState and useEffect for lifecycle management', 'is_correct' => false],
                            ['text' => 'They re-render on the browser whenever client state changes', 'is_correct' => false],
                            ['text' => 'They cannot fetch data directly from databases via async/await', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'React 19 eliminates the need for manual memoization with useMemo and useCallback via the React Compiler.',
                        'type' => 'true_false',
                        'difficulty' => 'easy',
                        'points' => 20,
                        'explanation' => 'The React Compiler automatically memoizes component outputs and values at build time.',
                        'options' => [
                            ['text' => 'True - React Compiler automatically handles fine-grained memoization', 'is_correct' => true],
                            ['text' => 'False - Manual useMemo hooks remain strictly mandatory', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is the primary function of the directive "use client" in Next.js App Router?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 25,
                        'explanation' => '"use client" marks the boundary between server components and client-side interactive subtrees.',
                        'options' => [
                            ['text' => 'Declares a boundary where the module and its child imports run in browser runtime', 'is_correct' => true],
                            ['text' => 'Instructs Vite to build a Web Worker instance', 'is_correct' => false],
                            ['text' => 'Disables server-side prerendering completely for that route', 'is_correct' => false],
                            ['text' => 'Enables Electron desktop compatibility mode', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Python Neural Systems & PyTorch Fundamentals',
                'slug' => 'python-neural-systems-pytorch',
                'category_slug' => 'python-ai-ml',
                'difficulty' => 'medium',
                'time_limit_per_question' => 20,
                'xp_reward' => 200,
                'is_featured' => true,
                'description' => 'Autograd mechanics, tensor memory layouts, gradient accumulation, and transformer attention heads.',
                'questions' => [
                    [
                        'text' => 'In PyTorch, what operation must be invoked before backward() in a training loop to avoid accumulating stale gradients?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'easy',
                        'points' => 25,
                        'explanation' => 'optimizer.zero_grad() flushes the gradients of all optimized torch.Tensors before the next backward pass.',
                        'options' => [
                            ['text' => 'optimizer.zero_grad()', 'is_correct' => true],
                            ['text' => 'model.reset_weights()', 'is_correct' => false],
                            ['text' => 'torch.cuda.empty_cache()', 'is_correct' => false],
                            ['text' => 'loss.detach()', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is the computational complexity of standard Scaled Dot-Product Attention with respect to sequence length N?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'hard',
                        'points' => 35,
                        'explanation' => 'Full pairwise attention between all tokens in a sequence of length N results in quadratic O(N^2) complexity.',
                        'options' => [
                            ['text' => 'O(N^2)', 'is_correct' => true],
                            ['text' => 'O(N log N)', 'is_correct' => false],
                            ['text' => 'O(N)', 'is_correct' => false],
                            ['text' => 'O(1)', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'In Python 3.12+, the Global Interpreter Lock (GIL) can be optionally disabled in experimental free-threaded builds.',
                        'type' => 'true_false',
                        'difficulty' => 'medium',
                        'points' => 20,
                        'explanation' => 'PEP 703 introduced the free-threaded build option in Python 3.13 (experimental preview in 3.12).',
                        'options' => [
                            ['text' => 'True - Free-threaded Python allows true multi-core thread concurrency', 'is_correct' => true],
                            ['text' => 'False - The GIL cannot be disabled under any configuration', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Kubernetes & Distributed Consensus Protocols',
                'slug' => 'kubernetes-distributed-consensus',
                'category_slug' => 'cloud-distributed-systems',
                'difficulty' => 'hard',
                'time_limit_per_question' => 25,
                'xp_reward' => 250,
                'is_featured' => false,
                'description' => 'Raft elections, etcd leases, ingress controllers, CNI network topologies, and split-brain resolution.',
                'questions' => [
                    [
                        'text' => 'What consensus algorithm is leveraged by etcd in Kubernetes to maintain distributed cluster state?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 30,
                        'explanation' => 'etcd uses the Raft consensus algorithm for distributed leader election and replicated log consistency.',
                        'options' => [
                            ['text' => 'Raft', 'is_correct' => true],
                            ['text' => 'Multi-Paxos', 'is_correct' => false],
                            ['text' => 'Zab (ZooKeeper Atomic Broadcast)', 'is_correct' => false],
                            ['text' => 'Proof of Authority', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which Kubernetes resource guarantees that exactly one Pod replica runs on every matching node in a cluster?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'easy',
                        'points' => 25,
                        'explanation' => 'DaemonSets ensure that all (or some) Nodes run a copy of a Pod, ideal for logging or monitoring agents.',
                        'options' => [
                            ['text' => 'DaemonSet', 'is_correct' => true],
                            ['text' => 'StatefulSet', 'is_correct' => false],
                            ['text' => 'ReplicaSet', 'is_correct' => false],
                            ['text' => 'CronJob', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Post-Quantum Cryptography & Zero-Trust Defense',
                'slug' => 'post-quantum-zero-trust',
                'category_slug' => 'cybersecurity-cryptography',
                'difficulty' => 'hard',
                'time_limit_per_question' => 25,
                'xp_reward' => 275,
                'is_featured' => true,
                'description' => 'NIST post-quantum standards (ML-KEM/Kyber), mTLS authorization, memory safety, and side-channel defenses.',
                'questions' => [
                    [
                        'text' => 'Which lattice-based key encapsulation mechanism was standardized by NIST as FIPS 203 for general encryption?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'hard',
                        'points' => 35,
                        'explanation' => 'ML-KEM (originally CRYSTALS-Kyber) was selected and standardized as FIPS 203.',
                        'options' => [
                            ['text' => 'ML-KEM (CRYSTALS-Kyber)', 'is_correct' => true],
                            ['text' => 'RSA-4096 OAEP', 'is_correct' => false],
                            ['text' => 'ECDH Curve25519', 'is_correct' => false],
                            ['text' => 'Classic McEliece', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Zero-Trust Architecture principles assume the internal perimeter network is inherently secure once authenticated.',
                        'type' => 'true_false',
                        'difficulty' => 'easy',
                        'points' => 20,
                        'explanation' => 'Zero-Trust operates under "Never Trust, Always Verify", assuming hostile breach inside the network.',
                        'options' => [
                            ['text' => 'False - Zero-Trust assumes breach and verifies every request continuously', 'is_correct' => true],
                            ['text' => 'True - Internal networks are considered trusted zones', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'High-Performance Node.js & Distributed Caches',
                'slug' => 'high-performance-nodejs-caches',
                'category_slug' => 'backend-architecture-node',
                'difficulty' => 'medium',
                'time_limit_per_question' => 20,
                'xp_reward' => 210,
                'is_featured' => false,
                'description' => 'Libuv thread pools, microtask queues, Redis cluster replication, and database connection pooling.',
                'questions' => [
                    [
                        'text' => 'In the Node.js event loop, which queue has highest execution priority immediately following the current operation?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 30,
                        'explanation' => 'process.nextTick() queue executes immediately after the current operation finishes, before any other event loop phase.',
                        'options' => [
                            ['text' => 'process.nextTick queue (microtask)', 'is_correct' => true],
                            ['text' => 'setImmediate callback queue (check phase)', 'is_correct' => false],
                            ['text' => 'setTimeout timers queue (timers phase)', 'is_correct' => false],
                            ['text' => 'I/O poll events queue', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What caching anomaly occurs when multiple concurrent requests simultaneously calculate an expired key?',
                        'type' => 'multiple_choice',
                        'difficulty' => 'medium',
                        'points' => 25,
                        'explanation' => 'Cache stampede (thundering herd) occurs when key expiration causes a massive spike of concurrent database recalculations.',
                        'options' => [
                            ['text' => 'Cache Stampede / Thundering Herd', 'is_correct' => true],
                            ['text' => 'Dirty Read Anomaly', 'is_correct' => false],
                            ['text' => 'Phantom Read Spike', 'is_correct' => false],
                            ['text' => 'Write-Through Staleness', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
        ];

        $quizModels = [];
        foreach ($quizzesData as $qData) {
            $catModel = $categoryModels[$qData['category_slug']];
            $quiz = Quiz::create([
                'title' => $qData['title'],
                'slug' => $qData['slug'],
                'category_id' => $catModel->id,
                'user_id' => $creator->id,
                'difficulty' => $qData['difficulty'],
                'time_limit_per_question' => $qData['time_limit_per_question'],
                'xp_reward' => $qData['xp_reward'],
                'is_published' => true,
                'is_featured' => $qData['is_featured'],
                'plays_count' => rand(35, 340),
                'rating' => 4.8 + (rand(0, 19) / 100),
                'description' => $qData['description'],
            ]);
            $quizModels[] = $quiz;

            foreach ($qData['questions'] as $order => $quest) {
                $question = Question::create([
                    'category_id' => $catModel->id,
                    'user_id' => $creator->id,
                    'quiz_id' => $quiz->id,
                    'question_text' => $quest['text'],
                    'question_type' => $quest['type'],
                    'difficulty' => $quest['difficulty'],
                    'points' => $quest['points'],
                    'explanation' => $quest['explanation'],
                ]);

                foreach ($quest['options'] as $optOrder => $opt) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'is_correct' => $opt['is_correct'],
                        'order' => $optOrder,
                    ]);
                }
            }
        }

        // 5. Seed Realistic Quiz Attempts for Leaderboards & Analytics
        $firstQuiz = $quizModels[0];
        foreach ($playerModels as $p) {
            $score = rand(120, 360);
            $correct = rand(3, 4);
            $accuracy = round(($correct / 4) * 100, 2);
            $xp = rand(150, 320);

            QuizAttempt::create([
                'user_id' => $p->id,
                'quiz_id' => $firstQuiz->id,
                'mode' => 'standard',
                'score' => $score,
                'total_questions' => 4,
                'correct_answers' => $correct,
                'xp_earned' => $xp,
                'accuracy_percentage' => $accuracy,
                'time_taken_seconds' => rand(40, 85),
                'streak_count' => rand(2, 6),
                'answers_summary' => [],
                'completed_at' => now()->subDays(rand(0, 6))->subHours(rand(1, 23)),
            ]);
        }

        // 6. Platform Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'QuizVerse', 'type' => 'string', 'group' => 'general', 'label' => 'Application Name', 'description' => 'The brand identifier displayed across all interfaces and emails.'],
            ['key' => 'registration_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'general', 'label' => 'Public Registration', 'description' => 'Allow new players to sign up for public competitive accounts.'],
            ['key' => 'daily_xp_cap', 'value' => '3000', 'type' => 'integer', 'group' => 'gameplay', 'label' => 'Daily XP Earning Cap', 'description' => 'Maximum XP a player can acquire per UTC day to prevent botting.'],
            ['key' => 'quick_play_timer', 'value' => '15', 'type' => 'integer', 'group' => 'gameplay', 'label' => 'Quick Play Timer (seconds)', 'description' => 'Countdown duration for rapid blitz matchmaking.'],
            ['key' => 'streak_protection_coins', 'value' => '250', 'type' => 'integer', 'group' => 'gameplay', 'label' => 'Streak Shield Coin Cost', 'description' => 'In-game currency required to freeze a broken streak.'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'security', 'label' => 'Maintenance Guard', 'description' => 'Restrict site access to administrators during database migrations.'],
            ['key' => 'ad_banner_active', 'value' => 'true', 'type' => 'boolean', 'group' => 'monetization', 'label' => 'Global Ad Banners', 'description' => 'Display verified sponsor banners on player dashboard.'],
        ];

        foreach ($settings as $st) {
            PlatformSetting::create($st);
        }

        // 7. Audit Logs (Security & Admin activities)
        $auditEvents = [
            ['action' => 'system_boot', 'severity' => 'info', 'entity_type' => 'System', 'entity_id' => 1, 'details' => ['version' => '2026.4.1', 'environment' => 'production', 'status' => 'operational']],
            ['action' => 'role_assigned', 'severity' => 'warning', 'entity_type' => 'User', 'entity_id' => $admin->id, 'details' => ['assigned_by' => 'Root Initializer', 'role' => 'Super Administrator']],
            ['action' => 'quiz_published', 'severity' => 'info', 'entity_type' => 'Quiz', 'entity_id' => 1, 'details' => ['slug' => 'quantum-frontiers-cosmic-horizons', 'author' => 'Dr. Elena Rostova']],
            ['action' => 'security_audit', 'severity' => 'security', 'entity_type' => 'Firewall', 'entity_id' => null, 'details' => ['scanned_ips' => 1420, 'anomalies_detected' => 0, 'status' => 'clean']],
            ['action' => 'settings_updated', 'severity' => 'info', 'entity_type' => 'PlatformSetting', 'entity_id' => 3, 'details' => ['key' => 'daily_xp_cap', 'old_value' => '2500', 'new_value' => '3000']],
        ];

        foreach ($auditEvents as $ev) {
            AuditLog::create([
                'user_id' => $admin->id,
                'action' => $ev['action'],
                'severity' => $ev['severity'],
                'entity_type' => $ev['entity_type'],
                'entity_id' => $ev['entity_id'],
                'details' => $ev['details'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'QuizVerse Engine Automated Kernel',
                'created_at' => now()->subHours(rand(2, 72)),
            ]);
        }

        // 8. Campaigns / Ads
        Campaign::create([
            'title' => 'DevPulse 2026 Global AI & Cloud Summit',
            'type' => 'banner',
            'status' => 'active',
            'badge_text' => 'SPONSORED',
            'cta_text' => 'Claim Free Pass',
            'target_url' => 'https://devpulse.io/summit-2026',
            'content' => 'Join 45,000+ engineers discussing frontier models, distributed rust systems, and quantum compilation.',
            'impressions' => 14280,
            'clicks' => 842,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25),
        ]);

        Campaign::create([
            'title' => 'Quantum Cloud Workstations - 30 Days Free',
            'type' => 'sponsored',
            'status' => 'active',
            'badge_text' => 'PARTNER OFFER',
            'cta_text' => 'Deploy Now',
            'target_url' => 'https://quantumcloud.dev/free-tier',
            'content' => 'Spin up 8x H100 clusters with instantaneous cold boot latency. Zero credit card needed.',
            'impressions' => 9650,
            'clicks' => 512,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(18),
        ]);
    }
}
